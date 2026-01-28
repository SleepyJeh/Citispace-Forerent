<?php

namespace App\Livewire\Layouts\Maintenance;
use Livewire\Component;
use Livewire\Attributes\On;

class MaintenanceHistoryDetail extends Component
{
    public $currentHistoryId = null;
    public $currentHistoryItem = null;


    protected $dummyHistoryDetails = [
         1 => [
            'request_id' => 1,
            'lease_id' => 101,
            'status' => 'Completed',
            'logged_by' => 'Ninole Candelaria (Tenant)',
            'ticket_number' => 'TKT-2025-001',
            'log_date' => '2025-11-01',
            'problem' => 'Leaking faucet in the bathroom sink. It\'s been dripping constantly for two days.',
            'urgency' => 'Level 2',

            'tenant_name' => 'Ninole Candelaria',
            'building_name' => 'The Ridge Wood - 4th Floor',
            'unit_number' => 'Unit 101',
            'contact_number' => '09457835123',

            'completion_date' => '2025-11-03',
            'cost' => 1500.00
        ],

        2 => [
            'request_id' => 2,
            'lease_id' => 102,
            'status' => 'Ongoing',
            'logged_by' => 'John Doe (Tenant)',
            'ticket_number' => 'TKT-2025-002',
            'log_date' => '2025-11-05',
            'problem' => 'Air conditioner is not cooling properly. It just blows room-temperature air.',
            'urgency' => 'Level 3',

            'tenant_name' => 'John Doe',
            'building_name' => 'The Residences - 2nd Floor',
            'unit_number' => 'Unit 202',
            'contact_number' => '09123456789',

            'completion_date' => null,
            'cost' => null
        ],

        3 => [
            'request_id' => 3,
            'lease_id' => 103,
            'status' => 'Completed',
            'logged_by' => 'Maria Santos (Tenant)',
            'ticket_number' => 'TKT-2025-003',
            'log_date' => '2025-10-28',
            'problem' => 'Broken lock on the main door. The deadbolt is stuck.',
            'urgency' => 'Level 4',

            'tenant_name' => 'Maria Santos',
            'building_name' => 'Sunset Apartments - 3rd Floor',
            'unit_number' => 'Unit 305',
            'contact_number' => '09224567890',

            'completion_date' => '2025-10-29',
            'cost' => 850.50
        ],

        4 => [
            'request_id' => 4,
            'lease_id' => 104,
            'status' => 'Pending',
            'logged_by' => 'Kiko Ramos (Tenant)',
            'ticket_number' => 'TKT-2025-004',
            'log_date' => '2025-11-06',
            'problem' => 'Clogged shower drain.',
            'urgency' => 'Level 1',

            'tenant_name' => 'Kiko Ramos',
            'building_name' => 'The Ridge Wood - 1st Floor',
            'unit_number' => 'Unit 102',
            'contact_number' => '09171234567',

            'completion_date' => null,
            'cost' => null
        ],
         5 => [
            'request_id' => 5,
            'lease_id' => 105,
            'status' => 'Pending',
            'logged_by' => 'Pedro Penduko (Tenant)',
            'ticket_number' => 'TKT-2025-005',
            'log_date' => '2025-11-07',
            'problem' => 'Main lightbulb in the living room is busted.',
            'urgency' => 'Level 1',

            'tenant_name' => 'Pedro Penduko',
            'building_name' => 'Greenview Tower - 4th Floor',
            'unit_number' => 'Unit 401',
            'contact_number' => '09287654321',

            'completion_date' => null,
            'cost' => null
        ],
    ];

    #[On('maintenanceHistorySelected')]
    public function loadHistoryItem(?int $historyId): void
    {
        if (!$historyId || !isset($this->dummyHistoryDetails[$historyId])) {
            $this->resetHistoryData();
            return;
        }

        $this->currentHistoryId = $historyId;
        $this->currentHistoryItem = $this->dummyHistoryDetails[$historyId];
    }

    private function resetHistoryData(): void
    {
        $this->currentHistoryId = null;
        $this->currentHistoryItem = null;
    }

    public function markInProgress(): void
    {
        if ($this->currentHistoryId) {
            $this->currentHistoryItem['status'] = 'Ongoing';
            logger('Marked as In Progress: ' . $this->currentHistoryId);
        }
    }

    public function markCompleted(): void
    {
        if ($this->currentHistoryId) {
            $this->currentHistoryItem['status'] = 'Completed';
            $this->currentHistoryItem['completion_date'] = now()->format('Y-m-d');
            $this->currentHistoryItem['cost'] = 1000.00;
            logger('Marked as Completed: ' . $this->currentHistoryId);
        }
    }

    public function render()
    {
        return view('livewire.layouts.maintenance.maintenance-history-detail');
    }
}
