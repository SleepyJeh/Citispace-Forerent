<?php

namespace App\Livewire\Layouts;

use App\Livewire\Forms\AddTenantForm;
use App\Livewire\Forms\AddUserForm;
use App\Notifications\NewAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Models\{Property, Unit, Bed, User, Lease};
use App\Services\PasswordGenerator;
use Illuminate\Support\Facades\Hash;
use Livewire\{Component, WithFileUploads};
use Livewire\Attributes\Validate;

class AddTenantModal extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $modalId;

    #[Validate('nullable|image|max:2048')]
    public $profilePicture = null;

    public AddUserForm $userForm;
    public AddTenantForm $tenantForm;

    #[Validate('required')]
    public $selectedBuilding = '';

    #[Validate('required')]
    public $selectedFloor = '';

    #[Validate('required')]
    public $selectedUnit = '';

    #[Validate('required')]
    public $selectedBed = '';

    public $buildings = [];
    public $availableFloors = [];
    public $availableUnits = [];
    public $availableBeds = [];

    public ?int $tenantId = null;
    public bool $isEditing = false;
    private ?int $originalBedId = null;

    public function mount($modalId = null)
    {
        $this->modalId = $modalId ?? uniqid('add_tenant_modal_');
        $this->loadBuildings();
    }

    protected function getListeners(): array
    {
        return [
            "openAddTenantModal_{$this->modalId}" => 'open',
            "openEditTenantModal_{$this->modalId}" => 'edit',
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
        $this->userForm->resetValidation();
        $this->tenantForm->resetValidation();
        $this->isOpen = false;

        $this->dispatch('tenantModalClosed');
    }

    public function edit(int $tenantId): void
    {
        $this->resetForm();
        $this->tenantId = $tenantId;
        $this->isEditing = true;

        $tenant = User::findOrFail($tenantId);
        $this->userForm->userId = $tenantId;
        $this->userForm->firstName = $tenant->first_name;
        $this->userForm->lastName = $tenant->last_name;
        $this->userForm->email = $tenant->email;
        $this->userForm->phoneNumber = str_replace('+63', '', $tenant->contact);
        $this->profilePicture = $tenant->profile_img;

        $lease = Lease::where('tenant_id', $tenantId)->first();
        if ($lease) {
            $this->originalBedId = $lease->bed_id;
            $bed = Bed::find($lease->bed_id);
            $unit = $bed ? $bed->unit : null;

            if ($unit) {
                $this->selectedBuilding = $unit->property_id;
                $this->availableFloors = $this->getFloorsForBuilding($unit->property_id);
                $this->selectedFloor = $unit->floor_number;
                $this->availableUnits = $this->getUnitsForFloor($unit->property_id, $unit->floor_number);
                $this->selectedUnit = $unit->unit_id;
                $this->availableBeds = $this->getBedsForUnit($unit->unit_id);
            }

            $this->selectedBed = $lease->bed_id;
            $this->tenantForm->term = $lease->term;
            $this->tenantForm->shift = $lease->shift === 'Morning' ? 'Day' : 'Night';
            $this->tenantForm->autoRenewContract = $lease->auto_renew;
            $this->tenantForm->startDate = $lease->start_date->format('Y-m-d');
            $this->tenantForm->moveInDate = $lease->move_in->format('Y-m-d');
            $this->tenantForm->monthlyRate = $lease->contract_rate;
            $this->tenantForm->securityDeposit = $lease->security_deposit;
            $this->tenantForm->paymentStatus = $lease->status === 'Active' ? 'Paid' : 'Pending';
        }

        $this->isOpen = true;
    }

    public function updatedTenantFormDormType($dormType)
    {
        if ($this->selectedFloor && $this->selectedBuilding) {
            $this->availableUnits = $this->getUnitsForFloor($this->selectedBuilding, $this->selectedFloor);
            // Reset unit and bed selection when dorm type changes
            $this->selectedUnit = '';
            $this->selectedBed = '';
            $this->availableBeds = [];
        }
    }

    public function updatedSelectedBuilding($propertyId)
    {
        $this->selectedFloor = '';
        $this->selectedUnit = '';
        $this->selectedBed = '';
        $this->availableFloors = [];
        $this->availableUnits = [];
        $this->availableBeds = [];

        if ($propertyId) {
            $this->availableFloors = $this->getFloorsForBuilding($propertyId);
        }
    }

    public function updatedSelectedFloor($floorNumber)
    {
        $this->selectedUnit = '';
        $this->selectedBed = '';
        $this->availableUnits = [];
        $this->availableBeds = [];

        if ($floorNumber && $this->selectedBuilding) {
            $this->availableUnits = $this->getUnitsForFloor($this->selectedBuilding, $floorNumber);
        }
    }

    public function updatedSelectedUnit($unitId)
    {
        $this->selectedBed = '';
        $this->availableBeds = [];

        if ($unitId) {
            $this->availableBeds = $this->getBedsForUnit($unitId);
        }
    }

    public function save(): void
    {
        // Validate nested forms
        $this->userForm->validate();
        $this->tenantForm->validate();

        // Validate modal selections
        $this->validate([
            'selectedBuilding' => 'required',
            'selectedFloor'    => 'required',
            'selectedUnit'     => 'required',
            'selectedBed'      => 'required',
            'profilePicture'   => 'nullable|image|max:2048',
        ]);


        // Validation passed; continue with your save logic
        $profilePath = null;
        if ($this->profilePicture) {
            $profilePath = is_string($this->profilePicture)
                ? $this->profilePicture
                : $this->profilePicture->store('profile-pictures', 'public');
        }

        $startDate = Carbon::parse($this->tenantForm->startDate);
        $termMonths = (int) $this->tenantForm->term;
        $endDate = $startDate->copy()->addMonths($termMonths);

        if ($this->tenantId) {
            // ============================================
            // UPDATE MANAGER
            // ============================================
            $tenant = User::findOrFail($this->tenantId);

            $tenant->update([
                'first_name'  => $this->userForm->firstName,
                'last_name'   => $this->userForm->lastName,
                'contact'     => $this->userForm->phoneNumber,
                'email'       => $this->userForm->email,
                'profile_img' => $profilePath ?? $tenant->profile_img,
            ]);

        } else {
            // ============================================
            // CREATE NEW MANAGER
            // ============================================
            $password = PasswordGenerator::generate(12);

            $tenant = User::create([
                'first_name'  => $this->userForm->firstName,
                'last_name'   => $this->userForm->lastName,
                'contact'     => $this->userForm->phoneNumber,
                'email'       => $this->userForm->email,
                'password'    => Hash::make($password),
                'profile_img' => $profilePath,
                'role'        => 'tenant',
            ]);

            Notification::send($tenant, new NewAccount($this->userForm->email, $password, 'tenant'));

            $lease = Lease::create([
                'tenant_id'         => $tenant->user_id,
                'bed_id'            => $this->selectedBed,
                'status'            => $this->tenantForm->paymentStatus === 'Paid' ? 'Active' : 'Expired',
                'term'              => $this->tenantForm->term,
                'shift'             => $this->tenantForm->shift,
                'auto_renew'        => $this->tenantForm->autoRenewContract,
                'start_date'        => $this->tenantForm->startDate,
                'end_date'          => $endDate,
                'contract_rate'     => $this->tenantForm->monthlyRate,
                'advance_amount'    => $this->tenantForm->monthlyRate,
                'security_deposit'  => $this->tenantForm->securityDeposit,
                'move_in'           => $this->tenantForm->moveInDate,
            ]);

            $bed = Bed::findOrFail($this->selectedBed);
            $bed->update([
               'status' => 'Occupied',
            ]);

            session()->flash('message', 'Tenant created successfully.');
        }

        $this->close();
        $this->dispatch('refresh-tenant-list');
    }

    private function loadBuildings(): void
    {
        $this->buildings = Property::whereHas('units.manager', fn($q) => $q->where('user_id', auth()->id()))
            ->get()
            ->map(fn($property) => [
                'property_id' => $property->property_id,
                'building_name' => $property->building_name,
            ])
            ->toArray();
    }

    private function getFloorsForBuilding($propertyId): array
    {
        return Unit::where('property_id', $propertyId)
            ->whereHas('manager', fn($q) => $q->where('user_id', auth()->id()))
            ->distinct()
            ->pluck('floor_number')
            ->sort()
            ->map(fn($floor) => ['id' => $floor, 'number' => "Floor {$floor}"])
            ->values()
            ->toArray();
    }

    private function getUnitsForFloor($propertyId, $floorNumber): array
    {
        $query = Unit::where('property_id', $propertyId)
            ->where('floor_number', $floorNumber)
            ->whereHas('manager', fn($q) => $q->where('user_id', auth()->id()));

        // Filter by dorm type if selected
        if (!empty($this->tenantForm->dormType)) {
            $query->where('occupants', $this->tenantForm->dormType);
        }

        return $query->get()
            ->map(fn($unit) => [
                'id' => $unit->unit_id,
                'number' => "Unit {$unit->unit_number}",
            ])
            ->values()
            ->toArray();
    }

    private function getBedsForUnit($unitId): array
    {
        $unit = Unit::with('beds')->find($unitId);
        if (!$unit) {
            return [];
        }

        // Get occupied beds, excluding current tenant's bed if editing
        $occupiedBedsQuery = Lease::query();
        if ($this->originalBedId) {
            $occupiedBedsQuery->where('bed_id', '!=', $this->originalBedId);
        }
        $occupiedBeds = $occupiedBedsQuery->pluck('bed_id')->toArray();

        return $unit->beds
            ->filter(fn($bed) => !in_array($bed->bed_id, $occupiedBeds))
            ->sortBy('bed_number')
            ->map(fn($bed) => ['id' => $bed->bed_id, 'number' => "Bed {$bed->bed_number}"])
            ->values()
            ->toArray();
    }

    private function resetForm(): void
    {
        $this->reset([
            'profilePicture',
            'selectedBuilding',
            'selectedFloor',
            'selectedUnit',
            'selectedBed',
            'availableFloors',
            'availableUnits',
            'availableBeds',
            'tenantId',
            'isEditing',
        ]);

        $this->originalBedId = null;
        $this->userForm->reset();
        $this->tenantForm->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.layouts.add-tenant-modal');
    }
}
