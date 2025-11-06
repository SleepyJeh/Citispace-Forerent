<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Unit;
use App\Models\Bed;

class UnitAccordion extends Component
{
    use WithPagination;

    public $openUnitId = null;
    public $selectedBuildingId = null;
    public $specifications = [];
    public $hoveredUnitId = null;

    /**
     * Listen for building selection from property.blade.php
     */
    #[On('buildingSelected')]
    public function loadUnitsForBuilding($buildingId)
    {
        $this->selectedBuildingId = $buildingId;
        $this->resetPage();
        $this->specifications = [];
        $this->openUnitId = null;
        $this->hoveredUnitId = null;

        // Auto-open the first unit if available
        $firstUnit = Unit::where('property_id', $this->selectedBuildingId)->first();
        if ($firstUnit) {
            $this->openUnitId = $firstUnit->unit_id;
            $this->loadSpecifications($this->openUnitId);
        }
    }

    /**
     * Redirect to add property page
     */
    public function redirectToAddProperty()
    {
        return redirect()->route('properties.create');
    }

    /**
     * Toggle unit accordion
     */
    public function toggleUnit($unitId)
    {
        if ($this->openUnitId === $unitId) {
            $this->openUnitId = null;
            $this->specifications = [];
        } else {
            $this->openUnitId = $unitId;
            $this->loadSpecifications($unitId);
        }
        $this->hoveredUnitId = null;
    }

    /**
     * Set hover state
     */
    public function setHover($unitId)
    {
        $this->hoveredUnitId = $unitId;
    }

    /**
     * Clear hover state
     */
    public function clearHover()
    {
        $this->hoveredUnitId = null;
    }

    /**
     * Load specifications from database
     */
    public function loadSpecifications($unitId)
    {
        $unit = Unit::with(['property', 'beds'])->find($unitId);

        if (!$unit) {
            $this->specifications = [];
            return;
        }

        // Calculate occupancy
        $occupiedCount = $unit->beds->where('status', 'Occupied')->count();
        $totalCapacity = $unit->unit_cap;

        // Process amenities
        $amenities = json_decode($unit->amenities, true) ?? [];
        $utilitySubsidy = in_array('Utility_Subsidy', $amenities) ? 'Yes' : 'No';

        $displayAmenities = [];
        foreach ($amenities as $amenity) {
            if ($amenity !== 'Utility_Subsidy') {
                $displayAmenities[] = ucwords(str_replace('_', ' ', $amenity));
            }
        }

        // Build specifications
        $this->specifications = [
            'room_capacity' => $unit->room_cap ?? 'N/A',
            'unit_capacity' => $unit->unit_cap ?? 'N/A',
            'room_type' => $unit->room_type ?? 'N/A',
            'bed_type' => $unit->bed_type ?? 'N/A',
            'utility_subsidy' => $utilitySubsidy,
            'occupied_unit' => "$occupiedCount of $totalCapacity",
            'occupied_unit_sub' => $unit->occupants ?? 'N/A',
            'base_rate' => '₱ ' . number_format($unit->price, 0, '.', ','),
            'amenities' => $displayAmenities
        ];
    }

    /**
     * Status styling helpers
     */
    public function getStatusTextClass($status)
    {
        return match (strtolower($status)) {
            'occupied' => 'text-red-600',
            'vacant', 'available' => 'text-green-600',
            'maintenance' => 'text-yellow-600',
            default => 'text-gray-600',
        };
    }

    public function getStatusDotClass($status)
    {
        return match (strtolower($status)) {
            'occupied' => 'bg-red-500',
            'vacant', 'available' => 'bg-green-500',
            'maintenance' => 'bg-yellow-500',
            default => 'bg-gray-500',
        };
    }

    /**
     * Calculate unit status based on bed occupancy
     */
    public function calculateUnitStatus($unit)
    {
        $occupiedCount = $unit->beds->where('status', 'Occupied')->count();
        $totalCapacity = $unit->unit_cap;

        if ($occupiedCount >= $totalCapacity) {
            return 'Occupied';
        } elseif ($occupiedCount > 0) {
            return 'Available';
        } else {
            return 'Vacant';
        }
    }

    /**
     * Get floor suffix (1st, 2nd, 3rd, etc.)
     */
    public function getFloorSuffix($floorNumber)
    {
        if ($floorNumber % 100 >= 11 && $floorNumber % 100 <= 13) {
            return $floorNumber . 'th';
        }

        return match ($floorNumber % 10) {
            1 => $floorNumber . 'st',
            2 => $floorNumber . 'nd',
            3 => $floorNumber . 'rd',
            default => $floorNumber . 'th',
        };
    }

    public function getUnitAmenities($unit)
    {
        $amenities = [];

        // Map from unit amenities JSON data
        $unitAmenities = json_decode($unit->amenities, true) ?? [];

        // Convert amenity keys to display names
        foreach ($unitAmenities as $amenity) {
            $displayName = ucwords(str_replace('_', ' ', $amenity));
            $amenities[] = $displayName;
        }

        return $amenities;
    }

    public function render()
    {
        // Always return a paginator instance, even when no building is selected
        if ($this->selectedBuildingId) {
            $units = Unit::where('property_id', $this->selectedBuildingId)
                ->with(['property', 'beds'])
                ->withCount(['beds as occupied_beds_count' => function ($query) {
                    $query->where('status', 'Occupied');
                }])
                ->paginate(4);
        } else {
            // Return empty paginator when no building is selected
            $units = new LengthAwarePaginator([], 0, 4, 1);
        }

        return view('livewire.layouts.unit-accordion', [
            'units' => $units
        ]);
    }
}
