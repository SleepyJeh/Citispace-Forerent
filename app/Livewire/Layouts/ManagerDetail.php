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
    public $totalBuildings = 0;
    public $totalUnits = 0;

    // Dummy data for demonstration
    private $allManagerData = [
        1 => [
            'manager' => [
                'name' => 'Ninole Candelaria',
                'email' => 'Ninole@Gmail.Com',
                'phone' => '09456400004', // <-- Correct phone number
            ],
            'buildings' => [
                ['id' => 1, 'name' => 'Building 1', 'address' => 'Fame Residences, Mandaluyong City'],
                ['id' => 2, 'name' => 'Building 2', 'address' => 'Vibrant Towers, QC'],
            ],
            'units' => [
                1 => [
                    // Total 9 units here now
                    ['unit_number' => 'Unit 101', 'available_beds' => '3 of 4', 'bed_type' => 'All Female', 'status' => 'Full'],
                    ['unit_number' => 'Unit 102', 'available_beds' => '2 of 4', 'bed_type' => 'All Female', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 103', 'available_beds' => '3 of 4', 'bed_type' => 'All Female', 'status' => 'Full'],
                    // --- Added these for testing ---
                    ['unit_number' => 'Unit 104', 'available_beds' => '1 of 4', 'bed_type' => 'Mixed', 'status' => 'Full'],
                    ['unit_number' => 'Unit 105', 'available_beds' => '4 of 4', 'bed_type' => 'All Male', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 106', 'available_beds' => '2 of 4', 'bed_type' => 'All Female', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 107', 'available_beds' => '3 of 4', 'bed_type' => 'All Female', 'status' => 'Full'],
                    ['unit_number' => 'Unit 108', 'available_beds' => '1 of 4', 'bed_type' => 'Mixed', 'status' => 'Full'],
                    ['unit_number' => 'Unit 109', 'available_beds' => '4 of 4', 'bed_type' => 'All Male', 'status' => 'Vacant'],
                ],
                2 => [
                    // Total 2 units here (for a grand total of 5)
                    ['unit_number' => 'Unit 201', 'available_beds' => '4 of 4', 'bed_type' => 'Mixed', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 202', 'available_beds' => '1 of 4', 'bed_type' => 'All Male', 'status' => 'Full'],
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
                ['id' => 3, 'name' => 'Building 3', 'address' => 'Jazz Residences, Makati'],
            ],
            'units' => [
                3 => [
                    ['unit_number' => 'Unit 301', 'available_beds' => '4 of 4', 'bed_type' => 'All Female', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 302', 'available_beds' => '2 of 4', 'bed_type' => 'All Male', 'status' => 'Full'],
                    ['unit_number' => 'Unit 303', 'available_beds' => '3 of 4', 'bed_type' => 'Mixed', 'status' => 'Vacant'],
                    ['unit_number' => 'Unit 304', 'available_beds' => '1 of 4', 'bed_type' => 'All Female', 'status' => 'Full'],
                ]
            ]
        ],
    ];

    public function mount()
    {
        // Load the first manager by default
        $this->loadManager(1);
    }

    /**
     * Listen for the 'managerSelected' event to load manager data
     */
    #[On('managerSelected')]
    public function loadManager(int $managerId)
    {
        // In a real app:
        // $manager = User::with(['buildings.units'])->find($managerId);
        // $this->manager = $manager->only(['name', 'email', 'phone']);
        // $this->buildings = $manager->buildings->toArray();
        // etc.

        $data = $this->allManagerData[$managerId] ?? $this->allManagerData[1];

        $this->manager = $data['manager'];
        $this->buildings = $data['buildings'];

        // Calculate totals
        $this->totalBuildings = count($this->buildings);
        $this->totalUnits = 0;
        foreach ($data['units'] as $buildingUnits) {
            $this->totalUnits += count($buildingUnits);
        }

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
     * Select a building and load its units
     */
    public function selectBuilding(int $buildingId)
    {
        $this->selectedBuildingId = $buildingId;

        // In a real app:
        // $this->units = Unit::where('building_id', $buildingId)
        //     ->select('unit_number', 'available_beds', 'bed_type', 'status')
        //     ->get()
        //     ->toArray();

        // Find the current manager's data
        $managerId = null;
        foreach ($this->allManagerData as $id => $data) {
            if ($data['manager']['name'] === $this->manager['name']) {
                $managerId = $id;
                break;
            }
        }

        $this->units = $this->allManagerData[$managerId]['units'][$buildingId] ?? [];
    }

    /**
     * Open edit properties modal/page
     */
    public function openEditProperties()
    {
        // Dispatch event to open edit modal
        $this->dispatch('openEditPropertiesModal', managerId: array_search($this->manager, array_column($this->allManagerData, 'manager')));

        // Or redirect to edit page:
        // return redirect()->route('manager.edit-properties', ['id' => $managerId]);
    }

    public function render()
    {
        return view('livewire.layouts.manager-detail');
    }
}
