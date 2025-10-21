{{-- MODIFIED: Added h-full and flex flex-col --}}
<div class="w-full bg-white p-6 rounded-2xl shadow-md h-full flex flex-col">
    <h2 class="text-xl font-bold text-gray-800 mb-4">Units</h2>

    {{-- MODIFIED: Replaced max-h-[400px] with flex-1 to fill available space --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-3">

        {{-- Loop through the PAGINATED units --}}
        @foreach ($paginatedUnits as $unit)
        @php
        // Define the base, active, and inactive classes for cleaner code
        $baseClasses = 'w-full text-left font-semibold p-4 rounded-lg border-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400';

        // Determine which style to apply based on the active state
        $isActive = ($unit['id'] == $this->activeUnitId);

        $activeClasses = 'bg-blue-600 text-white border-blue-600';
        $inactiveClasses = 'bg-transparent text-blue-600 border-gray-200 hover:bg-blue-50 hover:border-blue-500';
        @endphp

        <button
            type="button"
            wire:click="selectUnit({{ $unit['id'] }})"
            class="{{ $baseClasses }} {{ $isActive ? $activeClasses : $inactiveClasses }}">
            {{ $unit['name'] }}
        </button>
        @endforeach
    </div>

    @if ($totalPages > 1)
    {{-- This pagination block is now correctly positioned at the bottom --}}
    <div class="flex justify-center items-center gap-2 mt-6 md:mt-8">

        @if ($currentPage > 1)
        <button
            wire:click="previousPage"
            class="p-2 w-8 h-8 md:w-10 md:h-10 border-2 border-[#0039C6] bg-[#0039C6] text-white rounded-lg hover:bg-[#002A8F] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </button>
        @endif

        <div class="flex gap-2">
            @for ($page = 1; $page <= $totalPages; $page++)
                <button
                wire:click="gotoPage({{ $page }})"
                class="py-2 px-3 md:px-4 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center font-bold rounded-lg transition-colors text-sm md:text-base
                        {{ $currentPage === $page ? 'bg-[#0039C6] text-white' : 'border-2 border-gray-300 text-gray-700 hover:bg-gray-100' }}">
                {{ $page }}
                </button>
                @endfor
        </div>

        @if ($currentPage < $totalPages)
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

{{-- Add the custom scrollbar styles --}}
@push('styles')
<style>
    /* Custom Scrollbar Styling */
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
</style>
@endpush