<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaintenanceStats extends Component
{
    public $totalCost;
    public $newRequests;
    public $pendingRequests;
    public $currentDate;

    public function mount()
    {
        // 1. Total Maintenance Cost: Sum of 'cost' from 'maintenance_logs'
        $this->totalCost = DB::table('maintenance_logs')->sum('cost');

        // 2. New Requests: Count of requests created in the current month
        $this->newRequests = DB::table('maintenance_requests')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // 3. Pending Requests: Count of requests with status 'Pending'
        $this->pendingRequests = DB::table('maintenance_requests')
            ->where('status', 'Pending')
            ->count();

        // 4. Current Date for display
        $this->currentDate = Carbon::now()->format('M d, Y');
    }

    public function render()
    {
        return view('livewire.layouts.dashboard.maintenance-stats');
    }
}
