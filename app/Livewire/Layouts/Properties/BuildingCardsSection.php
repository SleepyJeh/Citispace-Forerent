<?php

namespace App\Livewire\Layouts\Properties;
use App\Models\Property;
use Livewire\Component;

class BuildingCardsSection extends Component
{
    public $properties;
    public $showAddButton = true;
    public $title = 'Buildings';
    public $emptyStateTitle = 'No properties found';
    public $emptyStateDescription = 'Get started by adding your first property.';
    public $addButtonEvent = 'openAddPropertyModal_property-dashboard';

    public function mount($properties = null, $showAddButton = true, $title = 'Buildings', $addButtonEvent = null)
    {
        // Load properties with their relationships if needed
        $this->properties = $properties ?? Property::with(['owner', 'units'])->get();
        $this->showAddButton = $showAddButton;
        $this->title = $title;
        $this->addButtonEvent = $addButtonEvent ?? 'openAddPropertyModal_property-dashboard';
    }

    public function render()
    {
        return view('livewire.layouts.properties.building-cards-section');
    }
}
