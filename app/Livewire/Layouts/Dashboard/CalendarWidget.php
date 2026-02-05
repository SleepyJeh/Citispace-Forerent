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

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        $emptySlots = $startOfMonth->dayOfWeekIso - 1;
        $this->calendarDays = array_fill(0, $emptySlots, null);

        for ($i = 1; $i <= $endOfMonth->day; $i++) {
            $this->calendarDays[] = $i;
        }

        $this->loadEvents();
    }

    public function selectDate($date)
    {
        $this->selectedDate = Carbon::parse($date);
        $this->updateCalendar();
    }

    public function loadEvents()
    {
        $this->dailyEvents = [
            [
                'title' => 'Rent Increase Notification',
                'description' => 'This is a notification that the monthly rent for all units will be increased.'
            ],
        ];
    }

    public function render()
    {
        return view('livewire.layouts.dashboard.calendar-widget');
    }
}
