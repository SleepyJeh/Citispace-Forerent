<div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col h-full">

    {{-- 1. Tenant Profile Header --}}
    <div class="bg-blue-600 text-white p-5 rounded-2xl flex items-center gap-4">
        {{-- Large User Icon --}}
        <div class="flex-shrink-0 bg-white p-3 rounded-full shadow">
            <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
        </div>

        {{-- User Info --}}
        <div class="flex-1">
            <h3 class="font-bold text-xl">{{ $manager['name'] }}</h3>
            <div class="flex flex-col gap-0.5 mt-1">
                <span class="flex items-center gap-2 text-sm text-white/80">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2.003 5.884L10 11.884l7.997-6M2 18h16V5l-8 5-8-5v13z" />
                    </svg>
                    {{ $manager['email'] }}
                </span>
                <span class="flex items-center gap-2 text-sm text-white/80">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C6.477 18 2 13.523 2 8V3z" />
                    </svg>
                    {{ $manager['phone'] }}
                </span>
            </div>
        </div>
    </div>

    {{-- 2. Assigned Properties Section --}}
    <div class="mt-6">
        <h4 class="font-bold text-gray-900 text-lg">Assigned Properties</h4>
        <h5 class="font-bold text-gray-800 text-base mt-4">Buildings</h5>
    </div>

    {{-- 3. Building Sorting/Selection Cards --}}
    <div class="flex gap-3 overflow-x-auto pb-3 mt-3 custom-horizontal-scrollbar">
        @foreach ($buildings as $building)
        @php
            $isActive = $building['id'] == $selectedBuildingId;
        @endphp
        <button
            type="button"
            wire:click="selectBuilding({{ $building['id'] }})"
            @class([
                'flex-shrink-0 p-4 rounded-lg w-48 text-left transition-colors',
                'bg-blue-500 text-white shadow-md' => $isActive,
                'bg-white text-blue-700 border border-gray-200 hover:bg-gray-50' => !$isActive,
            ])
        >
            <div class="font-bold text-sm">{{ $building['name'] }}</div>
            <div @class([
                'text-xs mt-1',
                'text-white/80' => $isActive,
                'text-blue-500' => !$isActive,
            ])>
                {{ $building['address'] }}
            </div>
        </button>
        @endforeach
    </div>

    {{-- 4. Property Display View (List) --}}
    <div class="flex-1 flex flex-col min-h-0 mt-6">
        <div class="flex-shrink-0 flex justify-between px-4 py-3 bg-blue-800 rounded-t-lg border-b border-blue-700">
            <span class="w-1/3 text-xs font-semibold text-white/90 uppercase tracking-wider">Unit Number</span>
            <span class="w-1/3 text-xs font-semibold text-white/90 uppercase tracking-wider">Tenant</span>
            <span class="w-1/3 text-xs font-semibold text-white/90 uppercase tracking-wider">Status</span>
        </div>

        {{-- Scrollable Table Content --}}
        <div class="flex-1 overflow-y-auto custom-vertical-scrollbar pr-2 bg-white rounded-b-lg border border-t-0 border-gray-200">
            @forelse ($units as $unit)
            <div class="flex justify-between items-center px-4 py-4 border-b border-gray-100 hover:bg-gray-50">
                <span class="w-1/3 text-sm font-medium text-gray-900">{{ $unit['unit_number'] }}</span>
                <span class="w-1/3 text-sm text-gray-700">
                    @if (strtolower($unit['status']) !== 'vacant')
                        {{ $unit['tenant'] }}
                    @else
                        -
                    @endif
                </span>
                <span class="w-1/3">
                    <span
                        class="px-3 py-1 text-xs font-semibold rounded-full {{ $this->getStatusColor($unit['status']) }}">
                        {{ $unit['status'] }}
                    </span>
                </span>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                No units found for this building.
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Custom scrollbar styles --}}
@push('styles')
<style>
    .custom-vertical-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .custom-vertical-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .custom-vertical-scrollbar::-webkit-scrollbar-thumb {
        background: #0039C6;
        border-radius: 10px;
    }
    .custom-vertical-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #002A8F;
    }

    .custom-horizontal-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .custom-horizontal-scrollbar::-webkit-scrollbar {
        display: none; 
    }
</style>
@endpush
