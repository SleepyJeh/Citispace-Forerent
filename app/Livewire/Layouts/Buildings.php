<?php

namespace App\Livewire\Layouts;

use App\Models\Property;
use Livewire\Component;

class Buildings extends Component
{
    public Property $property; // <-- Accept the Property model
    // public $image; // You might need this if you add images

    public function render()
    {
        // Access data like $this->property->building_name in the view
        return view('livewire.layouts.buildingcard'); 
    }
}
