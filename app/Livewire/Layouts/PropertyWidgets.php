<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use App\Models\Unit;

class PropertyWidgets extends Component
{
    // Unit Status Data
    public int $totalUnits = 0;
    public int $occupied = 0;
    public int $occupiedPercent = 0;
    public int $vacant = 0;
    public int $vacantPercent = 0;
    public int $maintenance = 0;
    public int $maintenancePercent = 0;
    public int $moveInReady = 0;
    public int $moveInReadyPercent = 0;
    public float $occupancyRate = 0.0;
    public int $availableUnits = 0;

    // Donut chart data
    public array $unitStatusData = [];

    public function mount()
    {
        $this->loadUnitStats();
    }

    private function loadUnitStats()
    {
        // Calculate unit status based on bed occupancy
        $this->totalUnits = Unit::count();

        // For demo purposes, we'll calculate based on bed status
        // In real implementation, you might want to track unit status separately
        $units = Unit::withCount(['beds', 'beds as occupied_beds_count' => function($query) {
            $query->where('status', 'Occupied');
        }])->get();

        $occupiedUnits = 0;
        $vacantUnits = 0;
        $maintenanceUnits = 0;
        $moveInReadyUnits = 0;

        foreach ($units as $unit) {
            $totalBeds = $unit->beds_count;
            $occupiedBeds = $unit->occupied_beds_count;

            if ($occupiedBeds == $totalBeds) {
                $occupiedUnits++;
            } elseif ($occupiedBeds == 0) {
                // Simple logic for demo - you might have actual maintenance status
                if ($totalBeds > 2) { // Example condition for maintenance
                    $maintenanceUnits++;
                } else {
                    $vacantUnits++;
                }
            } else {
                $moveInReadyUnits++; // Partially occupied or ready
            }
        }

        $this->occupied = $occupiedUnits;
        $this->vacant = $vacantUnits;
        $this->maintenance = $maintenanceUnits;
        $this->moveInReady = $moveInReadyUnits;

        // Calculate percentages
        if ($this->totalUnits > 0) {
            $this->occupiedPercent = round(($this->occupied / $this->totalUnits) * 100);
            $this->vacantPercent = round(($this->vacant / $this->totalUnits) * 100);
            $this->maintenancePercent = round(($this->maintenance / $this->totalUnits) * 100);
            $this->moveInReadyPercent = round(($this->moveInReady / $this->totalUnits) * 100);

            $this->occupancyRate = round(($this->occupied / $this->totalUnits) * 100, 1);
            $this->availableUnits = $this->totalUnits - $this->occupied;
        }

        // Prepare data for donut chart
        $this->unitStatusData = [
            ['label' => 'Occupied', 'value' => $this->occupiedPercent, 'count' => $this->occupied],
            ['label' => 'Vacant', 'value' => $this->vacantPercent, 'count' => $this->vacant],
            ['label' => 'Maintenance', 'value' => $this->maintenancePercent, 'count' => $this->maintenance],
            ['label' => 'Move-In Ready', 'value' => $this->moveInReadyPercent, 'count' => $this->moveInReady]
        ];
    }

    public function getUnitStatusChartData()
    {
        return [
            ['label' => 'Occupied', 'value' => $this->occupiedPercent, 'count' => $this->occupied],
            ['label' => 'Vacant', 'value' => $this->vacantPercent, 'count' => $this->vacant],
            ['label' => 'Maintenance', 'value' => $this->maintenancePercent, 'count' => $this->maintenance],
            ['label' => 'Move-In Ready', 'value' => $this->moveInReadyPercent, 'count' => $this->moveInReady]
        ];
    }

    public function render()
    {
        return view('livewire.layouts.property-widgets', [
            'unitStatusData' => $this->getUnitStatusChartData()
        ]);
    }
}
