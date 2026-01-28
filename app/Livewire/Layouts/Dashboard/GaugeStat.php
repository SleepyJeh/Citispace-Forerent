<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;

class GaugeStat extends Component
{
    public $title;
    public $currentValue;
    public $targetValue;
    public $percentage;
    public $prefix; // e.g., "₱ "
    public $suffix; // e.g., "%"

    public function mount($title, $current, $target, $prefix = '₱ ', $suffix = '')
    {
        $this->title = $title;
        $this->currentValue = number_format($current);
        $this->targetValue = number_format($target);

         if ($suffix === '%') {
            $this->currentValue = $current;
            $this->targetValue = $target;
        }

        $this->prefix = $prefix;
        $this->suffix = $suffix;

         if ($target > 0) {
            $this->percentage = round(($current / $target) * 100);
        } else {
            $this->percentage = 0;
        }
    }

    public function render()
    {
        return view('livewire.layouts.dashboard.gauge-stat');
    }
}
