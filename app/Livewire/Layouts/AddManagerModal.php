<?php

namespace App\Livewire\Layouts;

use App\Livewire\Forms\AddUserForm;
use App\Notifications\NewAccount;
use Illuminate\Support\Facades\Notification;
use App\Models\{Property, Unit, User};
use App\Services\PasswordGenerator;
use Illuminate\Support\Facades\Hash;
use Livewire\{Component, WithFileUploads};
use Livewire\Attributes\Validate;

class AddManagerModal extends Component
{
    use WithFileUploads;

    /** Modal visibility */
    public $isOpen = false;

    /** Unique modal instance */
    public $modalId;

    /** Profile upload */
    #[Validate('nullable|image|max:2048')]
    public $profilePicture = null;

    /** User info form */
    public AddUserForm $userForm;

    /** Property assignment fields */
    #[Validate('nullable')]
    public $selectedBuilding = '';

    #[Validate('nullable')]
    public $selectedFloor = '';

    #[Validate('nullable')]
    public $selectedUnits = [];

    /** Data collections */
    public $buildings = [];
    public $floors = [];
    public $availableUnits = [];

    public ?int $managerId = null;
    public bool $isEditing = false;


    /*----------------------------------
    | LIFECYCLE
    ----------------------------------*/
    public function mount($modalId = null)
    {
        $this->modalId = $modalId ?? uniqid('add_manager_modal_');
        $this->loadBuildings();
    }

    protected function getListeners(): array
    {
        return [
            "openAddManagerModal_{$this->modalId}" => 'open',
            "openEditManagerModal_{$this->modalId}" => 'edit',
        ];
    }

    /*----------------------------------
    | UI ACTIONS
    ----------------------------------*/
    public function open(): void
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->resetForm();
        $this->resetValidation();
        $this->userForm->resetValidation();
        $this->isOpen = false;

