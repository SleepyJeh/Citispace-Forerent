<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class LeaseExpirationOverview extends Component
{

    public int $expiringThisMonth = 2;

    public int $expiringNext30Days = 3;

    public int $expiringNext60Days = 8;

    public int $avgTurnaroundTime = 45;



    public function render()
    {
        return view('livewire.layouts.lease-expiration-overview');
    }
}
