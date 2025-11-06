<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use App\Services\RevenueForecastService;
use Carbon\Carbon;

class RevenueForecast extends Component
{
    public $forecastYear;
    public $monthlyForecasts = [];
    public $totalAnnualRevenue = 0;
    public $totalRemainingRevenue = 0;
    public $averageMonthlyRevenue = 0;
    public $loading = false;
    public $error = null;
    public $dataPointsUsed = 0;

    protected $revenueForecastService;

    public function boot(RevenueForecastService $revenueForecastService)
    {
        $this->revenueForecastService = $revenueForecastService;
    }

    public function mount()
    {
        $this->forecastYear = Carbon::now()->year;
    }

    public function generateForecast()
    {
        $this->loading = true;
        $this->error = null;
        $this->monthlyForecasts = [];
        $this->totalAnnualRevenue = 0;
        $this->totalRemainingRevenue = 0;
        $this->averageMonthlyRevenue = 0;
        $this->dataPointsUsed = 0;

        try {
            $result = $this->revenueForecastService->generateMonthlyForecast($this->forecastYear);
            
            $this->monthlyForecasts = $result['monthly_forecasts'];
            $this->totalAnnualRevenue = $result['total_annual_revenue'];
            $this->totalRemainingRevenue = $result['total_remaining_revenue'];
            $this->averageMonthlyRevenue = $result['average_monthly_revenue'];
            $this->dataPointsUsed = $result['data_points_used'] ?? 0;
            
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.layouts.revenue-forecast');
    }
}