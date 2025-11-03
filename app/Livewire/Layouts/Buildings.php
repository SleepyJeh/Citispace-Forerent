<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Buildings extends Component
{
    public string $image = "images/image.png";
    public string $title = "";
    public string $address = "";

    public function render()
    {
        return view('livewire.layouts.buildingcard');
    }
}
