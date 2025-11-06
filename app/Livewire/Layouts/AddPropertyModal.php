<?php

namespace App\Livewire\Layouts;

use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Validate;

class AddPropertyModal extends Component
{
    /** Modal visibility */
    public $isOpen = false;

    /** Unique modal instance */
    public $modalId;

    /** Form fields */
    #[Validate('required|string|max:255')]
    public $buildingName = '';

    #[Validate('required|string')]
    public $address = '';

    #[Validate('required|string')]
    public $description = '';


    public function mount($modalId = null)
    {
        $this->modalId = $modalId ?? uniqid('add_property_modal_');
    }

    protected function getListeners(): array
    {
        return [
            "openAddPropertyModal_{$this->modalId}" => 'open',
        ];
    }


    public function open(): void
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->resetForm();
        $this->resetValidation();
        $this->isOpen = false;
        $this->dispatch('propertyModalClosed');
    }

    public function next(): void
    {
        // Validate current step
        $this->validate();

        // Save property and proceed to next step (units/beds creation)
        $property = Property::create([
            'owner_id' => Auth::id(),
            'building_name' => $this->buildingName,
            'address' => $this->address,
            'prop_description' => $this->description,
        ]);

        session()->flash('message', 'Property created successfully! Now you can add units.');

        $this->close();

        // Redirect to property units page or trigger next modal
        $this->dispatch('propertyCreated', $property->property_id);
        $this->dispatch('refresh-property-list');
    }


    private function resetForm(): void
    {
        $this->reset([
            'buildingName',
            'address',
            'description',
        ]);
    }


    public function render()
    {
        return view('livewire.layouts.add-property-modal');
    }
}
