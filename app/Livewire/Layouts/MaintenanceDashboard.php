<?php

namespace App\Livewire\Layouts;  // Correct namespace for your file location

use Livewire\Component;

class MaintenanceDashboard extends Component
{
    public $buildings = [];
    public $costPredictions = [];
    public $revenueProjections = [];

    // NEW: Property to manage the active tab state
    public $activeTab = 'all';

    public function mount()
    {
        // Dummy data for buildings
        $this->buildings = [
            [
                'name' => 'Building 1',
                'current_cost' => '120,000',
                'change_percentage' => 4,
                'change_direction' => 'higher'
            ],
            [
                'name' => 'Building 2',
                'current_cost' => '95,500',
                'change_percentage' => 2,
                'change_direction' => 'higher'
            ],
            [
                'name' => 'Building 3',
                'current_cost' => '78,200',
                'change_percentage' => 1,
                'change_direction' => 'lower'
            ],
            [
                'name' => 'Building 4',
                'current_cost' => '145,000',
                'change_percentage' => 6,
                'change_direction' => 'higher'
            ]
        ];

        // Cost predictions
        $this->costPredictions = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'data' => [32, 28, 35, 40, 38, 45, 42, 48, 50, 55, 52, 58]
        ];

        // Revenue projections
        $this->revenueProjections = [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            'data' => [45, 52, 48, 60, 65, 58, 70, 75, 80, 85, 82, 90]
        ];
    }

    // NEW: Method to update the active tab
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // We pass the activeTab state to the view
        return view('livewire.layouts.maintenance-dashboard');
    }
}
