<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $selectedDate;
    public $currentMonth;
    public $currentYear;

    // Financial metrics
    public $totalRentCollected = 120000;
    public $totalUncollectedRent = 10000;
    public $totalIncome = 120000;

    public $revenueCurrentValue = 20000;
    public $revenueTargetValue = 80000;

    public $expensesCurrentValue = 20000;
    public $expensesTargetValue = 80000;

    public $roiCurrentValue = 22.3;
    public $roiTargetValue = 18.0;

    protected $listeners = ['announcement-posted' => '$refresh'];

    public function mount()
    {
        $this->selectedDate = Carbon::today();
        $this->currentMonth = Carbon::now()->format('F Y');
        $this->currentYear = Carbon::now()->year;
    }

    public function selectDate($date)
    {
        $this->selectedDate = Carbon::parse($date);
    }

    public function getAnnouncementsProperty()
    {
        // Replace with actual database query
        return [
            ['date' => 'October 1, 2025', 'title' => 'Rent Increase Notification', 'description' => 'This is a notification that the monthly rent for all units will be increased effective December 1, 2025.'],
            ['date' => 'October 15, 2025', 'title' => 'Rent Increase Notification', 'description' => 'This is a notification that the monthly rent for all units will be increased effective December 1, 2025.'],
        ];
    }

    public function getDailyEventsProperty()
    {
        // Replace with actual database query filtered by selectedDate
        return [
            ['title' => 'Rent Increase Notification', 'description' => 'This is a notification that the monthly rent for all units will be increased effective December 1, 2025.'],
            ['title' => 'Rent Increase Notification', 'description' => 'This is a notification that the monthly rent for all units will be increased effective December 1, 2025.'],
            ['title' => 'Rent Increase Notification', 'description' => 'This is a notification that the monthly rent for all units will be increased effective December 1, 2025.'],
        ];
    }

    public function getCalendarDaysProperty()
    {
        $startOfMonth = Carbon::parse($this->currentMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($this->currentMonth)->endOfMonth();

        $startDay = $startOfMonth->dayOfWeek; // 0 = Sunday
        $daysInMonth = $endOfMonth->day;

        $days = [];

        // Add empty cells for days before month starts
        for ($i = 0; $i < $startDay; $i++) {
            $days[] = null;
        }

        // Add actual days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = $day;
        }

        return $days;
    }

    public function calculatePercentage($current, $target)
    {
        if ($target == 0) return 0;
        return round(($current / $target) * 100);
    }

    public function render()
    {
        return view('livewire.layouts.dashboard-components', [
            'revenuePercentage' => $this->calculatePercentage($this->revenueCurrentValue, $this->revenueTargetValue),
            'expensesPercentage' => $this->calculatePercentage($this->expensesCurrentValue, $this->expensesTargetValue),
            'roiPercentage' => round(($this->roiCurrentValue / $this->roiTargetValue) * 100),
        ]);
    }
}
