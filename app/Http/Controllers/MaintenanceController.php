<?php
// app/Http/Controllers/MaintenanceForecastController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MaintenanceForecast;

class MaintenanceController extends Controller
{
    protected $forecastService;

    public function __construct(MaintenanceForecast $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    public function showForecastForm()
    {
        $maintenanceStats = $this->forecastService->getMaintenanceStats();
        
        return view('maintenance.forecast', compact('maintenanceStats'));
    }

    public function generateForecast(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2023|max:2030'
        ]);

        try {
            // Get maintenance data from database (only completed records with logs)
            $maintenanceData = $this->forecastService->getMaintenanceDataForForecast();
            
            if (empty($maintenanceData)) {
                return back()->with('error', 'No completed maintenance data available for forecasting.');
            }

            $forecastResult = $this->forecastService->generateForecast(
                $request->year,
                $maintenanceData
            );

            return view('maintenance.forecast-results', [
                'forecast' => $forecastResult,
                'year' => $request->year
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate forecast: ' . $e->getMessage());
        }
    }

    public function apiForecast(Request $request)
    {
        $request->validate([
            'year' => 'required|integer'
        ]);

        try {
            $maintenanceData = $this->forecastService->getMaintenanceDataForForecast();
            
            $forecastResult = $this->forecastService->generateForecast(
                $request->year,
                $maintenanceData
            );

            return response()->json($forecastResult);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}