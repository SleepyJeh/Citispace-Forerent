<?php

namespace App\Livewire\Layouts;

use App\Livewire\Forms\AddTenantForm;
use App\Models\{Property, Unit, Bed, Lease};
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TransferTenantModal extends Component
{
    public $isOpen = false;
    public $tenantId;
    public $modalId;

    public $buildings = [];
    public $availableFloors = [];
    public $availableUnits = [];
    public $availableBeds = [];

    public $selectedBuilding = '';
    public $selectedFloor = '';
    public $selectedUnit = '';
    public $selectedBed = '';
    public $unitPrice = null; // Add this property

    public AddTenantForm $tenantForm;

    protected $listeners = ['openTransferModal' => 'open'];

    public function mount()
    {
        $this->modalId = uniqid('transfer_');
        $this->loadBuildings();
    }

    public function open($tenantId)
    {
        $this->reset(['isOpen', 'tenantId', 'availableFloors', 'availableUnits', 'availableBeds', 'selectedBuilding', 'selectedFloor', 'selectedUnit', 'selectedBed', 'unitPrice']);
        $this->tenantId = $tenantId;
        $this->isOpen = true;

        Log::info("📂 Transfer modal opened", [
            'tenant_id' => $tenantId,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    public function close()
    {
        Log::info("❌ Transfer modal closed", [
            'tenant_id' => $this->tenantId,
        ]);

        $this->reset(['isOpen']);
    }

    public function updatedTenantFormDormType($dormType)
    {
        if ($this->selectedFloor && $this->selectedBuilding) {
            $this->availableUnits = $this->getUnitsForFloor($this->selectedBuilding, $this->selectedFloor);
            // Reset unit and bed selection when dorm type changes
            $this->selectedUnit = '';
            $this->selectedBed = '';
            $this->availableBeds = [];
            $this->unitPrice = null;
            $this->tenantForm->monthlyRate = null;
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
        $this->unitPrice = null;
        $this->tenantForm->monthlyRate = null;

        if ($propertyId) {
            $this->availableFloors = $this->getFloorsForBuilding($propertyId);
        }

        Log::info("🏢 Building selected", [
            'building_id' => $propertyId,
            'available_floors' => count($this->availableFloors),
        ]);
    }

    public function updatedSelectedFloor($floorNumber)
    {
        $this->selectedUnit = '';
        $this->selectedBed = '';
        $this->availableUnits = [];
        $this->availableBeds = [];
        $this->unitPrice = null;
        $this->tenantForm->monthlyRate = null;

        if ($floorNumber && $this->selectedBuilding) {
            $this->availableUnits = $this->getUnitsForFloor($this->selectedBuilding, $floorNumber);
        }

        Log::info("🏗 Floor selected", [
            'building_id' => $this->selectedBuilding,
            'floor' => $floorNumber,
            'available_units' => count($this->availableUnits),
        ]);
    }

    public function updatedSelectedUnit($unitId)
    {
        $this->selectedBed = '';
        $this->availableBeds = [];

        if ($unitId) {
            // Get the unit and its price
            $unit = Unit::find($unitId);
            if ($unit) {
                $this->unitPrice = $unit->price;

                // Set monthly rate to unit price if empty
                if (empty($this->tenantForm->monthlyRate)) {
                    $this->tenantForm->monthlyRate = $unit->price;
                }
            }

            $this->availableBeds = $this->getBedsForUnit($unitId);
        } else {
            $this->unitPrice = null;
            $this->tenantForm->monthlyRate = null;
        }

        Log::info("🏠 Unit selected", [
            'unit_id' => $unitId,
            'available_beds' => count($this->availableBeds),
            'unit_price' => $this->unitPrice,
        ]);
    }

    public function save()
    {
        Log::info("💾 Transfer process started", [
            'tenant_id' => $this->tenantId,
            'selected_building' => $this->selectedBuilding,
            'selected_floor' => $this->selectedFloor,
            'selected_unit' => $this->selectedUnit,
            'selected_bed' => $this->selectedBed,
        ]);

        $this->validate([
            'selectedBuilding' => 'required',
            'selectedFloor' => 'required',
            'selectedUnit' => 'required',
            'selectedBed' => 'required',
        ]);

        $this->tenantForm->validate();

        $currentLease = Lease::where('tenant_id', $this->tenantId)->first();

        if ($currentLease) {
            Log::info("📜 Expiring old lease", [
                'lease_id' => $currentLease->lease_id ?? null,
                'old_bed_id' => $currentLease->bed_id,
            ]);

            $currentLease->update([
                'status' => 'Expired',
                'end_date' => $this->tenantForm->moveInDate,
                'move_out' => $this->tenantForm->moveInDate,
            ]);

            Bed::where('bed_id', $currentLease->bed_id)->update(['status' => 'Vacant']);
            Log::info("🛏 Bed marked vacant", ['bed_id' => $currentLease->bed_id]);
        }

        $endDate = Carbon::parse($this->tenantForm->startDate)
            ->addMonths((int) $this->tenantForm->term)
            ->format('Y-m-d');

        $newLease = Lease::create([
            'tenant_id'        => $this->tenantId,
            'bed_id'           => $this->selectedBed,
            'start_date'       => $this->tenantForm->startDate,
            'end_date'         => $endDate,
            'move_in'          => $this->tenantForm->moveInDate,
            'term'             => $this->tenantForm->term,
            'contract_rate'    => $this->tenantForm->monthlyRate,
            'advance_amount'   => $this->tenantForm->monthlyRate,
            'security_deposit' => $this->tenantForm->securityDeposit,
            'status'           => $this->tenantForm->paymentStatus === 'Paid' ? 'Active' : 'Expired',
            'auto_renew'       => $this->tenantForm->autoRenewContract ?? false,
            'shift'            => $this->tenantForm->shift,
        ]);

        Bed::where('bed_id', $this->selectedBed)->update(['status' => 'Occupied']);

        Log::info("✅ New lease created", [
            'new_lease_id' => $newLease->lease_id ?? null,
            'new_bed_id' => $this->selectedBed,
            'tenant_id' => $this->tenantId,
            'start_date' => $this->tenantForm->startDate,
            'end_date' => $endDate,
        ]);

        $this->dispatch('tenantTransferred');
        $this->close();
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

        // Get currently occupied beds (active leases)
        $occupiedBeds = Lease::whereNull('end_date')
            ->orWhere('status', 'Active')
            ->pluck('bed_id')
            ->toArray();

        return $unit->beds
            ->filter(fn($bed) => !in_array($bed->bed_id, $occupiedBeds))
            ->sortBy('bed_number')
            ->map(fn($bed) => ['id' => $bed->bed_id, 'number' => "Bed {$bed->bed_number}"])
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.layouts.transfer-tenant-modal');
    }
}
