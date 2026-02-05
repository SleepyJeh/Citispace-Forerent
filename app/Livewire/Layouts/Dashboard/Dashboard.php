<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Billing;

class Dashboard extends Component
{
    public $selectedDate;
    public $currentMonth;
     public $totalRentCollected;
    public $totalUncollectedRent;
    public $totalIncome;

    public $rentCollectedPercentage = 0;
    public $uncollectedPercentage = 0;
    public $incomePercentage = 0;

     public $revenueCurrent, $revenueTarget;
    public $expensesCurrent, $expensesTarget;
    public $roiCurrent, $roiTarget;

    public function mount()
    {
        $this->selectedDate = Carbon::today();
        $this->currentMonth = Carbon::now()->format('F Y');
        $this->loadFinancialData();
    }

    public function loadFinancialData()
    {
        $totalPotentialRent = $this->totalRentCollected + $this->totalUncollectedRent;

         if ($totalPotentialRent > 0) {
            $this->rentCollectedPercentage = ($this->totalRentCollected / $totalPotentialRent) * 100;
            $this->uncollectedPercentage = ($this->totalUncollectedRent / $totalPotentialRent) * 100;
        } else {
            $this->rentCollectedPercentage = 0;
            $this->uncollectedPercentage = 0;
        }

        if ($this->revenueTarget > 0) {
            $this->incomePercentage = ($this->totalIncome / $this->revenueTarget) * 100;
        } else {
            $this->incomePercentage = 0;
        }
    }

     #[Layout('layouts.app')]
    public function render()
    {

        return view('users.admin.owner.dashboard');
    }
}
