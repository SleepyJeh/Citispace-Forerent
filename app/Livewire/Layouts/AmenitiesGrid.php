<?php

namespace App\Livewire\Layouts;

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
        return view('livewire.layouts.amenities-grid');
    }
}
