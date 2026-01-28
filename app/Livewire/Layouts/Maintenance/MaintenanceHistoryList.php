<?php

namespace App\Livewire\Layouts\Maintenance;
use Livewire\Component;

class MaintenanceHistoryList extends Component
{
    public $filter = 'all';
    public $allHistoryItems = [];
    public $activeHistoryId = null;


    protected $dummyHistory = [
        [
            'request_id' => 1,
            'lease_id' => 101,
            'status' => 'Completed',
            'tenant_name' => 'Ninole Candelaria',
            'unit_number' => 'Unit 101',
        ],
        [
            'request_id' => 2,
            'lease_id' => 102,
            'status' => 'Ongoing',
            'tenant_name' => 'John Doe',
            'unit_number' => 'Unit 202',
        ],
        [
            'request_id' => 3,
            'lease_id' => 103,
            'status' => 'Completed',
            'tenant_name' => 'Maria Santos',
            'unit_number' => 'Unit 305',
        ],
        [
            'request_id' => 4,
            'lease_id' => 104,
            'status' => 'Pending',
            'tenant_name' => 'Kiko Ramos',
            'unit_number' => 'Unit 102',
        ],
        [
            'request_id' => 5,
            'lease_id' => 105,
            'status' => 'Pending',
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


    public function render()
    {
         $filteredItems = $this->allHistoryItems;


        if ($this->filter !== 'all') {
            $filteredItems = array_filter($this->allHistoryItems, function ($item) {
                return $item['status'] === $this->filter;
            });
        }


        return view('livewire.layouts.maintenance.maintenance-history-list', [
            'historyItems' => $filteredItems
        ]);
    }
}
