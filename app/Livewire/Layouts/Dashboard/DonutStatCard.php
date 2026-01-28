<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;

class DonutStatCard extends Component
{
    public $title;
    public $amount;
    public $label;
    public $percentage;

    public function mount($title, $amount, $label = 'Collected', $percentage = 75)
    {
        $this->title = $title;
        $this->amount = $amount;
        $this->label = $label;
        $this->percentage = $percentage;
    }

    public function render()
    {
        return view('livewire.layouts.dashboard.donut-stat-card');
    }
}
