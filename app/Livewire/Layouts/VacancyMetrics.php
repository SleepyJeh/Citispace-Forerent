<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class VacancyMetrics extends Component
{
    public int $vacantCount = 10;
    public int $totalCount = 120;

    public int $vacancyPercent = 20;

    public int $avgDaysVacant = 45;

    public string $longestVacantUnit = 'Unit 103';

    public int $longestVacantDays = 20;

    public int $readyToLeaseCount = 8;


    public function render()
    {
        return view('livewire.layouts.vacancy-metrics');
    }
}