        $this->dispatch('managerModalClosed');
    }

    public function edit(int $managerId): void
    {
        $this->resetForm();
        $this->managerId = $managerId;
        $this->isEditing = true;

        $manager = User::findOrFail($managerId);

        // Populate user form
        $this->userForm->userId = $managerId;
        $this->userForm->firstName = $manager->first_name;
        $this->userForm->lastName = $manager->last_name;
        $this->userForm->email = $manager->email;
        $this->userForm->phoneNumber = str_replace('+63', '', $manager->contact);
        $this->profilePicture = $manager->profile_img;

        // Load units managed by this manager (limited to landlord’s properties)
        $assignedUnits = Unit::where('manager_id', $managerId)
            ->whereHas('property', function ($q) {
                $q->where('owner_id', auth()->id());
            })
            ->get();

        if ($assignedUnits->isNotEmpty()) {
            $firstUnit = $assignedUnits->first();
            $this->selectedBuilding = $firstUnit->property_id;
            $this->floors = $this->getFloorsForProperty($firstUnit->property_id);
            $this->selectedFloor = $firstUnit->floor_number;

            $this->selectedUnits = $assignedUnits
                ->where('property_id', $firstUnit->property_id)
                ->where('floor_number', $firstUnit->floor_number)
                ->pluck('unit_id')
                ->toArray();

            $this->availableUnits = $this->getUnitsForFloor(
                $firstUnit->property_id,
                $firstUnit->floor_number,
                $managerId
            );
        }

        $this->isOpen = true;
    }

    /*----------------------------------
    | DATA UPDATES
    ----------------------------------*/
    public function updatedProfilePicture(): void
    {
        $this->validateOnly('profilePicture');
    }

    public function updatedSelectedBuilding($propertyId): void
    {
        $this->selectedFloor = '';
        $this->selectedUnits = [];
        $this->availableUnits = [];

        $this->floors = $propertyId
            ? $this->getFloorsForProperty($propertyId)
            : [];
    }

    public function updatedSelectedFloor($floorNumber): void
    {
        $this->selectedUnits = [];

        if ($this->selectedBuilding && $floorNumber) {
            $this->availableUnits = $this->getUnitsForFloor(
                $this->selectedBuilding,
                $floorNumber,
                $this->managerId
            );

            if ($this->managerId) {
                $this->selectedUnits = Unit::where('manager_id', $this->managerId)
                    ->where('property_id', $this->selectedBuilding)
                    ->where('floor_number', $floorNumber)
                    ->pluck('unit_id')
                    ->toArray();
            }
        } else {
            $this->availableUnits = [];
        }
    }

    /*----------------------------------
    | SAVE LOGIC
    ----------------------------------*/
    public function save(): void
    {
        $this->userForm->validate();

        // 2️⃣ Then validate this component’s own fields
        $this->validate([
            'profilePicture'   => 'nullable|image|max:2048',
            'selectedBuilding' => 'nullable',
            'selectedFloor'    => 'nullable',
            'selectedUnits'    => 'nullable|array',
        ]);

        // Validation passed; continue with your save logic
        $profilePath = null;
        if ($this->profilePicture) {
            $profilePath = is_string($this->profilePicture)
                ? $this->profilePicture
                : $this->profilePicture->store('profile-pictures', 'public');
        }

        if ($this->managerId) {
            // ============================================
            // UPDATE MANAGER
            // ============================================
            $manager = User::findOrFail($this->managerId);

            $manager->update([
                'first_name'  => $this->userForm->firstName,
                'last_name'   => $this->userForm->lastName,
                'contact'     => $this->userForm->phoneNumber,
                'email'       => $this->userForm->email,
                'profile_img' => $profilePath ?? $manager->profile_img,
            ]);

            if ($this->selectedBuilding && $this->selectedFloor) {
                // Unassign previous units (only under landlord)
                Unit::where('manager_id', $manager->user_id)
                    ->where('property_id', $this->selectedBuilding)
                    ->where('floor_number', $this->selectedFloor)
                    ->whereHas('property', fn($q) => $q->where('owner_id', auth()->id()))
                    ->update(['manager_id' => null]);

                // Assign selected units
                if (!empty($this->selectedUnits)) {
                    Unit::whereIn('unit_id', $this->selectedUnits)
                        ->whereHas('property', fn($q) => $q->where('owner_id', auth()->id()))
                        ->update(['manager_id' => $manager->user_id]);
                }
            }

            session()->flash('message', 'Manager updated successfully.');
            $this->dispatch('managerUpdated', $manager->user_id);
        } else {
            // ============================================
            // CREATE NEW MANAGER
            // ============================================
            $password = PasswordGenerator::generate(12);

            $manager = User::create([
                'first_name'  => $this->userForm->firstName,
                'last_name'   => $this->userForm->lastName,
                'contact'     => $this->userForm->phoneNumber,
                'email'       => $this->userForm->email,
                'password'    => Hash::make($password),
                'profile_img' => $profilePath,
                'role'        => 'manager',
            ]);

            Notification::send($manager, new NewAccount($this->userForm->email, $password, 'manager'));

            if (!empty($this->selectedUnits)) {
                Unit::whereIn('unit_id', $this->selectedUnits)
                    ->whereHas('property', fn($q) => $q->where('owner_id', auth()->id()))
                    ->update(['manager_id' => $manager->user_id]);
            }

            session()->flash('message', 'Manager created successfully.');
            $this->dispatch('managerCreated', $manager->user_id);
        }

        $this->close();
        $this->dispatch('refresh-manager-list');
    }

    /*----------------------------------
    | HELPER METHODS
    ----------------------------------*/
    private function loadBuildings(): void
    {
        $this->buildings = Property::where('owner_id', auth()->id())->get();
    }

    private function getFloorsForProperty($propertyId): array
    {
        return Unit::where('property_id', $propertyId)
            ->whereHas('property', function ($q) {
                $q->where('owner_id', auth()->id());
            })
            ->distinct()
            ->pluck('floor_number')
            ->sort()
            ->values()
            ->toArray();
    }

    private function getUnitsForFloor($propertyId, $floor, $managerId = null): array
    {
        // Only units owned by this landlord
        $units = Unit::where('property_id', $propertyId)
            ->where('floor_number', $floor)
            ->whereHas('property', function ($q) {
                $q->where('owner_id', auth()->id());
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
            'checked' => false,
        ])->toArray();
    }

    private function resetForm(): void
    {
        $this->reset([
            'profilePicture',
            'selectedBuilding',
            'selectedFloor',
            'selectedUnits',
            'floors',
            'availableUnits',
            'managerId',
            'isEditing',
        ]);

        $this->userForm->reset();
        $this->resetValidation();
    }

    /*----------------------------------
    | RENDER
    ----------------------------------*/
    public function render()
    {
        return view('livewire.layouts.add-manager-modal');
    }
}
