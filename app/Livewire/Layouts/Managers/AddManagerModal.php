<?php

namespace App\Livewire\Layouts\Managers;

use App\Livewire\Forms\AddUserForm;
use App\Models\{Property, Unit, User};
use Illuminate\Support\Facades\Auth;
use Livewire\{Component, WithFileUploads};
use Livewire\Attributes\Validate;

class AddManagerModal extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $modalId;

    #[Validate('nullable|image|max:2048')]
    public $profilePicture = null;

    public AddUserForm $userForm;

    #[Validate('nullable')]
    public $selectedBuilding = '';

    #[Validate('nullable')]
    public $selectedFloor = '';

    #[Validate('nullable')]
    public $selectedUnits = [];

    public $buildings = [];
    public $floors = [];
    public $availableUnits = [];
    public ?int $managerId = null;
    public bool $isEditing = false;

    public function mount($modalId = null)
    {
        $this->modalId = $modalId ?? uniqid('add_manager_modal_');
        $this->loadBuildings();
    }

    protected function getListeners(): array
    {
        return [
            "openAddManagerModal_{$this->modalId}" => 'open',
        ];
    }

    public function open(User $manager = null): void
    {
        $this->resetForm();

        if ($manager && $manager->exists) {
            $this->isEditing = true;
            $this->managerId = $manager->user_id;
            $this->userForm->setUser($manager);

            $this->loadExistingAssignments($manager->user_id);
        }

        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->resetForm();
        $this->resetValidation();
        $this->isOpen = false;
        $this->dispatch('managerModalClosed');
    }

    public function loadBuildings()
    {
        $this->buildings = Property::where('owner_id', Auth::id())
            ->get(['property_id', 'building_name']);
    }

    public function updatedSelectedBuilding($propertyId)
    {
        $this->selectedFloor = '';
        $this->selectedUnits = [];
        $this->floors = [];
        $this->availableUnits = [];

        if ($propertyId) {
            $this->floors = Unit::where('property_id', $propertyId)
                ->distinct()
                ->orderBy('floor_number')
                ->pluck('floor_number')
                ->toArray();
        }
    }

    public function updatedSelectedFloor($floor)
    {
        $this->availableUnits = [];

        if ($this->selectedBuilding && $floor) {
            $this->availableUnits = $this->getUnitsForFloor(
                $this->selectedBuilding,
                $floor,
                $this->managerId
            );
        }
    }

    public function save(): void
    {
        $this->validate();

        if ($this->isEditing && $this->managerId) {
            $user = User::where('user_id', $this->managerId)->first();
            $this->userForm->update($user);
            $message = 'Manager updated successfully!';
        } else {
            $user = $this->userForm->store('manager');
            $this->managerId = $user->user_id;
            $message = 'Manager created successfully!';
        }

        if (!empty($this->selectedUnits)) {
            $unitIds = array_keys(array_filter($this->selectedUnits));

            // Assign units
            Unit::whereIn('unit_id', $unitIds)->update(['manager_id' => $user->user_id]);
        }

        if ($this->profilePicture) {
            $path = $this->profilePicture->store('profile-photos', 'public');
            $user->update(['profile_img' => $path]);
        }

        session()->flash('message', $message);
        $this->close();
        $this->dispatch('refresh-manager-list');
    }

    private function loadExistingAssignments($managerId)
    {
        $firstUnit = Unit::where('manager_id', $managerId)->first();
        if ($firstUnit) {
            $this->selectedBuilding = $firstUnit->property_id;
            $this->updatedSelectedBuilding($firstUnit->property_id);
            $this->selectedFloor = $firstUnit->floor_number;
            $this->updatedSelectedFloor($firstUnit->floor_number);

            $managedUnitIds = Unit::where('manager_id', $managerId)
                ->where('property_id', $firstUnit->property_id)
                ->where('floor_number', $firstUnit->floor_number)
                ->pluck('unit_id')
                ->toArray();

            foreach ($managedUnitIds as $id) {
                $this->selectedUnits[$id] = true;
            }
        }
    }

    private function getUnitsForFloor($propertyId, $floor, $managerId = null): array
    {
        $units = Unit::where('property_id', $propertyId)
            ->where('floor_number', $floor)
            ->whereHas('property', function ($q) {
                $q->where('owner_id', Auth::id());
            })
            ->where(function ($query) use ($managerId) {
                $query->whereNull('manager_id');
                if (!is_null($managerId)) {
                    $query->orWhere('manager_id', $managerId);
                }
            })
            ->orderBy('unit_id')
            ->get(['unit_id', 'manager_id', 'unit_number']);

        return $units->map(fn($unit) => [
            'id' => $unit->unit_id,
            'number' => "Unit {$unit->unit_number}",
            'checked' => $unit->manager_id == $managerId,
        ])->toArray();
    }

    private function resetForm(): void
    {
        $this->reset(['profilePicture', 'selectedBuilding', 'selectedFloor', 'selectedUnits', 'floors', 'availableUnits', 'managerId', 'isEditing']);
        $this->userForm->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.layouts.managers.add-manager-modal');
    }
}
