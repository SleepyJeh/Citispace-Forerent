<?php

namespace App\Livewire\Layouts\Maintenance;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerMaintenanceList extends Component
{
    public $activeTab = 'all'; // 'all', 'open', 'pending', 'closed'
    public $activeRequestId = null;

    protected $listeners = ['refreshDashboard' => '$refresh'];

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function selectRequest($id)
    {
        $this->activeRequestId = $id;
        // This dispatches the event to the Detail component
        $this->dispatch('managerMaintenanceSelected', requestId: $id);
    }

    public function render()
    {
        $managerId = Auth::id();

        // Base Query
        $baseQuery = DB::table('maintenance_requests')
            ->join('leases', 'maintenance_requests.lease_id', '=', 'leases.lease_id')
            ->join('beds', 'leases.bed_id', '=', 'beds.bed_id')
            ->join('units', 'beds.unit_id', '=', 'units.unit_id')
            ->join('users', 'leases.tenant_id', '=', 'users.user_id')
            ->where('units.manager_id', $managerId)
            ->select(
                'maintenance_requests.request_id',
                'maintenance_requests.status',
                'units.unit_number',
                DB::raw("CONCAT(users.first_name, ' ', users.last_name) as tenant_name")
            );

        // 1. Calculate Counts
        $allCount = (clone $baseQuery)->count();
        $openCount = (clone $baseQuery)->where('maintenance_requests.status', 'Ongoing')->count();
        $pendingCount = (clone $baseQuery)->where('maintenance_requests.status', 'Pending')->count();
        $closedCount = (clone $baseQuery)->where('maintenance_requests.status', 'Completed')->count();

        // 2. Filter List
        $listQuery = $baseQuery;

        if ($this->activeTab === 'open') {
            $listQuery->where('maintenance_requests.status', 'Ongoing');
        } elseif ($this->activeTab === 'pending') {
            $listQuery->where('maintenance_requests.status', 'Pending');
        } elseif ($this->activeTab === 'closed') {
            $listQuery->where('maintenance_requests.status', 'Completed');
        }

        return view('livewire.layouts.maintenance.manager-maintenance-list', [
            'requests' => $listQuery->orderBy('maintenance_requests.created_at', 'desc')->get(),
            'counts' => [
                'all' => $allCount,
                'open' => $openCount,
                'pending' => $pendingCount,
                'closed' => $closedCount,
            ]
        ]);
    }
}
