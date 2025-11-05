<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Buildings extends Component
{
<<<<<<< HEAD
    public string $image = "images/image.png";
    public string $title = "";
    public string $address = "";

    public function render()
    {
=======
    public Property $property; // <-- Accept the Property model
    // public $image; // You might need this if you add images
    public function render()
    {
        // Access data like $this->property->building_name in the view
>>>>>>> 5289b26 (local)
        return view('livewire.layouts.buildingcard');
    }
}
