<?php

namespace App\Livewire\Layouts\Tenants;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction; 
use App\Models\Property; 
use Illuminate\Support\Facades\Auth;

class PaymentHistory extends Component
{
    use WithPagination;

    // 1. ADD NEW FILTERS
    public $activeTab = 'all'; 
    public $selectedMonth = null;
    public $selectedBuilding = null;

    // Reset pagination when any filter changes
    public function updatedActiveTab() { $this->resetPage(); }
    public function updatedSelectedMonth() { $this->resetPage(); }
    public function updatedSelectedBuilding() { $this->resetPage(); }

    public function render()
    {
        $user = Auth::user();
        
        // 2. DEFINE OPTIONS
        // Month List (Numeric keys for correct sorting)
        $monthOptions = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        // Building List (Dynamic)
        $buildingOptions = [];
        try {
            $buildingOptions = Property::distinct()->pluck('building_name', 'building_name')->toArray();
        } catch (\Exception $e) { $buildingOptions = []; }

        // 3. START QUERY
        $query = Transaction::query();

        // 4. APPLY TAB FILTERS (Added 'Unpaid' logic)
        if ($this->activeTab === 'paid') {
            $query->where('transaction_type', 'Credit');
        } 
        elseif ($this->activeTab === 'unpaid') {
            // Assuming 'Debit' or specific status means Unpaid/Pending
            $query->where('transaction_type', 'Debit'); 
        }
        elseif ($this->activeTab === 'upcoming') {
            $query->where('transaction_id', 0); // Placeholder for empty
        }

        // 5. APPLY DROPDOWN FILTERS
        // Month Filter
        if ($this->selectedMonth) {
            $query->whereMonth('transaction_date', $this->selectedMonth);
        }

        // Building Filter (If transactions are linked to units/properties)
        // Note: If your Transaction model doesn't join with Property, this might need a Join.
        // For now, we leave it prepared but commented out if relations aren't set up.
        // $query->whereHas('unit.property', fn($q) => $q->where('building_name', $this->selectedBuilding));

        $payments = $query->orderBy('transaction_date', 'desc')->paginate(10);

        return view('livewire.layouts.tenants.payment-history', [
            'payments' => $payments,
            'monthOptions' => $monthOptions,
            'buildingOptions' => $buildingOptions
        ]);
    }
}
