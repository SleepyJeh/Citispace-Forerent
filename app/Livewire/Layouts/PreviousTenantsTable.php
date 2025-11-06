<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use App\Models\Lease;
use Livewire\Attributes\On;
use Carbon\Carbon;

class PreviousTenantsTable extends Component
{
    public $selectedBedId = null;

    #[On('bedSelectedForPreviousTenants')]
    public function handleBedSelected($bedId)
    {
        $this->selectedBedId = $bedId;
        \Log::info('🎯 Bed selected for previous tenants', ['bedId' => $bedId]);
    }

    public function render()
    {
        $tenants = collect(); // default: empty collection

        if ($this->selectedBedId) {
            $tenants = Lease::with([
                'tenant' => fn($q) => $q->withTrashed(), // include deleted tenants if soft deleted
                'bed.unit'
            ])
                ->where('bed_id', $this->selectedBedId)
                ->whereIn('status', ['Expired', 'Terminated', 'Ended', 'Completed']) // include all past leases
                ->orderByDesc('end_date')
                ->get()
                ->map(function ($lease) {
                    return (object)[
                        'unit_number' => $lease->bed->unit->unit_number ?? 'N/A',
                        'tenant_name' => $lease->tenant
                            ? "{$lease->tenant->first_name} {$lease->tenant->last_name}"
                            : 'Unknown Tenant',
                        'move_in' => $lease->start_date,
                        'move_out' => $lease->end_date ?? $lease->move_out ?? '—',
                        'monthly_rent' => '$' . number_format($lease->rent_amount, 2),
                    ];
                });
        }

        return view('livewire.layouts.previous-tenants-table', [
            'tenants' => $tenants,
            'selectedBedId' => $this->selectedBedId,
        ]);
    }
}
