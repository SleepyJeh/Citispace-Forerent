<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class StatsSidebar extends Component
{
    public int $totalUnits = 200;

    public int $occupied = 120;
    public int $occupiedPercent = 64;
    public int $vacant = 5;
    public int $vacantPercent = 10;
    public int $maintenance = 3;
    public int $maintenancePercent = 6;
    public int $moveInReady = 10;
    public int $moveInReadyPercent = 20;
    public float $occupancyRate = 64.0;
    public int $availableUnits = 15;

    public float $vacancyRate = 7.5;
    public int $avgDaysOnMarket = 45;
    public array $longestVacant = [];
    public array $leaseExpirations = [];
    public array $maintenanceStats = [];


    public function mount()
    {
        $this->loadUnitStats();
        $this->loadVacancyMetrics();
        $this->loadLeaseExpirations();
        $this->loadMaintenanceStatus();
    }

    private function loadUnitStats()
    {

        $this->totalUnits = 200;
        $this->occupied = 120;
        $this->occupiedPercent = 64;
        $this->vacant = 5;
        $this->vacantPercent = 10;
        $this->maintenance = 3;
        $this->maintenancePercent = 6;
        $this->moveInReady = 10;
        $this->moveInReadyPercent = 20;
        $this->occupancyRate = 64.0;
        $this->availableUnits = 15;
    }

    private function loadVacancyMetrics()
    {
        $this->longestVacant = [
            ['name' => 'Unit 103', 'days' => 60],
            ['name' => 'Unit 205', 'days' => 48],
            ['name' => 'Unit 112', 'days' => 45],
        ];
    }

    private function loadLeaseExpirations()
    {
        $this->leaseExpirations = [
            ['label' => 'Today', 'count' => 2],
            ['label' => 'This Week', 'count' => 5],
            ['label' => 'This Month', 'count' => 18],
            ['label' => 'Next Month', 'count' => 25],
        ];
    }

    private function loadMaintenanceStatus()
    {
        $this->maintenanceStats = [
            ['label' => 'New Requests', 'count' => 3],
            ['label' => 'Work in Progress', 'count' => 5],
            ['label' => 'On Hold (Parts)', 'count' => 1],
            ['label' => 'Avg. Resolution Time', 'count' => '3 Days'],
        ];
    }


    public function render()
    {
        return view('livewire.layouts.stats-sidebar');
    }
}
