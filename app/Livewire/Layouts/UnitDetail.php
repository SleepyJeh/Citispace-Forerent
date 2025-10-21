<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed; // Import the Computed attribute

class UnitDetail extends Component
{
    public ?array $unit = null;
    public string $activeTab = 'current'; // To manage the active tab state
    public string $maintenanceFilter = 'pending'; // Filter for maintenance requests, default to 'pending'

    public function mount()
    {
        $this->unit = $this->getUnitById(1);
    }

    #[On('unitSelected')]
    public function updateUnit(int $unitId)
    {
        $this->unit = $this->getUnitById($unitId);
        $this->activeTab = 'current'; // Reset to the default tab
        $this->maintenanceFilter = 'pending'; // Reset filter when unit changes
    }

    /**
     * Set the active tab.
     */
    public function selectTab(string $tabName)
    {
        $this->activeTab = $tabName;
    }

    /**
     * Set the maintenance request filter from the dropdown.
     */
    public function setMaintenanceFilter(string $filter)
    {
        // Validate the filter value before setting it
        if (in_array($filter, ['all', 'pending', 'on hold', 'completed'])) {
            $this->maintenanceFilter = $filter;
        }
    }

    /**
     * Get the display name for the current filter to show on the button.
     */
    public function getFilterDisplayName(): string
    {
        return match ($this->maintenanceFilter) {
            'pending' => 'Pending Requests',
            'on hold' => 'On Hold',
            'completed' => 'Completed',
            default => 'All Requests',
        };
    }

    /**
     * A computed property to get the filtered maintenance requests.
     * This ensures the list updates automatically when the filter changes.
     */
    #[Computed]
    public function filteredMaintenanceRequests(): array
    {
        if (!$this->unit || empty($this->unit['maintenance_requests'])) {
            return [];
        }

        if ($this->maintenanceFilter === 'all') {
            return $this->unit['maintenance_requests'];
        }

        return collect($this->unit['maintenance_requests'])
            ->filter(fn($request) => strtolower($request['status']) === $this->maintenanceFilter)
            ->all();
    }

    private function getUnitById(int $id): ?array
    {
        $allUnits = $this->getDefaultUnits();
        $unitData = collect($allUnits)->firstWhere('id', $id);

        if (!$unitData) {
            return null;
        }
        if ($id === 1) {
            return $unitData;
        }
        $template = $allUnits[0];
        return [
            'id' => $id,
            'building' => $template['building'],
            'unit_number' => 'Unit ' . (100 + $id - 1),
            'address' => $template['address'],
            'status' => 'Vacant',
            'specifications' => $template['specifications'],
            'current_tenant' => null,
            'past_tenants' => [],
            'maintenance_requests' => [],
        ];
    }

    private function getDefaultUnits(): array
    {
        return [
            [
                'id' => 1,
                'building' => 'The Ridge Wood',
                'unit_number' => 'Unit 101',
                'address' => 'Taguig, 1634 Metro Manila, Philippines',
                'status' => 'Occupied',
                'specifications' => ['guests' => 3, 'bedroom' => 1, 'restroom' => 1, 'kitchen' => 1, 'area' => '656 Sqm'],
                'current_tenant' => ['name' => 'Nicole Candelaria', 'phone' => '09456570000', 'email' => 'ninole@gmail.com', 'lease_start' => 'November 3, 2025', 'lease_end' => 'November 3, 2026', 'rental_price' => '₱ 25,000', 'deposit' => '₱ 25,000', 'deposit_status' => 'Completed'],
                'past_tenants' => [['name' => 'John Doe', 'lease_start' => 'January 28, 2024', 'lease_end' => 'January 28, 2025', 'lease_type' => 'Yearly'], ['name' => 'Jane Smith', 'lease_start' => 'February 15, 2023', 'lease_end' => 'February 15, 2024', 'lease_type' => 'Yearly']],
                'maintenance_requests' => [['description' => 'Leaky Faucet', 'date' => 'June 28, 2025', 'status' => 'Pending'], ['description' => 'Air Conditioning Repair', 'date' => 'June 28, 2025', 'status' => 'On Hold'], ['description' => 'Door Lock Issue', 'date' => 'June 28, 2025', 'status' => 'Completed']],
            ],
            ['id' => 2],
            ['id' => 3],
            ['id' => 4],
            ['id' => 5],
            ['id' => 6],
            ['id' => 7],
            ['id' => 8],
            ['id' => 9],
            ['id' => 10],
            ['id' => 11],
            ['id' => 12],
            ['id' => 13],
        ];
    }

    public function getStatusColor(string $status): string
    {
        return match (strtolower($status)) {
            'occupied' => 'bg-red-500',
            'vacant' => 'bg-blue-500',
            default => 'bg-gray-500',
        };
    }

    public function getMaintenanceStatusColor(string $status): array
    {
        // Updated colors to more closely match the provided screenshot
        return match (strtolower($status)) {
            'pending' => ['bg' => 'bg-yellow-300', 'text' => 'text-yellow-800', 'border' => 'border-yellow-400', 'icon_color' => 'text-yellow-500'],
            'on hold' => ['bg' => 'bg-red-300', 'text' => 'text-red-800', 'border' => 'border-red-400', 'icon_color' => 'text-red-500'],
            'completed' => ['bg' => 'bg-green-300', 'text' => 'text-green-800', 'border' => 'border-green-400', 'icon_color' => 'text-green-500'],
            default => ['bg' => 'bg-gray-200', 'text' => 'text-gray-800', 'border' => 'border-gray-400', 'icon_color' => 'text-gray-500'],
        };
    }

    public function render()
    {
        return view('livewire.layouts.unit-specification');
    }
}
