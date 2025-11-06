<?php

namespace App\Livewire\Layouts;

use App\Models\User;
use App\Models\Lease;
use App\Models\Bed;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\DB;

class MoveOutTenantModal extends Component
{
    public $showModal = false;

    #[Locked]
    public $currentTenantId;

    #[Locked]
    public $leaseId;

    public function close()
    {
        $this->showModal = false;
        $this->dispatch('modalClosed');
    }

    public function cancel()
    {
        $this->close();
    }

    #[On('showMoveOutTenantModal')]
    public function showModalWindow($tenantId)
    {
        $this->currentTenantId = $tenantId;
        $this->leaseId = Lease::where('tenant_id', $tenantId)->first()->lease_id;
        $this->showModal = true;
    }

    public function moveOut()
    {
        if (!$this->currentTenantId || !$this->leaseId) {
            session()->flash('error', 'Could not process move out. Missing tenant or lease information.');
            return;
        }

        try {
            // Load the lease with bed relationship
            $lease = Lease::with('bed')->find($this->leaseId);

            if (!$lease) {
                session()->flash('error', 'Lease not found.');
                return;
            }

            // Begin transaction to ensure all operations succeed or fail together
            DB::beginTransaction();

            // Update lease status to Expired
            $lease->update([
                'status' => 'Expired',
                'move_out' => now(),
                'end_date' => now(),
            ]);

            // Update the bed status to Vacant
            if ($lease->bed) {
                $lease->bed->update([
                    'status' => 'Vacant',
                ]);
            }

            DB::commit();

            session()->flash('success', 'Tenant has been successfully moved out and bed marked as vacant.');

            $this->showModal = false;

            // Dispatch events to notify parent components
            $this->dispatch('tenantMovedOut');
            $this->dispatch('refresh-tenant-list');

            // NEW: Dispatch event to refresh navigation
            $this->dispatch('refresh-tenant-navigation');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'An error occurred while processing the move out: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.layouts.move-out-tenant-modal');
    }
}
