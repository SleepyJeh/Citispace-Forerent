<?php

namespace App\Livewire\Layouts\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Billing;
use App\Models\MaintenanceLog;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $currentMonth = Carbon::now();
        $monthStart = $currentMonth->clone()->startOfMonth();
        $monthEnd = $currentMonth->clone()->endOfMonth();

        // Get all billing records for the owner's properties
        $ownerBillings = Billing::whereHas('lease.bed.unit.property', function ($query) use ($user) {
            $query->where('owner_id', $user->user_id);
        })->get();

        // Calculate Total Rent Collected using paid billings for current month (transactions aren't linked in seed data)
        // using entire history for now instead of limiting to current month
        $this->totalRentCollected = Billing::whereHas('lease.bed.unit.property', function ($query) use ($user) {
            $query->where('owner_id', $user->user_id);
        })
            ->where('status', 'Paid')
            ->sum('amount');

        // on the off chance you still want to include credits from transactions,
        // keep them available for the income figure below

        // Calculate Total Uncollected Rent (unpaid billings for current month)
        $this->totalUncollectedRent = Billing::whereHas('lease.bed.unit.property', function ($query) use ($user) {
            $query->where('owner_id', $user->user_id);
        })
            ->where('status', 'Unpaid')
            ->sum('to_pay');

        // Total Income should show amount actually collected (same as collected rent)
        // additional uncollected rent is only used for the "target"/total figure.
        $this->totalIncome = $this->totalRentCollected;

        // If you still have real transaction data available, you could override
        // the above by uncommenting the following block:
        /*
        $incomeFromTransactions = Transaction::whereHas('billing.lease.bed.unit.property', function ($query) use ($user) {
            $query->where('owner_id', $user->user_id);
        })
            ->where('transaction_type', 'Credit')
            ->sum('amount');
        if ($incomeFromTransactions > 0) {
            $this->totalIncome = $incomeFromTransactions;
        }
        */

        // Revenue Current is simply what has already been collected
        $this->revenueCurrent = $this->totalRentCollected;

        // Revenue Target should reflect the grand total (collected + uncollected)
        $this->revenueTarget = $this->totalRentCollected + $this->totalUncollectedRent;

        // Calculate Total Expenses (maintenance costs for current month)
        $this->expensesCurrent = MaintenanceLog::whereHas('request.lease.bed.unit.property', function ($query) use ($user) {
            $query->where('owner_id', $user->user_id);
        })
            ->sum('cost');

        // Expenses Target (set as 20% of revenue target or a fixed amount)
        $this->expensesTarget = $this->revenueTarget * 0.20;

        // Calculate ROI Current (Return on Investment)
        if ($this->expensesCurrent > 0) {
            $this->roiCurrent = (($this->revenueCurrent - $this->expensesCurrent) / $this->expensesCurrent) * 100;
        } else {
            $this->roiCurrent = 0;
        }

        // ROI Target (typical target is 30-50% ROI)
        $this->roiTarget = 35;

        // Calculate percentages
        $totalPotentialRent = $this->totalRentCollected + $this->totalUncollectedRent;

        // Prevent "Division by Zero" error if there is no rent data yet
        if ($totalPotentialRent > 0) {
            $this->rentCollectedPercentage = ($this->totalRentCollected / $totalPotentialRent) * 100;
            $this->uncollectedPercentage = ($this->totalUncollectedRent / $totalPotentialRent) * 100;
        } else {
            $this->rentCollectedPercentage = 0;
            $this->uncollectedPercentage = 0;
        }

        // For Income, let's compare it against your Revenue Target
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
