<?php

namespace App\Livewire\Layouts\Maintenance;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TenantMaintenanceDetail extends Component
{
    public $ticket = null;
    public $ticketIdDisplay = '';

    #[On('tenantMaintenanceSelected')]
    public function loadRequest($requestId)
    {
        // Fetch ticket details directly from DB for simplicity
        $this->ticket = DB::table('maintenance_requests')
            ->where('request_id', $requestId)
            ->first();

        if ($this->ticket) {
            $this->ticketIdDisplay = $this->ticket->ticket_number ?? 'TKT-' . str_pad($this->ticket->request_id, 4, '0', STR_PAD_LEFT);
        }
    }

    public function render()
    {
        return view('livewire.layouts.maintenance.tenant-maintenance-detail');
    }
}
