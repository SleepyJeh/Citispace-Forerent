<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class MaintenanceStatusMetrics extends Component
{

    public int $activeMaintenance = 1;

    public int $pendingMoveInReady = 3;

    public int $avgTurnaroundTime = 7;

    public function render()
    {
        return view('livewire.layouts.maintenance-status-metrics');
    }
}
