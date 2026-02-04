<?php

namespace App\Livewire\Layouts\Maintenance;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TenantMaintenanceList extends Component
{
    public $activeRequestId = null;
    public $sort = 'newest'; // Default sort
    public $renderControls = false; // Decides if we render the dropdown or the list

    public function updatedSort()
    {
        // When dropdown changes, just re-render
    }

    public function selectRequest($id)
    {
        $this->activeRequestId = $id;
        $this->dispatch('tenantMaintenanceSelected', requestId: $id);
    }

    public function refreshList()
    {
        // This empty method is enough to trigger a re-render of the component
    }

    public function render()
    {
        // If we are just rendering the controls (the dropdown), skip the query
        if ($this->renderControls) {
             return view('livewire.layouts.maintenance.tenant-maintenance-list-controls');
        }

        // Determine sort order
        $orderBy = 'created_at';
        $direction = 'desc';

        switch ($this->sort) {
            case 'oldest':
                $direction = 'asc';
                break;
            case 'status':
                $orderBy = 'status';
                $direction = 'asc';
                break;
            default: // newest
                $direction = 'desc';
                break;
        }

        // Query Tenant's Requests
        $requests = DB::table('maintenance_requests')
            ->join('leases', 'maintenance_requests.lease_id', '=', 'leases.lease_id')
            ->where('leases.tenant_id', Auth::id())
            ->select(
                'maintenance_requests.request_id',
                'maintenance_requests.status',
                'maintenance_requests.urgency',
                'maintenance_requests.problem',
                'maintenance_requests.created_at',
                'maintenance_requests.ticket_number'
            )
            ->orderBy($orderBy, $direction)
            ->get();

        return view('livewire.layouts.maintenance.tenant-maintenance-list', [
            'requests' => $requests
        ]);
    }
}
