<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\Attributes\On; 

class ManagerDetail extends Component
{
    public array $manager;
    public array $buildings;
    public array $units;
    public $selectedBuildingId = null;


    private $allManagerData = [
        1 => [
            'manager' => [
                'name' => 'Ninole Candelaria',
                'email' => 'Ninole@Gmail.Com',
                'phone' => '09456502004',
            ],
            'buildings' => [
                ['id' => 1, 'name' => 'Building 1 (Ninole)', 'address' => 'Fame Residences, Mandaluyong City'],
                ['id' => 2, 'name' => 'Building 2 (Ninole)', 'address' => 'Vibrant Towers, QC'],
            ],
            'units' => [
                1 => [ // Units for Building 1
                    ['unit_number' => 'Unit 101', 'tenant' => 'Adam Candelaria', 'status' => 'Occupied'],
                    ['unit_number' => 'Unit 102', 'tenant' => 'Jane Doe', 'status' => 'Vacant'],
                ],
                2 => [ // Units for Building 2
                    ['unit_number' => 'Unit 201', 'tenant' => 'John Smith', 'status' => 'Occupied'],
                ]
            ]
        ],
        2 => [
            'manager' => [
                'name' => 'Conrad Rivera',
                'email' => 'conrad@example.com',
                'phone' => '09123456789',
            ],
            'buildings' => [
                ['id' => 3, 'name' => 'Building 3 (Conrad)', 'address' => 'Jazz Residences, Makati'],
            ],
            'units' => [
                3 => [ // Units for Building 3
                    ['unit_number' => 'Unit 301', 'tenant' => 'Peter Jones', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 302', 'tenant' => 'Mary Jane', 'status' => 'Occupied'],
                    ['unit_number' => 'Unit 303', 'tenant' => 'Peter Jones', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 304', 'tenant' => 'Mary Jane', 'status' => 'Occupied'],
                ]
            ]
        ],
        // Add other manager IDs (3, 4, 5, 6) here if needed
    ];
    // --- END DUMMY DATA ---


    public function mount()
    {
        // Load the first manager by default (ID 1)
        $this->loadManager(1);
    }

    /**
     * MODIFIED:
     * This method now listens for the 'managerSelected' event.
     * It fetches and updates the component's data based on the new managerId.
     */
    #[On('managerSelected')]
    public function loadManager(int $managerId)
    {
        // In a real app, fetch from DB:
        // $manager = PropertyManager::find($managerId);
        // $buildings = $manager->buildings;
        // $firstBuilding = $buildings->first();
        // $units = $firstBuilding ? $firstBuilding->units : [];

        // Using dummy data for this example:
        // Use array_key_exists to handle IDs 3, 4, 5, 6 not being in the demo data
        $data = $this->allManagerData[$managerId] ?? $this->allManagerData[1]; // Default to 1 if not found

        $this->manager = $data['manager'];
        $this->buildings = $data['buildings'];

        // Set the active building and its units
        if (count($this->buildings) > 0) {
            $this->selectedBuildingId = $this->buildings[0]['id'];
            $this->units = $data['units'][$this->selectedBuildingId] ?? [];
        } else {
            $this->selectedBuildingId = null;
            $this->units = [];
        }
    }

    /**
     * Set the active building and load its units.
     */
    public function selectBuilding(int $buildingId)
    {
        $this->selectedBuildingId = $buildingId;

        // In a real app:
        // $this->units = Unit::where('building_id', $buildingId)->get()->toArray();

        // Using dummy data:
        // We need to find which manager we're looking at to get the right unit list
        $managerId = null;
        foreach ($this->allManagerData as $id => $data) {
            if ($data['manager']['name'] === $this->manager['name']) {
                $managerId = $id;
                break;
            }
        }

        $this->units = $this->allManagerData[$managerId]['units'][$buildingId] ?? [];
    }

    public function getStatusColor(string $status): string
    {
        return match (strtolower($status)) {
            'occupied' => 'bg-red-100 text-red-700',
            'vacant' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function render()
    {
        return view('livewire.layouts.manager-detail');
    }
}
