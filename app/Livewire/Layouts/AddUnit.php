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
    public $utility_subsidy = false; // This property already exists for "Utility Subsidy"
    public $unit_capacity;
    public $room_capacity;

    // 💡 NEW: Property for the editable price in Step 3
    public $predicted_price = 29000;

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

    // Public property to hold the dynamic amenity count
    public $amenityCount = 0;


    /**
     * Function to handle "Select All" for a specific group.
     */
    public function selectAll($property, $checked)
    {
        if (property_exists($this, $property) && is_array($this->$property)) {
            $this->$property = array_fill_keys(array_keys($this->$property), (bool)$checked);
        }
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
