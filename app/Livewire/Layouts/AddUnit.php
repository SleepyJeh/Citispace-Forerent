<?php

namespace App\Livewire;

use Livewire\Component;

class AddUnit extends Component
{
    // Property to track the current step, initialized to 1
    public $currentStep = 1;

    // Array defining the steps and their labels
    public $steps = [
        1 => 'Basic Info',
        2 => 'Capacity',
        3 => 'Amenities',
        4 => 'Price Prediction',
    ];

    // Form properties for Step 1
    public $unit_number;
    public $property_type;
    public $address;
    public $floor_level;
    public $view_type;
    public $property_manager;
    public $parking_available = false;

    // Form properties for Step 2 (Capacity)
    public $square_area;
    public $bedroom_count;
    public $bathroom_count;
    public $total_beds;
    public $kitchen_count; // Changed to count, assuming it's a number
    public $maximum_occupancy;

    // 💡 NEW: Form properties for Step 3 (Amenities)
    // Using associative arrays to store checkbox states for each item
    public $amenities_features = [
        'air_conditioning' => false,
        'hot_cold_shower' => false,
        'fast_wifi' => false,
    ];
    public $bedroom_bedding = [
        'queen_bed' => false,
        'sofa_bed' => false,
        'beddings_pillows_duvet' => false,
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
        'toothpaste_1' => false, // Using _1 and _2 because image shows two toothpastes
        'toothpaste_2' => false,
        'bath_soap' => false,
        'hand_soap' => false,
        'bathroom_tissue' => false,
        'bath_towels' => false,
        'slippers' => false,
    ];


    /**
     * Move to the next step, ensuring it doesn't exceed the max step.
     */
    public function nextStep()
    {
        // Add validation logic here before advancing for the current step
        if ($this->currentStep < count($this->steps)) {
            $this->currentStep++;
        }
    }

    /**
     * Move to the previous step, ensuring it doesn't go below step 1.
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
        // Add your final form submission/save logic here
        session()->flash('message', 'Unit successfully added!');
        // Optionally redirect or reset component properties
        // return redirect()->to('/admin/units');
    }


    /**
     * Renders the component's view.
     */
    public function render()
    {
        return view('livewire.add-unit');
    }
}
