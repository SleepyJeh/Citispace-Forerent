<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\WithPagination;

class RevenueRecords extends Component
{
    use WithPagination;

    public $activeTab = 'payment';
    public $selectedMonth = 'january';
    public $selectedBuilding = 'building1';

    // Sample data - replace with actual database queries
    public function getPaymentHistory()
    {
        return [
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'payment_date' => 'January 28, 2025', 'period' => 'January 2025', 'rent' => 24000, 'lease_type' => 'Annually'],
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'payment_date' => 'January 28, 2025', 'period' => 'January 2025', 'rent' => 24000, 'lease_type' => 'Annually'],
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'payment_date' => 'January 28, 2025', 'period' => 'January 2025', 'rent' => 24000, 'lease_type' => 'Annually'],
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'payment_date' => 'January 28, 2025', 'period' => 'January 2025', 'rent' => 24000, 'lease_type' => 'Annually'],
        ];
    }

    public function getMaintenanceHistory()
    {
        return [
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'maintenance_date' => 'January 28, 2025', 'service_provider' => 'January 2025', 'cost' => 24000],
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'maintenance_date' => 'January 28, 2025', 'service_provider' => 'January 2025', 'cost' => 24000],
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'maintenance_date' => 'January 28, 2025', 'service_provider' => 'January 2025', 'cost' => 24000],
            ['unit' => 'Unit 103', 'tenant' => 'Adam Candelaria', 'maintenance_date' => 'January 28, 2025', 'service_provider' => 'January 2025', 'cost' => 24000],
        ];
    }

    public function render()
    {
        return view('livewire.layouts.revenue-records', [
            'paymentHistory' => $this->getPaymentHistory(),
            'maintenanceHistory' => $this->getMaintenanceHistory()
        ]);
    }
}
