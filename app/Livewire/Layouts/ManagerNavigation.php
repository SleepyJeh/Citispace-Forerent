<?php

namespace App\Livewire\Layouts;

use App\Models\User;
use App\Models\Unit;
use Livewire\Component;
use Livewire\Attributes\On;

class ManagerNavigation extends Component
{
    /*----------------------------------
    | PUBLIC PROPERTIES
    ----------------------------------*/
    public $managers = [];
    public $activeManagerId = null;

    /*----------------------------------
    | LIFECYCLE HOOKS
    ----------------------------------*/
    public function mount(): void
    {
        $this->loadManagers();
    }

    public function booted(): void
    {
        // Only dispatch if a manager is already active
        if ($this->activeManagerId && $this->managers->isNotEmpty()) {
            $this->dispatch('managerSelected', managerId: $this->activeManagerId);
        }
    }

    /*----------------------------------
    | LISTENERS
    ----------------------------------*/
    #[On('refresh-manager-list')]
    public function refreshManagerList(): void
    {
        $this->loadManagers();

        if ($this->activeManagerId) {
            $this->dispatch('managerSelected', managerId: $this->activeManagerId);
        }
    }

    #[On('managerActivated')]
    public function activateManager(int $managerId): void
    {
        $this->activeManagerId = $managerId;
    }

    /*----------------------------------
    | DATA LOADING
    ----------------------------------*/
    private function loadManagers(): void
    {
        $landlordId = auth()->id();

        // Managers assigned to units in properties owned by this landlord
        $assignedManagerIds = Unit::whereHas('property', function ($query) use ($landlordId) {
            $query->where('owner_id', $landlordId);
        })
            ->whereNotNull('manager_id')
            ->pluck('manager_id')
            ->unique();

        // Managers who currently have no assigned units at all
        $unassignedManagerIds = User::where('role', 'manager')
            ->whereDoesntHave('unitsManaged') // assumes User model has relation managedUnits()
            ->pluck('user_id');

        // Combine both assigned and unassigned manager IDs
        $allManagerIds = $assignedManagerIds->merge($unassignedManagerIds)->unique();

        // Load all relevant managers
        $this->managers = User::whereIn('user_id', $allManagerIds)
            ->where('role', 'manager')
            ->get();

        // ❌ Do NOT auto-select any manager initially
        $this->activeManagerId = null;
    }

    /*----------------------------------
    | UI ACTIONS
    ----------------------------------*/
    public function selectManager(int $managerId): void
    {
        $this->activeManagerId = $managerId;
        $this->dispatch('managerSelected', managerId: $managerId);
    }

    /*----------------------------------
    | RENDER
    ----------------------------------*/
    public function render()
    {
        return view('livewire.layouts.manager-navigation');
    }
}
