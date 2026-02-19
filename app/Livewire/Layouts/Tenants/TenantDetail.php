<?php

namespace App\Livewire\Layouts\Tenants;
use Livewire\Component;
use Livewire\Attributes\On;

class TenantDetail extends Component
{
    public $currentTenantId = null;
    public $currentTenant = null;

    #[On('tenantSelected')]
    public function loadTenant(int $tenantId): void
    {
        $tenant = \App\Models\User::where('user_id', $tenantId)
            ->where('role', 'tenant')
            ->with([
                'leases' => fn($q) => $q->latest()->limit(1)->with([
                    'bed.unit.property',
                    'billings' => fn($q) => $q->latest()->limit(1)
                ])
            ])
            ->first();

        if (!$tenant) {
            $this->resetTenantData();
            return;
        }

        $lease   = $tenant->leases->first();
        $bed     = $lease?->bed;
        $unit    = $bed?->unit;
        $property = $unit?->property;
        $billing = $lease?->billings->first();

        $this->currentTenantId = $tenantId;
        $this->currentTenant = [
            'personal_info' => [
                'first_name' => $tenant->first_name,
                'last_name'  => $tenant->last_name,
                'address'    => $property?->address,
                'property'   => $property?->building_name,
                'unit'       => $unit?->unit_number,
            ],
            'contact_info' => [
                'contact_number' => $tenant->contact,
                'email'          => $tenant->email,
            ],
            'rent_details' => [
                'bed_number'       => $bed?->bed_number,
                'dorm_type'        => $unit?->occupants,
                'lease_start_date' => $lease?->start_date?->format('Y-m-d'),
                'lease_end_date'   => $lease?->end_date?->format('Y-m-d'),
                'lease_term'       => $lease?->term,
                'shift'            => $lease?->shift,
                'auto_renew'       => $lease?->auto_renew,
            ],
            'move_in_details' => [
                'move_in_date'     => $lease?->move_in?->format('Y-m-d'),
                'monthly_rate'     => $lease?->contract_rate,
                'security_deposit' => $lease?->security_deposit,
                'payment_status'   => $billing?->status ?? 'No billing',
            ],
        ];
    }

    private function resetTenantData(): void
    {
        $this->currentTenantId = null;
        $this->currentTenant = null;
    }

    // Placeholder for "Transfer" button
    public function transferTenant(): void
    {
        if ($this->currentTenantId) {
            // Add your logic for transferring the tenant here
            // e.g., $this->dispatch('openTransferModal', tenantId: $this->currentTenantId);
            logger('Transfer tenant ' . $this->currentTenantId);
        }
    }

    // Placeholder for "Move Out" button
    public function moveOutTenant(): void
    {
        if ($this->currentTenantId) {
            // Add your logic for moving out the tenant here
            // e.g., $this->dispatch('openMoveOutModal', tenantId: $this->currentTenantId);
            logger('Move out tenant ' . $this->currentTenantId);
        }
    }

    public function render()
    {
        return view('livewire.layouts.tenants.tenant-detail');
    }
}
