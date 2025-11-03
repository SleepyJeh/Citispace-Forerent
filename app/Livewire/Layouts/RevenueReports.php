<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class RevenueReports extends Component
{
    public $totalIncome = 120000;
    public $totalExpenses = 120000;
    public $netOperatingIncome = 120000;
    public $selectedMonth = 'month';

    // Added properties to match the new dropdowns
    public $selectedInflowTimeframe = 'month';
    public $selectedProjectionTimeframe = 'month';


    // Sample data - replace with actual database queries
    public function getIncomeChartData()
    {
        return [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'data' => [44970, 45364, 46576, 48182, 44970, 49788, 51000, 53000, 51000, 46576, 45364, 48182]
        ];
    }

    public function getInflowOutflowData()
    {
        return [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'income' => [49788, 51000, 46576, 48182, 44970, 52000, 45000, 50000, 48000, 53000, 46000, 49000],
            'expenses' => [48000, 49000, 47000, 48000, 46500, 51000, 44000, 48500, 49000, 49500, 47500, 47000]
        ];
    }

    public function getMaintenanceCostData()
    {
        return [
            ['label' => 'Unit Structure', 'value' => 50, 'amount' => 120000],
            ['label' => 'Plumbing', 'value' => 40, 'amount' => 120000],
            ['label' => 'Electrical', 'value' => 10, 'amount' => 120000]
        ];
    }

    public function getProjectedRevenueData()
    {
        return [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September'],
            'projected' => [65, 68, 70, 72, 75, 73, 71, 74, 72],
            'projectedNet' => [60, 63, 65, 68, 70, 68, 66, 69, 67]
        ];
    }

    public function render()
    {
        return view('livewire.layouts.revenue-reports', [
            'incomeData' => $this->getIncomeChartData(),
            'inflowOutflowData' => $this->getInflowOutflowData(),
            'maintenanceCostData' => $this->getMaintenanceCostData(),
            'projectedRevenueData' => $this->getProjectedRevenueData()
        ]);
    }
}
