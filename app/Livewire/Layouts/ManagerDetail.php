<?php

namespace App\Livewire\Layouts;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class ManagerDetail extends Component
{
    public $currentManagerId = null;
    public $currentManager = null;
    public $buildings = [];
    public $units = [];
    public $beds = [];
    public $selectedBuildingId = null;
    public $totalBuildings = 0;
    public $totalUnits = 0;

    /*----------------------------------
    | LIFECYCLE HOOKS
    ----------------------------------*/
    public function mount(): void
    {
        // No need to store modalId anymore
    }

    /*----------------------------------
    | LISTENERS
    ----------------------------------*/
    #[On('managerSelected')]
    public function loadManager(?int $managerId): void
    {
        // Guard against null manager ID
        if (!$managerId) {
            $this->resetManagerData();
            return;
        }

        $this->currentManagerId = $managerId;
        $this->currentManager = User::find($managerId);

        // If manager not found, reset data
        if (!$this->currentManager) {
            $this->resetManagerData();
            return;
        }

        // Only load units that belong to properties owned by the authenticated landlord
        $this->units = $this->getManagedUnits($managerId);
        $this->totalUnits = count($this->units);

        $this->buildings = $this->getBuildingsManaged($this->units);
        $this->totalBuildings = count($this->buildings);

        // Reset selected building when switching managers
        $this->selectedBuildingId = null;
    }

    #[On('managerUpdated')]
    public function refreshManagerData($managerId): void
    {
        // Reload the manager data after edit
        $this->loadManager($managerId);
    }

    #[On('managerModalClosed')]
    public function refreshOnModalClose(): void
    {
        // Reload current manager data when modal is closed (including cancel)
        if ($this->currentManagerId) {
            $this->loadManager($this->currentManagerId);
        }
    }

    /*----------------------------------
    | UI ACTIONS
    ----------------------------------*/
    public function selectBuilding(int $buildingId): void
    {
        if (!$this->currentManagerId) {
            return;
        }

        $this->selectedBuildingId = $buildingId;
        $this->units = $this->getManagedUnits($this->currentManagerId, $buildingId);
    }

    public function editManager(): void
    {
        if ($this->currentManagerId) {
            // Use the same modalId as your "Add Manager" button
            $this->dispatch('openEditManagerModal_manager-dashboard', managerId: $this->currentManagerId);
        }
    }

    /*----------------------------------
    | HELPERS
    ----------------------------------*/
    private function resetManagerData(): void
    {
        $this->currentManagerId = null;
        $this->currentManager = null;
        $this->units = [];
        $this->buildings = [];
        $this->totalBuildings = 0;
        $this->totalUnits = 0;
        $this->selectedBuildingId = null;
    }

    private function getManagedUnits(int $managerId, ?int $propertyId = null): Collection
    {
        $query = Unit::where('manager_id', $managerId)
            ->with(['property', 'beds'])
            ->whereHas('property', function ($query) {
                // Only show units from properties owned by the authenticated landlord
                $query->where('owner_id', auth()->id());
            })
            ->select('units.*'); // Make sure all unit columns are selected

        if ($propertyId) {
            $query->where('property_id', $propertyId);
        }

        return $query->get()->each(function ($unit) {
            $unit->total_beds = $unit->beds->count();
            $unit->available_beds = $unit->beds->where('status', 'Vacant')->count();
            $unit->status = $unit->available_beds === 0 ? 'Full' : 'Vacant';

            // If bed_type is on the units table, it should already be loaded
            // If it's on the beds table, get it from the first bed
            if (!isset($unit->bed_type) || empty($unit->bed_type)) {
                $unit->bed_type = $unit->beds->first()?->bed_type ?? 'N/A';
            }
        });
    }

    private function getBuildingsManaged(Collection $units): Collection
    {
        return new Collection($units->pluck('property')->unique('property_id')->values()->sortBy('property_id'));
    }

    public function render()
    {
        return view('livewire.layouts.manager-detail');
    }
}
