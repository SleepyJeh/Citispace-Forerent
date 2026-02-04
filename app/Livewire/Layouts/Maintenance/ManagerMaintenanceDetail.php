<?php

namespace App\Livewire\Layouts\Maintenance;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\MaintenanceRequest;
use App\Models\Unit;
use App\Models\Bed;
use App\Models\Lease;

class ManagerMaintenanceDetail extends Component
{
    public $requestId = null;
    public $unit = null;
    public $beds = [];
    public $activeBedNum = 1;
    public $selectedBedData = []; // Default to empty array
    public $ticket = null;

    #[On('managerMaintenanceSelected')]
    public function loadRequest($requestId)
    {
        $this->requestId = $requestId;

        $this->ticket = MaintenanceRequest::with('lease.bed.unit.property')->find($requestId);

        if ($this->ticket && $this->ticket->lease && $this->ticket->lease->bed && $this->ticket->lease->bed->unit) {
            $unitModel = $this->ticket->lease->bed->unit;

            $this->unit = [
                'name' => 'Unit ' . $unitModel->unit_number,
                'building' => $unitModel->property->building_name ?? 'Unknown Building',
                'address' => $unitModel->property->address ?? 'Taguig, Metro Manila',
                'floor' => ($unitModel->floor_number ?? 1) . 'th Floor',
                'status' => 'Occupied',
                'specs' => [
                    'Room Capacity' => $unitModel->room_cap ?? 0,
                    'Unit Capacity' => $unitModel->unit_cap ?? 0,
                    'Room Type' => $unitModel->room_type ?? 'Standard',
                    'Bed Type' => $unitModel->bed_type ?? 'Single',
                    'Utility Subsidy' => 'Yes',
                    'Occupied Unit' => $unitModel->beds()->where('status', 'Occupied')->count() . ' of ' . ($unitModel->unit_cap ?? 4),
                    'Base Rate' => '₱ ' . number_format($unitModel->price ?? 0),
                ],
            ];

            $this->beds = Bed::where('unit_id', $unitModel->unit_id)->orderBy('bed_number')->get();

            // Try to extract bed number from string "101-B1" -> 1
            $bedNum = 1;
            if (preg_match('/B(\d+)$/', $this->ticket->lease->bed->bed_number, $matches)) {
                $bedNum = (int)$matches[1];
            }
            $this->selectBed($bedNum);
        }
    }

    public function selectBed($bedNumber)
    {
        $this->activeBedNum = $bedNumber;
        $bedIndex = $bedNumber - 1;

        if (isset($this->beds[$bedIndex])) {
            $bed = $this->beds[$bedIndex];

            $lease = Lease::where('bed_id', $bed->bed_id)
                ->where('status', 'Active')
                ->with('tenant')
                ->first();

            $this->selectedBedData = [
                'Tenant' => $lease ? ($lease->tenant->first_name . ' ' . $lease->tenant->last_name) : 'Vacant',
                'Lease Start' => $lease ? $lease->move_in->format('F d, Y') : '-',
                'Lease End' => $lease ? $lease->end_date->format('F d, Y') : '-',
                'Status' => $lease ? 'Monthly' : 'Available',
            ];
        } else {
            // Fallback if bed index not found
            $this->selectedBedData = [
                'Tenant' => 'N/A',
                'Lease Start' => '-',
                'Lease End' => '-',
                'Status' => '-'
            ];
        }
    }

    public function render()
    {
        return view('livewire.layouts.maintenance.manager-maintenance-detail');
    }
}
