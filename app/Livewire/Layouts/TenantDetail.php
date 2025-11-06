<?php

namespace App\Livewire\Layouts;

use App\Models\User;
use App\Models\Lease;
use Livewire\Component;
use Livewire\Attributes\On;

class TenantDetail extends Component
{
    public $currentTenantId = null;
    public $currentTenant = null;
    public $lease = null;
    public $currentUnit = null;
    public $currentBed = null;
    public $dormType = null;
    public $currentFloor = null;
    public $currentBuilding = null;
    public $currentAddress = null;

    /*----------------------------------
    | LIFECYCLE HOOKS
    ----------------------------------*/
    public function mount(): void
    {
        // Initialize empty state
    }

    /*----------------------------------
    | LISTENERS
    ----------------------------------*/

    public function moveOut(): void
    {
        if ($this->currentTenantId && $this->lease) {
            // Dispatch event to show the move out modal
            $this->dispatch('showMoveOutTenantModal',
                tenantId: $this->currentTenantId,
                leaseId: $this->lease->id
            );
        }
    }

    #[On('tenantMovedOut')]
    public function handleTenantMoveOut()
    {
        // Reset the tenant detail view after successful move out
        $this->resetTenantData();

        // Optionally dispatch an event to refresh the tenant list in sidebar
        $this->dispatch('refreshTenantList');
    }

    #[On('tenantSelected')]
    public function loadTenant(?int $tenantId): void
    {
        // Guard against null tenant ID
        if (!$tenantId) {
            $this->resetTenantData();
            return;
        }

        $this->currentTenantId = $tenantId;
        $this->currentTenant = User::find($tenantId);

        // If tenant not found, reset data
        if (!$this->currentTenant) {
            $this->resetTenantData();
            return;
        }

        // Load the tenant's active lease
        $this->lease = $this->getTenantLease($tenantId);

        // Get unit and bed information if lease exists
        if ($this->lease && $this->lease->bed) {
            $this->currentBed = $this->lease->bed->bed_number ?? 'N/A';
            $this->dormType = $this->lease->bed->unit->occupants ?? 'N/A';
            $this->currentUnit = $this->lease->bed->unit->unit_number ?? 'N/A';

            // Get floor and building name
            $this->currentFloor = $this->lease->bed->unit->floor_number ?? 'N/A';
            $this->currentBuilding = $this->lease->bed->unit->property->building_name ?? 'N/A';
            $this->currentAddress = $this->lease->bed->unit->property->address ?? 'N/A';
        }
    }

    #[On('tenantUpdated')]
    public function refreshTenantData($tenantId): void
    {
        // Reload the tenant data after edit
        $this->loadTenant($tenantId);
    }

    #[On('tenantModalClosed')]
    public function refreshOnModalClose(): void
    {
        // Reload current tenant data when modal is closed
        if ($this->currentTenantId) {
            $this->loadTenant($this->currentTenantId);
        }
    }

    #[On('tenantTransferred')]
    public function refreshAfterTransfer()
    {
        if ($this->currentTenantId) {
            $this->loadTenant($this->currentTenantId);
        }

        // Optionally also refresh tenant list if shown elsewhere
        $this->dispatch('refreshTenantList');
    }


    /*----------------------------------
    | UI ACTIONS
    ----------------------------------*/
    public function transfer(): void
    {
        if ($this->currentTenantId && $this->lease) {
            // Dispatch event to open transfer modal with current tenant info
            $this->dispatch('openTransferModal',
                tenantId: $this->currentTenantId,
                leaseId: $this->lease->id
            );
        }
    }

    /*----------------------------------
    | HELPERS
    ----------------------------------*/
    private function resetTenantData(): void
    {
        $this->currentTenantId = null;
        $this->currentTenant = null;
        $this->lease = null;
        $this->currentUnit = null;
        $this->currentBed = null;
        $this->dormType = null;
        $this->currentFloor = null;
        $this->currentBuilding = null;
        $this->currentAddress = null;
    }

    private function getTenantLease(int $tenantId): ?Lease
    {
        // Get the most recent active lease for this tenant
        // Using the relationship chain: Lease -> Bed -> Unit -> Property
        $lease = Lease::with(['bed.unit.property'])
            ->where('tenant_id', $tenantId) // Fixed: changed 'tenant_id' to 'user_id'
            ->where('status', 'Active')
            ->get()
            ->filter(function ($lease) {
                // Filter leases by units managed by the authenticated manager
                return $lease->bed &&
                    $lease->bed->unit &&
                    $lease->bed->unit->manager_id == auth()->id();
            })
            ->sortByDesc('start_date')
            ->first();

        return $lease;
    }

    public function render()
    {
        return view('livewire.layouts.tenant-detail');
    }
}
