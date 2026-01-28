<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;
use Carbon\Carbon;

class CalendarWidget extends Component
{
    public $currentMonth;
    public $currentYear;
    public $calendarDays = [];
    public $selectedDate;
    public $dailyEvents = [];

    public function mount()
    {
        $this->selectedDate = Carbon::now();
        $this->updateCalendar();
    }

    public function updateCalendar()
    {
        $date = Carbon::parse($this->selectedDate);
        $this->currentMonth = $date->format('F Y');
        $this->currentYear = $date->format('Y');

        // Generate days for the grid
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // Empty slots before the 1st of the month
        $emptySlots = $startOfMonth->dayOfWeekIso - 1;
        $this->calendarDays = array_fill(0, $emptySlots, null);

        // Actual days
        for ($i = 1; $i <= $endOfMonth->day; $i++) {
            $this->calendarDays[] = $i;
        }

        // Load events for the selected date (Mock Data for now)
        $this->loadEvents();
    }

    public function selectDate($date)
    {
        $this->selectedDate = Carbon::parse($date);
        $this->updateCalendar();
    }

    public function loadEvents()
    {
        // You can replace this later with a Database query
        $this->dailyEvents = [
            [
                'title' => 'Rent Increase Notification',
                'description' => 'This is a notification that the monthly rent for all units will be increased.'
            ],
            // Add more mock events here if needed
        ];
    }

    public function render()
    {
        return view('livewire.layouts.dashboard.calendar-widget');
    }
}
