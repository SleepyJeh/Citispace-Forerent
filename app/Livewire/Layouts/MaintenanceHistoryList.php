<?php
// app/Livewire/Layouts/MaintenanceHistoryList.php

namespace App\Livewire\Layouts;

use Livewire\Component;

class MaintenanceHistoryList extends Component
{
    public $filter = 'all';
    public $allHistoryItems = [];
    public $activeHistoryId = null;

    // Dummy data simulating data from your 'maintenance_request' table
    // with 'tenant_name' and 'unit_number' joined from other tables.
    protected $dummyHistory = [
        [
            'request_id' => 1,
            'lease_id' => 101,
            'status' => 'Completed', // 'Completed'
            'tenant_name' => 'Ninole Candelaria', // Simulated JOIN
            'unit_number' => 'Unit 101', // Simulated JOIN
        ],
        [
            'request_id' => 2,
            'lease_id' => 102,
            'status' => 'Ongoing', // 'Ongoing'
            'tenant_name' => 'John Doe',
            'unit_number' => 'Unit 202',
        ],
        [
            'request_id' => 3,
            'lease_id' => 103,
            'status' => 'Completed', // 'Completed'
            'tenant_name' => 'Maria Santos',
            'unit_number' => 'Unit 305',
        ],
        [
            'request_id' => 4,
            'lease_id' => 104,
            'status' => 'Pending', // 'Pending'
            'tenant_name' => 'Kiko Ramos',
            'unit_number' => 'Unit 102',
        ],
        [
            'request_id' => 5,
            'lease_id' => 105,
            'status' => 'Pending', // 'Pending'
            'tenant_name' => 'Pedro Penduko',
            'unit_number' => 'Unit 401',
        ]
    ];

    public function mount($filter = 'all'): void
    {
        $this->filter = $filter;
        $this->allHistoryItems = $this->dummyHistory;
    }

    public function selectHistory(int $historyId): void
    {
        $this->activeHistoryId = $historyId;
        $this->dispatch('maintenanceHistorySelected', historyId: $historyId);
    }

    /**
     * This is the render method that passes the data.
     */
    public function render()
    {
        // Start with the full list
        $filteredItems = $this->allHistoryItems;

        // If the filter is NOT 'all', then filter the array
        // based on the status from the tab.
        if ($this->filter !== 'all') {
            $filteredItems = array_filter($this->allHistoryItems, function ($item) {
                return $item['status'] === $this->filter;
            });
        }

        // Pass the (now filtered or full) list to the view
        // with the key 'historyItems'.
        return view('livewire.layouts.maintenance-history-list', [
            'historyItems' => $filteredItems
        ]);
    }
}
