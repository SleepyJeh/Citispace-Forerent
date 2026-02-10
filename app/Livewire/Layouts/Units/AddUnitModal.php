<?php

namespace App\Livewire\Layouts\Units;

use Livewire\Component;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;

class AddUnitModal extends Component
{
    public $isOpen = false;
    public $modalId;
    public $editingUnitId = null;

    // --- Navigation Properties ---
    public $currentStep = 1;
    public $steps = [
        1 => 'Unit Details',
        2 => 'Model Amenities',
        3 => 'Review & Predict',
    ];

    // --- Step 1 Properties ---
    public $properties = [];
    public $property_id;
    public $floor_number;
    public $m_f = 'Co-ed';
    public $bed_type;
    public $bed_number;
    public $utility_subsidy = false;
    public $unit_capacity;
    public $room_capacity;
    public $room_type;
    public $room_cap;
    public $unit_cap;

    // --- Step 2 Properties ---
    public $model_amenities = [];
    public $amenity_labels = [];

    // Grouped Amenities (UI toggles)
    public $amenities_features = ['ac_unit' => false, 'hot_cold_shower' => false, 'free_wifi' => false, 'fully_furnished' => false];
    public $bedroom_bedding = ['bunk_bed_mattress' => false, 'closet_cabinet' => false];
    public $kitchen_dining = ['refrigerator' => false, 'microwave' => false, 'water_kettle' => false, 'rice_cooker' => false, 'dining_table' => false, 'induction_cooker' => false];
    public $entertainment = [];
    public $additional_items = ['electric_fan' => false, 'washing_machine' => false];
    public $consumables_provided = [];
    public $property_amenities = ['access_pool' => false, 'access_gym' => false, 'housekeeping' => false];

    // --- Step 3 Properties ---
    public $predicted_price = null;
    public $actual_price;
    public $is_predicting = false;

    // --- Validation Rules ---
    protected $step1Rules = [
        'property_id' => 'required|integer|exists:properties,property_id',
        'floor_number' => 'required|integer|min:0',
        'm_f' => 'required|in:Male,Female,Co-ed',
        'bed_type' => 'required|in:Single,Bunk,Twin',
        'room_type' => 'required|in:Standard,Deluxe,Suite',
        'room_cap' => 'required|integer|min:1',
        'unit_cap' => 'required|integer|min:1',
    ];

    public function mount($modalId = null)
    {
        $this->modalId = $modalId ?? uniqid('add_unit_modal_');
        try {
            $this->properties = Property::all(['property_id', 'building_name']);
        } catch (\Exception $e) {
            $this->properties = collect([]);
        }
        $this->initializeAmenities();
    }

    protected function getListeners(): array
    {
        return [
            "openAddUnitModal_{$this->modalId}" => 'open',
        ];
    }

    #[On('open-add-unit-modal')]
    public function open($unitId = null): void
    {
        $this->resetForm();

        if ($unitId) {
            $this->editingUnitId = $unitId;
            $this->loadUnit($unitId);
        }

        $this->isOpen = true;
    }

    public function loadUnitData($id)
    {
        $unit = Unit::find($id);
        if (!$unit) return;

        // Step 1: Basic Details
        $this->property_id = $unit->property_id;
        $this->floor_number = $unit->floor_number;
        $this->m_f = $unit->{'m/f'}; // Handle special char column
        $this->bed_type = $unit->bed_type;
        $this->room_type = $unit->room_type;
        $this->room_cap = $unit->room_cap;
        $this->unit_cap = $unit->unit_cap;

        // Step 3: Prices
        $this->actual_price = $unit->price;
        $this->predicted_price = $unit->price; // Pre-fill prediction

        // Step 2: Amenities (Map JSON to Checkboxes)
        $savedAmenities = json_decode($unit->amenities, true) ?? [];

        // Reset all checkboxes first
        $this->initializeAmenities();

        // Check the boxes that match saved data
        foreach ($savedAmenities as $amenityName) {
            // Ensure format matches keys (e.g., "Free Wifi" -> "Free_Wifi")
            $key = str_replace(' ', '_', ucwords($amenityName));

            if (array_key_exists($key, $this->model_amenities)) {
                $this->model_amenities[$key] = true;
            }
        }
    }

    public function loadUnit($unitId)
    {
        $unit = Unit::find($unitId);
        if (!$unit) return;

        // Step 1: Basic Info
        $this->property_id = $unit->property_id;
        $this->floor_number = $unit->floor_number;
        $this->m_f = $unit->{'m/f'} ?? 'Co-ed'; // Handle special char column name
        $this->bed_type = $unit->bed_type;
        $this->room_type = $unit->room_type;
        $this->room_cap = $unit->room_cap;
        $this->unit_cap = $unit->unit_cap;
        $this->actual_price = $unit->price;
        $this->predicted_price = $unit->price; // Pre-fill prediction with current price

        // Step 2: Amenities
        // DB stores keys like ["AC_Unit", "Free_Wifi"]
        $savedAmenities = json_decode($unit->amenities, true) ?? [];

        // 1. Reset all to false first
        $this->model_amenities = array_fill_keys(array_keys($this->model_amenities), false);

        // 2. Set saved ones to true
        foreach ($savedAmenities as $key) {
            if (array_key_exists($key, $this->model_amenities)) {
                $this->model_amenities[$key] = true;
            }
        }

        // 3. Sync the UI Group arrays (amenities_features, etc) based on model_amenities
        $this->syncAmenitiesToGroups();
    }

