<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class AddUnit extends Component
{
    // Property to track the current step, initialized to 1
    public $currentStep = 1;

    // REVISED: Steps array changed to 3 steps
    public $steps = [
        1 => 'Basic Info',
        2 => 'Amenities',
        3 => 'Price Prediction',
    ];

    // Form properties for Step 1
    public $building_name;
    public $address;
    public $floor_number;
    public $unit_number;
    public $room_number;
    public $dorm_type;
    public $room_type;
    public $bed_type;
    public $bed_number;
    public $utility_subsidy = false;
    public $unit_capacity;
    public $room_capacity;

    // 💡 NEW: Property for the editable price in Step 3
    public $predicted_price = 29000;

    // Form properties for Step 2 (Amenities)
    public $amenities_features = [
        'air_conditioning' => false,
        'hot_cold_shower' => false,
        'fast_wifi' => false,
    ];
    public $bedroom_bedding = [
        'beddings_pillows_duvet' => false,
        'sofa_bed' => false,
    ];
    public $kitchen_dining = [
        'refrigerator' => false,
        'microwave_oven' => false,
        'oven_toaster' => false,
        'water_kettle' => false,
        'coffee_table_chairs' => false,
    ];
    public $entertainment = [
        'smart_tv_disney_plus' => false,
    ];
    public $additional_items = [
        'flat_iron' => false,
        'blower' => false,
    ];
    public $consumables_provided = [
        'toothpaste_1' => false,
        'toothpaste_2' => false,
        'bath_soap' => false,
        'hand_soap' => false,
        'bathroom_tissue' => false,
        'bath_towels' => false,
        'slippers' => false,
    ];

    // NEW: Form properties for Property Amenities (Step 2)
    public $property_amenities = [
        'pool_access' => false,
        'gym_access' => false,
        '247_cctv_security' => false,
        'laundry_access' => false,
    ];

    // Public property to hold the dynamic amenity count
    public $amenityCount = 0;


    /**
     * Function to handle "Select All" checkboxes.
     */
    public function selectAll($property, $checked)
    {
        if (property_exists($this, $property) && is_array($this->$property)) {
            $this->$property = array_fill_keys(array_keys($this->$property), (bool)$checked);
        }
    }

    /**
     * Move to the next step.
     */
    public function nextStep()
    {
        if ($this->currentStep < count($this->steps)) {
            $this->currentStep++;
        }
    }

    /**
     * Move to the previous step.
     */
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Handle the final step submission.
     */
    public function finish()
    {
        // You can now access the final price with $this->predicted_price
        session()->flash('message', 'Unit successfully added with price: ' . $this->predicted_price);
    }

    /**
     * Private helper function to calculate the total selected amenities.
     */
    private function calculateAmenityCount()
    {
        $count = 0;
        $amenityArrays = [
            'amenities_features',
            'bedroom_bedding',
            'kitchen_dining',
            'entertainment',
            'additional_items',
            'consumables_provided',
            'property_amenities',
        ];

        foreach ($amenityArrays as $group) {
            if (property_exists($this, $group) && is_array($this->$group)) {
                $count += count(array_filter($this->$group));
            }
        }
        $this->amenityCount = $count;
    }


    /**
     * Renders the component's view.
     */
    public function render()
    {
        // Helper array for display labels
        $labels = [
            'amenities_features' => [
                'air_conditioning' => 'Air Conditioning',
                'hot_cold_shower' => 'Hot & Cold Shower',
                'fast_wifi' => 'Fast Wi-Fi (50mbps Woody Fiber)',
            ],
            'bedroom_bedding' => [
                'beddings_pillows_duvet' => 'Beddings, Pillows, Duvet',
                'sofa_bed' => 'Sofa Bed',
            ],
            'kitchen_dining' => [
                'refrigerator' => 'Refrigerator',
                'microwave_oven' => 'Microwave Oven',
                'oven_toaster' => 'Oven Toaster',
                'water_kettle' => 'Water Kettle',
                'coffee_table_chairs' => 'Coffee Table & Chairs',
            ],
            'entertainment' => [
                'smart_tv_disney_plus' => '43" Smart TV With Free Disney+ Access',
            ],
            'additional_items' => [
                'flat_iron' => 'Flat Iron',
                'blower' => 'Blower',
            ],
            'consumables_provided' => [
                'toothpaste_1' => 'Toothpaste',
                'bath_soap' => 'Bath Soap',
                'bathroom_tissue' => 'Bathroom Tissue',
                'slippers' => 'Slippers',
                'toothpaste_2' => 'Toothpaste',
                'hand_soap' => 'Hand Soap',
                'bath_towels' => 'Bath Towels',
            ],
            'property_amenities' => [
                'pool_access' => 'Pool Access',
                '247_cctv_security' => '24/7 CCTV Security',
                'gym_access' => 'Gym Access',
                'laundry_access' => 'Laundry Access',
            ],
        ];

        // Calculate the amenity count every time the component renders
        $this->calculateAmenityCount();

        return view('livewire.layouts.add-unit', [
            'labels' => $labels
        ]);
    }
}
