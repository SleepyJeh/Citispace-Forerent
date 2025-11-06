<?php

namespace App\Livewire\Layouts;

use App\Models\Property;
use Livewire\Component;

class BuildingList extends Component
{
    public $properties = [];
    public $selectedPropertyId = null;

    public function mount()
    {
        $managerId = auth()->id();

        $this->properties = Property::with('units')
            ->get()
            ->filter(fn ($property) =>
            $property->units->contains(fn ($unit) => $unit->manager_id === $managerId)
            )
            ->values();

        \Log::info('🏢 BuildingList mounted', [
            'properties_count' => count($this->properties),
            'selectedPropertyId' => $this->selectedPropertyId,
            'managerId' => $managerId
        ]);
    }

    public function selectProperty($propertyId)
    {
        $this->selectedPropertyId = (int)$propertyId;

        \Log::info('🏢 BuildingList dispatching propertySelected', [
            'propertyId' => $this->selectedPropertyId,
            'type' => gettype($this->selectedPropertyId)
        ]);

        // Dispatch the event globally so TenantNavigation can receive it
        $this->dispatch('propertySelected', propertyId: $this->selectedPropertyId);
    }

    public function render()
    {
        return view('livewire.layouts.building-list');
    }
}
