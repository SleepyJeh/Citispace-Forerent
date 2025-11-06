<?php

namespace App\Livewire\Layouts;

use App\Models\{Unit, Lease};
use Livewire\Component;
use Livewire\Attributes\On;

class TenantNavigation extends Component
{
    public $units = [];
    public $activeTenantId = null;
    public $activeBedId = null;
    public $selectedPropertyId = null;
    public $loading = false;

    public function mount(): void
    {
        $this->resetState();

        \Log::info('🚀 TenantNavigation MOUNTED', [
            'selectedPropertyId' => $this->selectedPropertyId,
            'auth_id' => auth()->id(),
        ]);
    }

    /*----------------------------------
    | EVENT LISTENERS
    ----------------------------------*/
    #[On('propertySelected')]
    public function handlePropertySelected($propertyId): void
    {
        \Log::info('🎯 PROPERTY SELECTED EVENT RECEIVED', [
            'propertyId' => $propertyId,
            'type' => gettype($propertyId),
        ]);

        $this->selectedPropertyId = is_array($propertyId) && isset($propertyId['propertyId'])
            ? (int) $propertyId['propertyId']
            : (int) $propertyId;

        \Log::info('🔄 Processing property selection', [
            'finalPropertyId' => $this->selectedPropertyId,
        ]);

        // Reset state before loading new units
        $this->resetState();

        $this->loadUnits();
    }

    #[On('refresh-tenant-navigation')]
    public function refreshNavigation(): void
    {
        \Log::info('🔄 REFRESHING NAVIGATION - tenant moved out');

        if ($this->selectedPropertyId) {
            $this->resetState();
            $this->loadUnits();
            \Log::info('✅ NAVIGATION REFRESHED after tenant move out');
        }
    }

    /*----------------------------------
    | RESET STATE
    ----------------------------------*/
    private function resetState(): void
    {
        $this->units = collect();
        $this->activeTenantId = null;
        $this->activeBedId = null;
        $this->loading = false;
    }

    /*----------------------------------
    | CORE LOADING LOGIC
    ----------------------------------*/
    public function loadUnits(): void
    {
        if (!$this->selectedPropertyId) {
            \Log::warning('❌ No selectedPropertyId in loadUnits()');
            return;
        }

        $managerId = auth()->id();
        $this->loading = true;

        try {
            $units = Unit::where('property_id', $this->selectedPropertyId)
                ->where('manager_id', $managerId)
                ->with([
                    'beds' => fn($q) => $q->orderBy('bed_number'),
                    'beds.leases' => fn($q) => $q->where('status', 'active')->where('end_date', '>=', now()),
                    'beds.leases.tenant' => fn($q) => $q->where('role', 'tenant')->whereNull('deleted_at'),
                ])
                ->orderBy('unit_number')
                ->get();

            // Map units and beds safely
            $this->units = $units->map(function ($unit) {
                return [
                    'unit_id' => $unit->unit_id,
                    'unit_number' => $unit->unit_number,
                    'beds' => $unit->beds->map(function ($bed) {
                        $activeLease = $bed->leases->first();
                        $tenant = $activeLease?->tenant;

                        return [
                            'bed_id' => $bed->bed_id,
                            'bed_number' => $bed->bed_number,
                            'tenant' => $tenant ? [
                                'user_id' => $tenant->user_id,
                                'first_name' => $tenant->first_name,
                                'last_name' => $tenant->last_name,
                                'email' => $tenant->email,
                            ] : null,
                        ];
                    })->sortBy('bed_number')->values(),
                ];
            });

            \Log::info('✅ UNITS LOADED SUCCESSFULLY', [
                'property_id' => $this->selectedPropertyId,
                'units_count' => $this->units->count(),
            ]);

        } catch (\Exception $e) {
            \Log::error('❌ ERROR loading units', [
                'error' => $e->getMessage(),
                'property_id' => $this->selectedPropertyId,
            ]);
        }

        $this->activeBedId = null;
        $this->activeTenantId = null;
        $this->loading = false;
    }

    /*----------------------------------
    | UI ACTIONS - BED SELECTION
    ----------------------------------*/
    public function selectBed($bedId = null)
    {
        if (!$bedId) return;

        \Log::info('✅ selectBed called', ['bedId' => $bedId]);

        $this->activeBedId = (int) $bedId;
        $this->activeTenantId = null;

        $this->dispatch('bedSelectedForPreviousTenants', bedId: $bedId);
        $this->dispatch('bedSelected', bedId: $bedId);
    }

    /*----------------------------------
    | UI ACTIONS - TENANT SELECTION
    ----------------------------------*/
    public function selectTenant($tenantId = null)
    {
        if (!$tenantId) return;

        \Log::info('✅ selectTenant called', ['tenantId' => $tenantId]);

        $this->activeTenantId = (int) $tenantId;

        // Auto-select the bed for this tenant
        foreach ($this->units as $unit) {
            foreach ($unit['beds'] as $bed) {
                if ($bed['tenant'] && $bed['tenant']['user_id'] == $tenantId) {
                    $this->activeBedId = $bed['bed_id'];
                    break 2;
                }
            }
        }

        $this->dispatch('tenantSelected', tenantId: $tenantId);
    }

    /*----------------------------------
    | RENDER
    ----------------------------------*/
    public function render()
    {
        \Log::info('🔄 TenantNavigation RENDER', [
            'selectedPropertyId' => $this->selectedPropertyId,
            'units_count' => $this->units->count(),
            'activeTenantId' => $this->activeTenantId,
            'activeBedId' => $this->activeBedId,
        ]);

        return view('livewire.layouts.tenant-navigation');
    }
}
