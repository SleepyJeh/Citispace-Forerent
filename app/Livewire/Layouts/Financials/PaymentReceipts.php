<?php

namespace App\Livewire\Layouts\Financials;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentReceipts extends Component
{
    use WithPagination;

    public $activeTab = 'all';

    // Filters
    public $filterPeriod = '';
    public $filterBuilding = '';

    // FIX 1: Reset to Page 1 when filters change
    public function updatedActiveTab()
    {
        $this->resetPage();
    }
    public function updatedFilterPeriod()
    {
        $this->resetPage();
    } // <--- Add this
    public function updatedFilterBuilding()
    {
        $this->resetPage();
    } // <--- Add this

    public function markAsPaid($id)
    {
        DB::table('billings')->where('billing_id', $id)->update([
            'status' => 'Paid',
            'amount' => DB::raw('to_pay'),
            'updated_at' => now()
        ]);

        $this->dispatch('show-toast', ['message' => 'Payment marked as Paid!']);
    }

    public function render()
    {
        $baseQuery = DB::table('billings')
            ->join('leases', 'billings.lease_id', '=', 'leases.lease_id')
            ->join('users', 'leases.tenant_id', '=', 'users.user_id')
            ->select(
                'billings.*',
                'users.first_name',
                'users.last_name',
                'leases.contract_rate'
            );

        $counts = [
            'all'      => (clone $baseQuery)->count(),
            'upcoming' => (clone $baseQuery)->where('billings.status', 'Unpaid')->count(),
            'paid'     => (clone $baseQuery)->where('billings.status', 'Paid')->count(),
            'unpaid'   => (clone $baseQuery)->where('billings.status', 'Overdue')->count(),
        ];

        $query = clone $baseQuery;

        match ($this->activeTab) {
            'upcoming' => $query->where('billings.status', 'Unpaid'),
            'paid'     => $query->where('billings.status', 'Paid'),
            'unpaid'   => $query->where('billings.status', 'Overdue'),
            default    => null,
        };

        // Filter Logic
        if ($this->filterPeriod) {
            $query->whereMonth('billings.billing_date', $this->filterPeriod);
        }

        if ($this->filterBuilding) {
            // Add building filter logic here if needed
        }

        $payments = $query->orderBy('billings.billing_date', 'desc')->paginate(10);

        return view('livewire.layouts.financials.payment-receipts', [
            'payments' => $payments,
            'counts' => $counts
        ]);
    }
}
