<?php

namespace App\Livewire\Layouts\Maintenance;

use Livewire\Component;
use App\Models\MaintenanceLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectedMaintenanceCost extends Component
{
    public $title = 'Projected Maintenance Cost';
    public $buildingData = [];
    public $predictionData = [];

    public function mount()
    {
        $this->calculateBuildingCosts();
        $this->calculatePredictionChart();
    }

    public function calculateBuildingCosts()
    {
        // Get total cost for the current month
        $currentMonthCost = MaintenanceLog::whereMonth('completion_date', Carbon::now()->month)
            ->whereYear('completion_date', Carbon::now()->year)
            ->sum('cost');

        // Get total cost for the last month to calculate % change
        $lastMonthCost = MaintenanceLog::whereMonth('completion_date', Carbon::now()->subMonth()->month)
            ->whereYear('completion_date', Carbon::now()->subMonth()->year)
            ->sum('cost');

        // Calculate Percentage Change
        $change = 0;
        $changeType = 'lower';

        if ($lastMonthCost > 0) {
            $diff = $currentMonthCost - $lastMonthCost;
            $change = abs(($diff / $lastMonthCost) * 100);
            $changeType = $currentMonthCost > $lastMonthCost ? 'higher' : 'lower';
        }

        // Mocking Building Data Breakdown (Since Seeder doesn't explicitly link logs to 'Buildings' yet)
        // We replicate the "Building 1" card style from your screenshot 4 times
        $this->buildingData = [
            [
                'name' => 'Building 1',
                'cost' => $currentMonthCost / 4, // Distributing dummy cost
                'change' => round($change, 1),
                'change_type' => $changeType
            ],
            [
                'name' => 'Building 2',
                'cost' => $currentMonthCost / 4,
                'change' => round($change, 1),
                'change_type' => $changeType
            ],
            [
                'name' => 'Building 3',
                'cost' => $currentMonthCost / 4,
                'change' => round($change, 1),
                'change_type' => $changeType
            ],
            [
                'name' => 'Building 4',
                'cost' => $currentMonthCost / 4,
                'change' => round($change, 1),
                'change_type' => $changeType
            ],
        ];
    }

    public function calculatePredictionChart()
    {
        // Fetch monthly costs for the current year for the chart
        $monthlyCosts = MaintenanceLog::select(
            DB::raw('sum(cost) as total'),
            DB::raw("DATE_FORMAT(completion_date, '%M') as month_name"),
            DB::raw('MONTH(completion_date) as month_num')
        )
        ->whereYear('completion_date', Carbon::now()->year)
        ->groupBy('month_name', 'month_num')
        ->orderBy('month_num')
        ->get();

        // Format for the chart (ApexCharts or similar)
        $this->predictionData = [
            'labels' => $monthlyCosts->pluck('month_name')->toArray(),
            'data' => $monthlyCosts->pluck('total')->toArray()
        ];
    }

    public function render()
    {
        return view('livewire.layouts.maintenance.projected-maintenance-cost');
    }
}
