<?php

namespace App\Livewire\Layouts;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class UnitAccordion extends Component
{
    use WithPagination;

    public $openUnitId = null;

    public array $specifications = [];

    public function mount()
    {
        $this->openUnitId = 1;
        $this->loadSpecifications($this->openUnitId);
    }

    public function toggleUnit(int $unitId)
    {
        if ($this->openUnitId === $unitId) {
            $this->openUnitId = null;
        } else {
            $this->openUnitId = $unitId;
            $this->loadSpecifications($unitId);
        }
    }


    public function loadSpecifications(int $unitId = 1)
    {

        $this->specifications = [
            'room_capacity' => 4,
            'unit_capacity' => 4,
            'room_type' => 'Standard',
            'bed_type' => 'Single',
            'utility_subsidy' => 'Yes',
            'occupied_unit' => '3 of 4',
            'occupied_unit_sub' => 'All Female',
            'base_rate' => '₱ 24,000',
        ];
    }

    private function getMockUnits()
    {
        $allUnits = collect([
            [
                'id' => 1,
                'name' => 'Unit 101',
                'building' => 'The Ridge Wood - 4th Floor',
                'address' => 'Taguig, 1634 Metro Manila, Philippines',
                'status' => 'Occupied',
            ],
            [
                'id' => 2,
                'name' => 'Unit 102',
                'building' => 'The Ridge Wood - 4th Floor',
                'address' => 'Taguig, 1634 Metro Manila, Philippines',
                'status' => 'Vacant',
            ],
            [
                'id' => 3,
                'name' => 'Unit 103',
                'building' => 'The Ridge Wood - 4th Floor',
                'address' => 'Taguig, 1634 Metro Manila, Philippines',
                'status' => 'Vacant',
            ],
            [
                'id' => 4,
                'name' => 'Unit 104',
                'building' => 'The Ridge Wood - 4th Floor',
                'address' => 'Taguig, 1634 Metro Manila, Philippines',
                'status' => 'Occupied',
            ],

            [
                'id' => 5,
                'name' => 'Unit 105',
                'building' => 'The Ridge Wood - 4th Floor',
                'address' => 'Taguig, 1634 Metro Manila, Philippines',
                'status' => 'Vacant',
            ],
        ]);

        $perPage = 4;
        $currentPage = $this->getPage();
        $currentPageItems = $allUnits->slice(($currentPage - 1) * $perPage, $perPage);


        return new LengthAwarePaginator(
            $currentPageItems,
            $allUnits->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }


    public function getStatusTextClass(string $status): string
    {
        return match (strtolower($status)) {
            'occupied' => 'text-red-600',
            'vacant' => 'text-green-600',
            default => 'text-gray-600',
        };
    }


    public function getStatusDotClass(string $status): string
    {
        return match (strtolower($status)) {
            'occupied' => 'bg-red-500',
            'vacant' => 'bg-green-500',
            default => 'bg-gray-500',
        };
    }

    public function render()
    {
        return view('livewire.layouts.unit-accordion', [
            'units' => $this->getMockUnits()
        ]);
    }
}
