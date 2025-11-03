<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use App\Models\Property;
use App\Models\Unit;
use Illuminate\Support\Facades\Http;

class AddUnit extends Component
{
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
    public $utility_subsidy = false; // This property already exists for "Utility Subsidy"
    public $unit_capacity;
    public $room_capacity;
    public $room_type;
    public $room_cap;
    public $unit_cap;

    // --- Step 2 Properties ---
    public $model_amenities = [];
    public $amenity_labels = [];

    // 💡 REVISED: Form properties for Step 2 based on your new list
    public $amenities_features = [
        'ac_unit' => false,
        'hot_cold_shower' => false,
        'free_wifi' => false,
        'fully_furnished' => false,
    ];
    public $bedroom_bedding = [
        'bunk_bed_mattress' => false,
        'closet_cabinet' => false,
    ];
    public $kitchen_dining = [
        'refrigerator' => false,
        'microwave' => false,
        'water_kettle' => false,
        'rice_cooker' => false,
        'dining_table' => false,
        'induction_cooker' => false,
    ];
    public $entertainment = [
        // This category is now empty based on your new list
    ];
    public $additional_items = [
        'electric_fan' => false,
        'washing_machine' => false,
    ];
    public $consumables_provided = [
        // This category is now empty based on your new list
    ];

    // 💡 REVISED: Form properties for Property Amenities (Step 2)
    public $property_amenities = [
        'access_pool' => false,
        'access_gym' => false,
        'housekeeping' => false,
    ];
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

    public function mount()
    {
        try {
            $this->properties = Property::all(['property_id', 'building_name']);
        } catch (\Exception $e) {
            $this->properties = collect([
                (object)['property_id' => 1, 'building_name' => 'Demo Property (Please Migrate)']
            ]);
        }
        $this->initializeAmenities();
    }

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

    // --- REMOVED: The updatedCurrentStep() hook is gone ---

    /**
     * Function to handle "Select All" for a specific group.
     * This contains the prediction logic
     */
    private function runPrediction()
    {
        $this->is_predicting = true;

        $dataForModel = [
            'Floor' => (int) $this->floor_number,
            'M/F' => $this->m_f,
            'Bed type' => $this->bed_type,
            'Room type' => $this->room_type,
            'Room capacity' => (int) $this->room_cap,
            'Unit capacity' => (int) $this->unit_cap,
        ];
        $dataForModel = array_merge($dataForModel, $this->model_amenities);

        try {
            // 💡 THE CRITICAL CHANGE 💡
            // We now use the Docker service name 'price_api' as the hostname.
            // Port 8000 is the port *inside* the container.
            $response = Http::post('http://price_api:8000/predict', $dataForModel);

            if ($response->successful()) {
                session()->flash('success', 'Prediction model success.');
                $this->predicted_price = $response->json('predicted_price');
            } else {
                session()->flash('error', 'Prediction model returned an error.');
                $this->predicted_price = 0;
            }
        } catch (\Exception $e) {
            // This now catches errors if the 'price_api' container is down
            session()->flash('error', 'Prediction service is offline. Using estimate.');
            $this->predicted_price = rand(5000, 15000); // Fallback to mock
        }

        $this->actual_price = $this->predicted_price;
        $this->is_predicting = false;
    }

    /**
     * Function to handle the MASTER "Select All" checkbox from Step 2.
     * This iterates and uses the existing selectAll function for each group.
     */
    public function masterSelectAll($checked)
    {
        $checked = (bool)$checked;
        $this->selectAll('amenities_features', $checked);
        $this->selectAll('bedroom_bedding', $checked);
        $this->selectAll('kitchen_dining', $checked);
        $this->selectAll('entertainment', $checked);
        $this->selectAll('additional_items', $checked);
        $this->selectAll('consumables_provided', $checked);
        $this->selectAll('property_amenities', $checked);
    }

    /**
     * Move to the next step.
     * UPDATED: nextStep()
     */
    public function nextStep()
    {
        // 1. Validate if we are on Step 1
        if ($this->currentStep == 1) {
            $this->validate($this->step1Rules);
        }

        // 2. NEW: If we are on Step 2, run the prediction
        // before we move to Step 3.
        if ($this->currentStep == 2) {
            $this->runPrediction();
        }

        // 3. Go to the next step
        if ($this->currentStep < count($this->steps)) {
            $this->currentStep++;
        }
    }

    /**
     * UPDATED: previousStep()
     */
    public function previousStep()
    {
        // Reset prices when going back
        $this->predicted_price = null;
        $this->actual_price = null;

        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * UPDATED: saveUnit()
     */
    public function saveUnit()
    {
        // 1. Validate Step 1 data AND the new actual_price
        $this->validate(array_merge($this->step1Rules, [
            'actual_price' => 'required|numeric|min:0|max:999999.99'
        ]));

        if (is_null($this->predicted_price)) {
            session()->flash('error', 'Price prediction is missing.');
            return;
        }

        $checkedAmenityNames = array_keys(array_filter($this->model_amenities));

        try {
            Unit::create([
                'property_id' => $this->property_id,
                'floor_number' => $this->floor_number,
                'm/f' => $this->m_f,
                'bed_type' => $this->bed_type,
                'room_type' => $this->room_type,
                'room_cap' => $this->room_cap,
                'unit_cap' => $this->unit_cap,
                'price' => $this->actual_price, // Save the landlord's price
                'amenities' => json_encode($checkedAmenityNames),
            ]);

            session()->flash('success', 'New unit has been created successfully!');
            return redirect()->to('/property');
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving unit: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // 💡 REVISED: Helper array for display labels based on your new list
        $labels = [
            'amenities_features' => [
                'ac_unit' => 'AC Unit',
                'hot_cold_shower' => 'Hot Cold Shower',
                'free_wifi' => 'Free Wifi',
                'fully_furnished' => 'Fully Furnished',
            ],
            'bedroom_bedding' => [
                'bunk_bed_mattress' => 'Bunk Bed Mattress',
                'closet_cabinet' => 'Closet Cabinet',
            ],
            'kitchen_dining' => [
                'refrigerator' => 'Refrigerator',
                'microwave' => 'Microwave',
                'water_kettle' => 'Water Kettle',
                'rice_cooker' => 'Rice Cooker',
                'dining_table' => 'Dining Table',
                'induction_cooker' => 'Induction Cooker',
            ],
            'entertainment' => [
                // This category is now empty
            ],
            'additional_items' => [
                'electric_fan' => 'Electric Fan',
                'washing_machine' => 'Washing Machine',
            ],
            'consumables_provided' => [
                // This category is now empty
            ],
            'property_amenities' => [
                'access_pool' => 'Access Pool',
                'access_gym' => 'Access Gym',
                'housekeeping' => 'Housekeeping',
            ],
        ];

        // Calculate the amenity count every time the component renders
        $this->calculateAmenityCount();

        return view('livewire.layouts.add-unit', [
            'labels' => $labels
        ]);
    }
}
