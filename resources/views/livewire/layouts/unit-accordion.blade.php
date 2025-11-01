{{--
  1. MAIN CONTAINER:
   - Fixed responsive height (h-[70vh])
   - Flexbox column layout (flex flex-col)
--}}
<div x-data="{ openUnitId: @entangle('openUnitId') }" class="w-full bg-white rounded-2xl shadow-lg p-4 md:p-6 h-[70vh] flex flex-col">

    {{-- This title is the first flex item --}}
    <span class="com-header text-lg md:text-xl text-blue-900 font-bold mb-4">UNITS</span>

    {{--
      2. SCROLLABLE CONTAINER:
       - Fills remaining space (flex-1)
       - Becomes scrollable if content overflows (overflow-y-auto)
    --}}
    <div class="flex-1 overflow-y-auto pr-2">

        {{--
          !!! THIS IS THE MISSING PART !!!
          This @foreach loop renders the accordion items.
        --}}
        <div class="space-y-4">
            @foreach ($units as $unit)
                {{-- This div holds the Livewire key and contains both states --}}
                <div wire:key="{{ $unit['id'] }}">

                    {{-- 1. INACTIVE (Collapsed) State --}}
                    <button
                        x-show="openUnitId !== {{ $unit['id'] }}"
                        wire:click="toggleUnit({{ $unit['id'] }})"
                        type="button"
                        class="w-full flex justify-between items-center p-4 bg-white border border-blue-200 rounded-2xl text-blue-700 shadow-none"
                        x-cloak
                    >
                        <span class="font-medium text-lg">{{ $unit['name'] }}</span>
                        <svg class="w-6 h-6 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    {{-- 2. ACTIVE (Expanded) State --}}
                    <div
                        x-show="openUnitId === {{ $unit['id'] }}"
                        class="bg-white rounded-2xl shadow-lg"
                        x-cloak
                    >
                        {{-- Active Header (also a button to close) --}}
                        <button
                            wire:click="toggleUnit({{ $unit['id'] }})"
                            type="button"
                            class="w-full p-4 md:p-6 text-left bg-blue-600 text-white rounded-t-2xl"
                        >
                            <div class="flex justify-between items-center">
                                {{-- Left Side: Title and Location --}}
                                <div class="flex flex-col">
                                    <span class="text-sm text-blue-100">{{ $unit['building'] }}</span>
                                    <span class="text-2xl font-bold text-white">{{ $unit['name'] }}</span>
                                    <div class="flex items-center gap-1.5 text-sm text-blue-100 mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                            <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.274 1.765 11.842 11.842 0 00.757.433.62.62 0 00.28.14l.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $unit['address'] }}</span>
                                    </div>
                                </div>
                                {{-- Right Side: Badge and Chevron --}}
                                <div class="flex items-center gap-4 flex-shrink-0">
                                    <span class="bg-white rounded-full px-4 py-1.5 text-sm font-semibold flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full {{ $this->getStatusDotClass($unit['status']) }}"></div>
                                        <span class="{{ $this->getStatusTextClass($unit['status']) }}">{{ $unit['status'] }}</span>
                                    </span>
                                    <svg class="w-6 h-6 text-white transition-transform rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </div>
                        </button>

                        {{-- Active Body (Data) --}}
                        <div class="rounded-b-2xl">
                            {{-- Specs Title Bar --}}
                            <div class="p-4 md:p-6 flex items-center gap-2 border-b border-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-blue-600">
                                    <path d="M11.47 3.841a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.061l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 101.061 1.06l8.69-8.689z" />
                                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                                </svg>
                                <h3 class="font-bold text-blue-700 text-lg">Unit Specifications</h3>
                            </div>

                            {{-- Data Table --}}
                            @if ($openUnitId === $unit['id'] && !empty($specifications))
                            <div class="p-4 md:p-6">
                                {{-- Table Header --}}
                                <div class="bg-indigo-900 text-white font-medium text-sm p-3 grid grid-cols-4 md:grid-cols-7 gap-x-4 rounded-t-lg">
                                    <span>Room Capacity</span>
                                    <span>Unit Capacity</span>
                                    <span>Room Type</span>
                                    <span>Bed Type</span>
                                    <span>Utility Subsidy</span>
                                    <span>Occupied Unit</span>
                                    <span>Base Rate</span>
                                </div>
                                {{-- Table Body --}}
                                <div class="bg-white text-gray-800 text-sm p-3 grid grid-cols-4 md:grid-cols-7 gap-x-4 border border-t-0 border-gray-200 rounded-b-lg">
                                    <span class="font-medium">{{ $specifications['room_capacity'] ?? 'N/A' }}</span>
                                    <span class="font-medium">{{ $specifications['unit_capacity'] ?? 'N/A' }}</span>
                                    <span class="font-medium">{{ $specifications['room_type'] ?? 'N/A' }}</span>
                                    <span class="font-medium">{{ $specifications['bed_type'] ?? 'N/A' }}</span>
                                    <span class="font-medium">{{ $specifications['utility_subsidy'] ?? 'N/A' }}</span>
                                    <div>
                                        <span class="font-medium">{{ $specifications['occupied_unit'] ?? 'N/A' }}</span>
                                        <span class="block text-xs text-gray-500">{{ $specifications['occupied_unit_sub'] ?? '' }}</span>
                                    </div>
                                    <span class="font-bold text-base">{{ $specifications['base_rate'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
        {{-- *** END OF ACCORDION LIST *** --}}


        {{-- Pagination is INSIDE the scrollable div --}}
        <div class="mt-8 pt-4 border-t border-gray-200">
            @if ($units->lastPage() > 1)
            <div class="flex justify-center items-center gap-2 mt-6 md:mt-8 flex-shrink-0">

                {{-- Previous Page Button --}}
                @if ($units->currentPage() > 1)
                <button
                    wire:click="previousPage"
                    class="p-2 w-8 h-8 md:w-10 md:h-10 border-2 border-[#0039C6] bg-[#0039C6] text-white rounded-lg hover:bg-[#002A8F] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
                @endif

                {{-- Page Number Buttons --}}
                <div class="flex gap-2">
                    @for ($page = 1; $page <= $units->lastPage(); $page++)
                        <button
                        wire:click="gotoPage({{ $page }})"
                        class="py-2 px-3 md:px-4 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center font-bold rounded-lg transition-colors text-sm md:text-base
                                {{ $units->currentPage() === $page ? 'bg-[#0039C6] text-white' : 'border-2 border-gray-300 text-gray-700 hover:bg-gray-100' }}">
                        {{ $page }}
                        </button>
                        @endfor
                </div>

                {{-- Next Page Button --}}
                @if ($units->currentPage() < $units->lastPage())
                    <button
                    wire:click="nextPage"
                    class="p-2 w-8 h-8 md:w-10 md:h-10 border-2 border-[#0039C6] bg-[#0039C6] text-white rounded-lg hover:bg-[#002A8F] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    </button>
                    @endif
            </div>
            @endif
        </div>
        {{-- *** END OF PAGINATION BLOCK *** --}}
 
    </div>
    {{-- *** END OF SCROLLABLE CONTAINER *** --}}

</div>
