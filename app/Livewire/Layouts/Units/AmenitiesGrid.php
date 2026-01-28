<?php

namespace App\Livewire\Layouts\Units;
use Livewire\Component;

class AmenitiesGrid extends Component
{
    public $amenities = [];

    public function mount($amenities = [])
    {
        $this->amenities = $amenities;
    }

    public function render()
    {
        return view('livewire.layouts.units.amenities-grid');
    }
}
