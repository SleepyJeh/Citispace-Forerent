<?php

namespace App\Livewire\Layouts\Units;

use Livewire\Component;
use App\Models\Unit;
use App\Models\Bed;

class VacancyMetrics extends Component
{
    public int $totalCapacity = 0;
    public int $occupiedBeds = 0;
    public int $vacantBeds = 0;
    public int $vacancyPercent = 0;
    public int $readyToLeaseCount = 0;
    public int $fullyVacantCount = 0;

    public function mount()
    {
        $this->calculateVacancyMetrics();
    }

    private function calculateVacancyMetrics()
    {
        // Get all units with their beds and active leases
        $units = Unit::with(['beds.leases' => function($query) {
            $query->where('status', 'Active');
        }])->get();

        // Calculate total capacity (total beds)
        $this->totalCapacity = Bed::count();

        // Calculate occupied beds (beds with active leases)
        $this->occupiedBeds = 0;
        foreach ($units as $unit) {
            foreach ($unit->beds as $bed) {
                if ($bed->leases->isNotEmpty()) {
                    $this->occupiedBeds++;
                }
            }
        }

        // Calculate vacant beds
        $this->vacantBeds = $this->totalCapacity - $this->occupiedBeds;

        // Calculate vacancy rate
        if ($this->totalCapacity > 0) {
            $this->vacancyPercent = round(($this->vacantBeds / $this->totalCapacity) * 100);
        }

        // Ready to Lease: units with at least 1 bed without active lease
        $this->readyToLeaseCount = Unit::whereHas('beds', function($query) {
            $query->whereDoesntHave('leases', function($q) {
                $q->where('status', 'Active');
            });
        })->count();

        // Fully Vacant: units with NO active leases on any bed
        $this->fullyVacantCount = Unit::whereDoesntHave('beds.leases', function($query) {
            $query->where('status', 'Active');
        })->count();
    }

    public function render()
    {
        return view('livewire.layouts.units.vacancy-metrics');
    }
}
