<div class="w-full bg-white rounded-2xl shadow-md h-full flex flex-col overflow-hidden relative">
    <!-- Header (fixed) -->
    <div class="flex-shrink-0 p-4 md:p-6 border-b border-gray-100">
        <h2 class="text-xl md:text-2xl font-bold text-gray-800">Current Tenants</h2>
    </div>

    <!-- Scrollable Tenant List -->
    <div class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-4 min-h-0 max-h-[70vh]">
        @forelse ($units as $unit)
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                {{-- Unit Header --}}
                <div class="p-4 bg-gray-100 border-b border-gray-200">
                    <span class="font-semibold text-gray-800">🏢 {{ $unit['unit_number'] ?? 'Unnamed Unit' }}</span>
                </div>

                {{-- Beds --}}
                <div class="bg-white">
                    @forelse ($unit['beds'] as $bed)
                        <div class="border-t border-gray-100 p-4 space-y-2">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">

                                {{-- Bed Button --}}
                                @php
                                    $bedIsActive = ($bed['bed_id'] == $this->activeBedId);
                                    $bedButtonClasses = $bedIsActive
                                        ? 'bg-green-100 text-green-800 border-green-300 shadow-sm'
                                        : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-green-50 hover:text-green-700 hover:border-green-300 hover:shadow-sm';
                                @endphp
                                <button
                                    type="button"
                                    wire:click="selectBed({{ $bed['bed_id'] }})"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    class="text-left font-medium px-3 py-2 rounded-lg border transition-all duration-200 {{ $bedButtonClasses }}"
                                    title="Click to view bed details"
                                >
                                    🛏️ {{ $bed['bed_number'] ?? 'Bed' }}
                                </button>

                                {{-- Tenant Button (optional) --}}
                                @php
                                    $tenant = $bed['tenant'] ?? null;
                                    $isActive = $tenant && ($tenant['user_id'] == $this->activeTenantId);
                                    $tenantButtonClasses = $isActive
                                        ? 'bg-blue-600 text-white border-blue-600 shadow-md'
                                        : 'bg-white text-gray-700 border-gray-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-500 hover:shadow-sm';
                                @endphp
                                @if ($tenant)
                                    <button
                                        type="button"
                                        wire:click="selectTenant({{ $tenant['user_id'] }})"
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                        class="text-left font-semibold px-4 py-2 rounded-lg border-2 transition-all duration-200 {{ $tenantButtonClasses }}"
                                        title="Click to view {{ $tenant['first_name'] }}'s details"
                                    >
                                        👤 {{ $tenant['first_name'] }} {{ $tenant['last_name'] }}
                                    </button>
                                @else
                                    <span class="text-gray-400 italic px-4 py-2">No tenant assigned</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="border-t border-gray-100 p-4 text-gray-400 italic">
                            No beds found in this unit.
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="w-full flex flex-col items-center justify-center text-center p-8 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                </svg>
                <p class="text-gray-500 text-lg">Select a building to view tenants</p>
            </div>
        @endforelse
    </div>

    {{-- Loading Overlay --}}
    <div wire:loading wire:target="handlePropertySelected" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10">
        <div class="flex flex-col items-center gap-3">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <p class="text-sm text-gray-600">Loading tenants...</p>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #0039C6;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #002A8F;
        }
        button {
            transition: all 0.2s ease-in-out;
        }
        /* Ensure buttons remain clickable */
        button:not(:disabled) {
            pointer-events: auto;
            cursor: pointer;
        }
    </style>
@endpush