    // NEW: Helper to sync flat amenities list back to UI groups
    private function syncAmenitiesToGroups()
    {
        $groups = [
            'amenities_features',
            'bedroom_bedding',
            'kitchen_dining',
            'entertainment',
            'additional_items',
            'consumables_provided',
            'property_amenities'
        ];

        foreach ($groups as $group) {
            foreach ($this->$group as $key => $value) {
                // Convert UI key (ac_unit) to Model key (AC_Unit) if needed,
                // but currently your logic assumes specific casing.
                // We'll check if the PascalCase version exists in model_amenities.

                $pascalKey = str_replace(' ', '_', ucwords(str_replace('_', ' ', $key)));

                // Manual overrides for known mismatches if any
                if ($key == 'ac_unit') $pascalKey = 'AC_Unit';
                if ($key == 'free_wifi') $pascalKey = 'Free_Wifi';

                if (isset($this->model_amenities[$pascalKey])) {
                    $this->$group[$key] = $this->model_amenities[$pascalKey];
                }
            }
        }
    }

    public function close(): void
    {
        $this->resetForm();
        $this->resetValidation();
        $this->isOpen = false;
        $this->dispatch('unitModalClosed');
    }

    // ... (initializeAmenities, runPrediction, masterSelectAll, nextStep, previousStep stay the same) ...

    private function initializeAmenities()
    {
        $amenity_keys = [
            'Fully_furnished',
            'Free_Wifi',
            'Hot_Cold_Shower',
            'Electric_Fan',
            'Water_Kettle',
            'Closet_Cabinet',
            'Housekeeping',
            'Refrigerator',
            'Microwave',
            'Rice_Cooker',
            'Dining_Table',
            'Utility_Subsidy',
            'AC_Unit',
            'Induction_Cooker',
            'Washing_Machine',
            'Access_Pool',
            'Access_Gym',
            'Bunk_Bed_Mattress'
        ];
        $labels = [];
        foreach ($amenity_keys as $key) {
            $labels[$key] = ucwords(str_replace('_', ' ', $key));
        }
        $this->amenity_labels = $labels;
        $this->model_amenities = array_fill_keys($amenity_keys, false);
    }

    // ... (runPrediction, masterSelectAll, nextStep, previousStep hidden for brevity) ...
    public function runPrediction()
    { /* Existing Code */
    }
    public function masterSelectAll($checked)
    { /* Existing Code */
    }
    public function nextStep()
    { /* Existing Code */
    }
    public function previousStep()
    { /* Existing Code */
    }

    public function saveUnit()
    {
        $this->validate(array_merge($this->step1Rules, [
            'actual_price' => 'required|numeric|min:0|max:999999.99'
        ]));

        // Convert boolean array back to list of names
        $checkedAmenityNames = array_keys(array_filter($this->model_amenities));

        // Format names nicely (e.g., "Free_Wifi" -> "Free Wifi") for storage
        $formattedAmenities = array_map(function ($k) {
            return str_replace('_', ' ', $k);
        }, $checkedAmenityNames);

        $data = [
            'property_id' => $this->property_id,
            'floor_number' => $this->floor_number,
            'm/f' => $this->m_f,
            'bed_type' => $this->bed_type,
            'room_type' => $this->room_type,
            'room_cap' => $this->room_cap,
            'unit_cap' => $this->unit_cap,
            'price' => $this->actual_price,
            'amenities' => json_encode($formattedAmenities),
        ];

        try {
            if ($this->editingUnitId) {
                // UPDATE
                Unit::where('unit_id', $this->editingUnitId)->update($data);
                session()->flash('success', 'Unit updated successfully!');
            } else {
                // CREATE
                Unit::create($data);
                session()->flash('success', 'New unit created successfully!');
            }

            $this->close();
            $this->dispatch('refresh-unit-list'); // Updates the accordion list

        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingUnitId', // Reset edit ID
            'currentStep',
            'property_id',
            'floor_number',
            'm_f',
            'bed_type',
            'room_type',
            'room_cap',
            'unit_cap',
            'predicted_price',
            'actual_price'
        ]);
        $this->initializeAmenities();
        $this->m_f = 'Co-ed'; // Default
    }

    public function selectAll($group, $checked)
    {
        foreach ($this->$group as $key => $value) {
            $this->$group[$key] = $checked;

            // Also sync to main model_amenities
            $pascalKey = str_replace(' ', '_', ucwords(str_replace('_', ' ', $key)));
            if ($key == 'ac_unit') $pascalKey = 'AC_Unit';
            if ($key == 'free_wifi') $pascalKey = 'Free_Wifi';

            if (isset($this->model_amenities[$pascalKey])) {
                $this->model_amenities[$pascalKey] = $checked;
            }
        }
    }

    public function render()
    {
        // ... Same render function as before
        $labels = [
            'amenities_features' => ['ac_unit' => 'AC Unit', 'hot_cold_shower' => 'Hot Cold Shower', 'free_wifi' => 'Free Wifi', 'fully_furnished' => 'Fully Furnished'],
            'bedroom_bedding' => ['bunk_bed_mattress' => 'Bunk Bed Mattress', 'closet_cabinet' => 'Closet Cabinet'],
            'kitchen_dining' => ['refrigerator' => 'Refrigerator', 'microwave' => 'Microwave', 'water_kettle' => 'Water Kettle', 'rice_cooker' => 'Rice Cooker', 'dining_table' => 'Dining Table', 'induction_cooker' => 'Induction Cooker'],
            'entertainment' => [],
            'additional_items' => ['electric_fan' => 'Electric Fan', 'washing_machine' => 'Washing Machine'],
            'consumables_provided' => [],
            'property_amenities' => ['access_pool' => 'Access Pool', 'access_gym' => 'Access Gym', 'housekeeping' => 'Housekeeping'],
        ];

        return view('livewire.layouts.units.add-unit-modal', ['labels' => $labels]);
    }
}
