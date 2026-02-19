<?php

namespace App\Livewire\Layouts\Managers;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class ManagerNavigation extends Component
{
    public $managers = [];
    public $activeManagerId = null;

    public function mount(): void
    {
        $this->loadManagers();
    }

    public function booted(): void
    {
        if ($this->activeManagerId) {
            $this->dispatch('managerSelected', managerId: $this->activeManagerId);
        }
    }

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

    private function loadManagers(): void
    {
        $landlordId = Auth::id();

        $assignedManagerIds = Unit::whereHas('property', function ($query) use ($landlordId) {
            $query->where('owner_id', $landlordId);
        })->whereNotNull('manager_id')->pluck('manager_id')->unique();

        $unassignedManagerIds = User::where('role', 'manager')
            ->whereDoesntHave('unitsManaged')
            ->pluck('user_id');

        $allManagerIds = $assignedManagerIds->merge($unassignedManagerIds)->unique();

        $this->managers = User::whereIn('user_id', $allManagerIds)
            ->where('role', 'manager')
            ->get();
    }

    public function selectManager(int $managerId): void
    {
        $this->activeManagerId = $managerId;
        $this->dispatch('managerSelected', managerId: $managerId);
    }

    public function render()
    {
        return view('livewire.layouts.managers.manager-navigation');
    }
}
