<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\Attributes\On;

class UnitDetail extends Component
{
    public ?array $unit = null;

    /**
     * MODIFIED:
     * Removed $activeTab, $maintenanceFilter, and related computed properties.
     * The new design does not feature them.
     */

    public function mount()
    {
        // Load the first unit by default
        $this->unit = $this->getUnitById(1);
    }

    #[On('unitSelected')]
    public function updateUnit(int $unitId)
    {
        $this->unit = $this->getUnitById($unitId);
    }

    /**
     * Helper function to get unit data.
     * In a real app, this would query the database.
     */
    private function getUnitById(int $id): ?array
    {
        $allUnits = $this->getMockUnitData();

        // Find the unit by ID, or return null if not found
        return collect($allUnits)->firstWhere('id', $id);
    }

    /**
     * MODIFIED:
     * This method is completely replaced to provide the exact data
     * structure for the new UI, including icon paths.
     */
    private function getMockUnitData(): array
    {
        // Icon paths for the 6-grid layout
        $icons = [
            'guests' => '<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />',
            'bathtub' => '<path d="M22 10.5c-.83 0-1.5.67-1.5 1.5v3c0 .55-.45 1-1 1h-1.56c-.36-2.56-2.53-4.5-5.19-4.5s-4.83 1.94-5.19 4.5H4c-.55 0-1-.45-1-1v-3c0-.83-.67-1.5-1.5-1.5S0 11.17 0 12v5h24v-5c0-.83-.67-1.5-1.5-1.5zM7.25 7.5c.97 0 1.75-.78 1.75-1.75S8.22 4 7.25 4 5.5 4.78 5.5 5.75 6.28 7.5 7.25 7.5zm-2 2h4c1.1 0 2 .9 2 2v1H3.25v-1c0-1.1.9-2 2-2z" />',
            'shower' => '<path d="M13 5.08c0-1.3-.92-2.37-2.12-2.52C9.03 2.37 7 4.29 7 6.5v8.5H6v-2c0-.55-.45-1-1-1s-1 .45-1 1v2H3c-.55 0-1 .45-1 1s.45 1 1 1h1v3c0 .55.45 1 1 1s1-.45 1-1v-3h1v3c0 .55.45 1 1 1s1-.45 1-1v-9.5c0-2.21 1.79-4 4-4 .28 0 .55.04.81.08l-1.06 1.06c-.2.2-.2.51 0 .71.2.2.51.2.71 0l2.12-2.12-2.12-2.12c-.2-.2-.51-.2-.71 0-.2.2-.2.51 0 .71l1.06 1.06zM18 12c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2s2-.9 2-2v-8c0-1.1-.9-2-2-2zm0 10c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm0-4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm0-4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" />',
            'bed' => '<path d="M21.5 10.5c-.83 0-1.5.67-1.5 1.5v2c0 .55-.45 1-1 1h-1V9c0-1.1-.9-2-2-2h-7c-.55 0-1 .45-1 1s.45 1 1 1h7v2.5c0 .83-.67 1.5-1.5 1.5S13 13.83 13 13V9c0-2.21-1.79-4-4-4S5 6.79 5 9v4H4c-.55 0-1-.45-1-1v-2c0-.83-.67-1.5-1.5-1.5S0 11.17 0 12v5h24v-5c0-.83-.67-1.5-1.5-1.5z" />',
            'money' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.9c-.6- .34-1.02-.51-1.02-.9 0-.22.19-.4.51-.4.31 0 .5.17.5.4h1.5c0-.66-.51-1.2-1.19-1.34V8h-1.6v.76c-.68.16-1.19.72-1.19 1.41 0 .8.61 1.28 1.44 1.72.6.34 1.02.51 1.02.9 0 .22-.19.4-.51.4-.31 0-.5-.17-.5-.4H8.5c0 .66.51 1.2 1.19 1.34V16h1.6v-.76c.68-.16 1.19-.72 1.19-1.41 0-.8-.61-1.28-1.44-1.72z" />'
        ];

        // Base data structure
        $baseUnit = [
            'building' => 'The Ridge Wood - 4th Floor',
            'address' => 'Taguig, 1634 Metro Manila, Philippines',
            'status' => 'Occupied',
            'status_details' => '4 out of 4',
            'specifications' => [
                ['icon' => $icons['guests'], 'value' => 4, 'label' => 'RoomCapacity'],
                ['icon' => $icons['bathtub'], 'value' => 4, 'label' => 'UnitCapacity'],
                ['icon' => $icons['shower'], 'value' => 'Shared', 'label' => 'RoomType'],
                ['icon' => $icons['bed'], 'value' => 'Top Bunk', 'label' => 'BedType'],
                ['icon' => $icons['money'], 'value' => '₱ 1,000', 'label' => 'UtilitySubsidy'],
                ['icon' => $icons['money'], 'value' => '₱ 24,000', 'label' => 'ChartRate'],
            ]
        ];

        return [
            // Unit 1
            array_merge($baseUnit, [
                'id' => 1,
                'unit_number' => 'Unit 101',
            ]),
            // Unit 2
            array_merge($baseUnit, [
                'id' => 2,
                'unit_number' => 'Unit 102',
                'status' => 'Vacant',
                'status_details' => '0 out of 4',
                'specifications' => [
                    ['icon' => $icons['guests'], 'value' => 4, 'label' => 'RoomCapacity'],
                    ['icon' => $icons['bathtub'], 'value' => 4, 'label' => 'UnitCapacity'],
                    ['icon' => $icons['shower'], 'value' => 'Shared', 'label' => 'RoomType'],
                    ['icon' => $icons['bed'], 'value' => 'Top Bunk', 'label' => 'BedType'],
                    ['icon' => $icons['money'], 'value' => '₱ 1,000', 'label' => 'UtilitySubsidy'],
                    ['icon' => $icons['money'], 'value' => '₱ 24,000', 'label' => 'ChartRate'],
                ]
            ]),
            // Unit 3
            array_merge($baseUnit, [
                'id' => 3,
                'unit_number' => 'Unit 103',
                'status' => 'Occupied',
                'status_details' => '2 out of 4',
            ]),
        ];
    }

    /**
     * Helper to get status color.
     */
    public function getStatusColor(string $status): string
    {
        return match (strtolower($status)) {
            'occupied' => 'bg-red-500', // Red for Occupied
            'vacant' => 'bg-green-500', // Green for Vacant
            default => 'bg-gray-500',
        };
    }

    public function render()
    {
        return view('livewire.layouts.unit-details');
    }
}
