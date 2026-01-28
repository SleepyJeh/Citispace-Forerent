<?php

namespace App\Livewire\Layouts\Financials;

use Livewire\Component;

class RevenueReports extends Component
{
    // Filter State (Bind to Dropdown)
    public $filter = 'monthly'; // Options: 'monthly', 'yearly'

    // KPI Metrics
    public $totalIncome = 0;
    public $totalExpenses = 0;
    public $netOperatingIncome = 0;

    public function mount()
    {
        $this->refreshData();
    }

    /**
     * Listener: Runs automatically when $filter changes
     */
    public function updatedFilter($value)
    {
        $this->refreshData();

        // Dispatch event to frontend with new chart data
        $this->dispatch('update-charts', [
            'incomeData' => $this->getIncomeChartData(),
            'inflowOutflowData' => $this->getInflowOutflowData(),
            'maintenanceCostData' => $this->getMaintenanceCostData(),
            'projectedRevenueData' => $this->getProjectedRevenueData()
        ]);
    }

    /**
     * Update KPI numbers based on filter
     */
    public function refreshData()
    {
        if ($this->filter === 'yearly') {
            // Sample Data for Yearly View
            $this->totalIncome = 1200000;
            $this->totalExpenses = 800000;
        } else {
            // Sample Data for Monthly View
            $this->totalIncome = 120000;
            $this->totalExpenses = 60000;
        }

        $this->netOperatingIncome = $this->totalIncome - $this->totalExpenses;
    }

    // -----------------------------------------------------------------------
    // CHART DATA METHODS
    // -----------------------------------------------------------------------

    public function getIncomeChartData()
    {
        if ($this->filter === 'yearly') {
            return [
                'labels' => ['2020', '2021', '2022', '2023', '2024', '2025'],
                'data' => [900000, 950000, 1000000, 1100000, 1150000, 1200000]
            ];
        }

        // Default: Monthly
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [45000, 52000, 48000, 61000, 55000, 67000, 72000, 69000, 78000, 85000, 88000, 92000]
        ];
    }

    public function getInflowOutflowData()
    {
        if ($this->filter === 'yearly') {
            return [
                'labels' => ['2020', '2021', '2022', '2023', '2024', '2025'],
                'income' => [900000, 950000, 1000000, 1100000, 1150000, 1200000],
                'expenses' => [600000, 650000, 700000, 750000, 780000, 800000]
            ];
        }

        // UPDATED: Now includes data from Jan to Dec
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'income' => [50000, 55000, 60000, 58000, 62000, 65000, 67000, 70000, 68000, 75000, 78000, 82000],
            'expenses' => [40000, 42000, 45000, 44000, 48000, 50000, 52000, 53000, 51000, 55000, 57000, 60000]
        ];
    }

    public function getMaintenanceCostData()
    {
        return [
            ['label' => 'Unit Structure', 'value' => 50, 'amount' => 50000],
            ['label' => 'Plumbing', 'value' => 30, 'amount' => 30000],
            ['label' => 'Electrical', 'value' => 20, 'amount' => 20000]
        ];
    }

    public function getProjectedRevenueData()
    {
        if ($this->filter === 'yearly') {
            return [
                'labels' => ['2026', '2027', '2028', '2029', '2030'],
                'projected' => [130, 140, 150, 160, 170],
                'projectedNet' => [100, 110, 120, 130, 140]
            ];
        }

        // Also updated this to show a fuller year projection if needed
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'projected' => [70, 72, 75, 78, 80, 85, 87, 88, 90, 92, 95, 100],
            'projectedNet' => [60, 62, 65, 68, 70, 75, 77, 78, 80, 82, 85, 90]
        ];
    }

    public function render()
    {
        return view('livewire.layouts.financials.revenue-reports', [
            'incomeData' => $this->getIncomeChartData(),
            'inflowOutflowData' => $this->getInflowOutflowData(),
            'maintenanceCostData' => $this->getMaintenanceCostData(),
            'projectedRevenueData' => $this->getProjectedRevenueData()
        ]);
    }
}
