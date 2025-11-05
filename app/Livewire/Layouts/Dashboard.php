<?php

namespace App\Livewire\Layouts;

use App\Models\Announcement;
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
        return Announcement::query()
            ->leftJoin('properties', 'announcements.property_id', '=', 'properties.property_id')
            ->where('announcements.author_id', auth()->id()) // ✅ only the author's announcements
            ->selectRaw('
        COALESCE(properties.building_name, "All Properties") as property,
        announcements.title,
        announcements.description,
        announcements.created_at
    ')
            ->orderByDesc('announcements.created_at')
            ->get()
            ->map(function ($announcement) {
                return [
                    'property' => $announcement->property,
                    'date' => Carbon::parse($announcement->created_at)->format('F j, Y'),
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                ];
            });

    }

    public function getDailyEventsProperty()
    {
        return Announcement::query()
            ->leftJoin('properties', 'announcements.property_id', '=', 'properties.property_id')
            ->selectRaw('
            COALESCE(properties.building_name, "All Properties") as property,
            announcements.title,
            announcements.description,
            announcements.created_at
        ')
            ->whereDate('announcements.created_at', $this->selectedDate)
            ->orderByDesc('announcements.created_at')
            ->get()
            ->map(function ($announcement) {
                return [
                    'property' => $announcement->property,
                    'date' => Carbon::parse($announcement->created_at)->format('F j, Y'),
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                ];
            });
    }

    public function getAnnouncementDaysProperty()
    {
        return Announcement::query()
            ->where('author_id', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->selectRaw('DATE(created_at) as date')
            ->pluck('date')
            ->map(fn($date) => Carbon::parse($date)->day)
            ->toArray();
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
