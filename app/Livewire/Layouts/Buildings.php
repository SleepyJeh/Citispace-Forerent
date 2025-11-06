<?php

namespace App\Livewire\Layouts;

use App\Models\Property;
use Livewire\Component;

class Buildings extends Component
{
    public Property $property;
    public $image;
    public $selectedPropertyId;

    public function mount(Property $property, $selectedPropertyId = null)
    {
        $this->property = $property;
        $this->selectedPropertyId = $selectedPropertyId;
        $this->image = asset('images/building_placeholder.png');
    }

    public function selectThisProperty()
    {
        \Log::info('🏢 Buildings CHILD COMPONENT dispatching', [
            'property_id' => $this->property->id,
            'property_name' => $this->property->property_name
        ]);

        // Dispatch to parent component
        $this->dispatch('property-selected', propertyId: $this->property->id);

        // Also try the parent-specific event
        $this->dispatch('propertySelectedFromChild', propertyId: $this->property->id);
    }

    public function render()
    {
        return view('livewire.layouts.buildingcard');
    }
}
