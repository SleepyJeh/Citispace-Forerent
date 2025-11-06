<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\Attributes\On;

class TenantDetail extends Component
{
    public $currentTenantId = null;
    public $currentTenant = null;

    // Default dummy data for testing
    protected $dummyTenants = [
        1 => [
            'id' => 1,
            'name' => 'Ninole Candelaria',
            'address' => 'Taguig, 1634 Metro Manila, Philippines',
            'building' => 'The Ridge Wood - 4th Floor',
            'unit' => 'Unit 101',
            'contact_number' => '09457835123',
            'email' => 'ninole@gmail.com',
            'bed_number' => 'B1',
            'lease_start_date' => '2024-01-08',
            'lease_term' => '6 Months',
            'is_auto_renew' => false,
            'dorm_type' => 'Dorm Type',
            'gender' => 'All Female',
            'lease_end_date' => '2024-07-08',
            'shift' => 'Shift',
            'move_in_date' => '2024-01-06',
            'security_deposit' => 20000.00,
            'monthly_rate' => 20000.00,
            'payment_status' => 'Paid',
        ],
        2 => [
            'id' => 2,
            'name' => 'John Doe',
            'address' => 'Makati, Metro Manila, Philippines',
            'building' => 'The Residences - 2nd Floor',
            'unit' => 'Unit 202',
            'contact_number' => '09123456789',
            'email' => 'john.doe@email.com',
            'bed_number' => 'B2',
            'lease_start_date' => '2024-02-01',
            'lease_term' => '12 Months',
            'is_auto_renew' => true,
            'dorm_type' => 'Studio',
            'gender' => 'All Male',
            'lease_end_date' => '2025-02-01',
            'shift' => 'Day',
            'move_in_date' => '2024-01-28',
            'security_deposit' => 15000.00,
            'monthly_rate' => 15000.00,
            'payment_status' => 'Pending',
        ]
    ];

    #[On('tenantSelected')]
    public function loadTenant(?int $tenantId): void
    {
        if (!$tenantId || !isset($this->dummyTenants[$tenantId])) {
            $this->resetTenantData();
            return;
        }

        $this->currentTenantId = $tenantId;
        $this->currentTenant = $this->dummyTenants[$tenantId];
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
        return view('livewire.layouts.tenant-detail');
    }
}
