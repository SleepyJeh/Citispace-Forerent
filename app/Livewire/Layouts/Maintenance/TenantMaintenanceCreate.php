<?php

namespace App\Livewire\Layouts\Maintenance;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class TenantMaintenanceCreate extends Component
{
    public $problem = '';
    public $urgency = 'Normal'; // Default value

    // Validation Rules
    protected $rules = [
        'problem' => 'required|string|min:10|max:1000',
        'urgency' => 'required|in:Low,Normal,High,Emergency',
    ];

    // Reset form when modal is closed or opened fresh
    #[On('reset-modal')]
    public function resetForm()
    {
        $this->reset(['problem', 'urgency']);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        // 1. Find Tenant's Active Lease
        $activeLease = DB::table('leases')
            ->where('tenant_id', $user->user_id)
            ->where('status', 'Active')
            ->first();

        if (!$activeLease) {
            $this->addError('problem', 'You do not have an active lease to submit a request for.');
            return;
        }

        // 2. Create Ticket Number (Simple auto-increment style)
        $latestId = DB::table('maintenance_requests')->max('request_id') ?? 0;
        $ticketNumber = 'MR-' . str_pad($latestId + 1, 5, '0', STR_PAD_LEFT);

        // 3. Insert Record
        DB::table('maintenance_requests')->insert([
            'lease_id' => $activeLease->lease_id,
            'problem' => $this->problem,
            'urgency' => $this->urgency,
            'status' => 'Pending',
            'ticket_number' => $ticketNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Reset Form
        $this->resetForm();

        // 5. Dispatch Events
        // Close the modal in the frontend
        $this->dispatch('close-modal');
        // Tell the list component to refresh so the new item appears
        $this->dispatch('refresh-maintenance-list');
        // Optional: Show a success notification (if you have a toaster setup)
        // $this->dispatch('notify', message: 'Request submitted successfully!');
    }

    public function render()
    {
        return view('livewire.layouts.maintenance.tenant-maintenance-create');
    }
}
