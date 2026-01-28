<?php
namespace App\Livewire\Layouts\Tenants;
use Livewire\Component;
use Livewire\Attributes\On;

class TenantNavigation extends Component
{
    public $tenants = [];
    public $activeTenantId = null;

    // Default dummy data for testing
    protected $dummyTenants = [
        [
            'id' => 1,
            'name' => 'Ninole Candelaria',
            'unit' => 'Unit 101',
            'bed_number' => 'B1',
            'payment_status' => 'Paid',
        ],
        [
            'id' => 2,
            'name' => 'John Doe',
            'unit' => 'Unit 202',
            'bed_number' => 'B2',
            'payment_status' => 'Pending',
        ],
        [
            'id' => 3,
            'name' => 'Maria Santos',
            'unit' => 'Unit 305',
            'bed_number' => 'A1',
            'payment_status' => 'Paid',
        ]
    ];

    public function mount($tenants = null): void
    {
        $this->tenants = $tenants ?? $this->dummyTenants;
    }

    #[On('refresh-tenant-list')]
    public function refreshTenantList(): void
    {
        $this->tenants = $this->dummyTenants; // Replace with actual data loading
    }

    #[On('tenantActivated')]
    public function activateTenant(int $tenantId): void
    {
        $this->activeTenantId = $tenantId;
    }

    public function selectTenant(int $tenantId): void
    {
        $this->activeTenantId = $tenantId;
        $this->dispatch('tenantSelected', tenantId: $tenantId);
    }

    public function render()
    {
        return view('livewire.layouts.tenants.tenant-navigation');
    }
}
