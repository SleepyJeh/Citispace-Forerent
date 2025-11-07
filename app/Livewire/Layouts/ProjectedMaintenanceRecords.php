<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class ProjectedMaintenanceRecords extends Component
{
    // STATE: Manages the active tab
    public $activeTab = 'schedule'; // Default tab

    // Note: Removed $selectedMonth and $selectedBuilding properties

    // DUMMY DATA: For the "Maintenance Schedule" tab
    public function getScheduleHistory()
    {
        return [
            ['unit' => 'Unit 201', 'task' => 'HVAC Inspection', 'scheduled_date' => 'January 15, 2025', 'urgency' => 'Level 2', 'status' => 'Scheduled'],
            ['unit' => 'Unit 305', 'task' => 'Plumbing Check', 'scheduled_date' => 'January 22, 2025', 'urgency' => 'Level 1', 'status' => 'Scheduled'],
            ['unit' => 'Lobby', 'task' => 'Fire Extinguisher Service', 'scheduled_date' => 'January 28, 2025', 'urgency' => 'Level 3', 'status' => 'Pending'],
            ['unit' => 'Gym', 'task' => 'Treadmill Maintenance', 'scheduled_date' => 'February 05, 2025', 'urgency' => 'Level 1', 'status' => 'Scheduled'],
        ];
    }

    // DUMMY DATA: For the "Cost Breakdown" tab
    public function getCostBreakdown()
    {
        return [
            ['category' => 'HVAC', 'provider' => 'CoolBreeze Inc.', 'estimated_cost' => 5000, 'last_serviced' => 'July 10, 2024'],
            ['category' => 'Plumbing', 'provider' => 'Mario\'s Pipes', 'estimated_cost' => 3500, 'last_serviced' => 'August 22, 2024'],
            ['category' => 'Electrical', 'provider' => 'Sparky Solutions', 'estimated_cost' => 4200, 'last_serviced' => 'June 01, 2024'],
            ['category' => 'General', 'provider' => 'Handy Helpers', 'estimated_cost' => 8000, 'last_serviced' => 'N/A'],
        ];
    }

    // RENDER: Passes the data to the view
    public function render()
    {
        return view('livewire.layouts.projected-maintenance-records', [
            'scheduleHistory' => $this->getScheduleHistory(),
            'costBreakdown' => $this->getCostBreakdown()
        ]);
    }
}
