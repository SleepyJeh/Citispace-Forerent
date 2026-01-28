@props([
    'tabs' => [],      
    'activeTab' => '', 
    'filters' => null, 
])

<div class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm p-4 md:p-8 min-h-[600px] flex flex-col relative">
    {{-- Header: Tabs (Left) & Filters (Right) --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 md:mb-8">
        
        {{-- Tabs --}}
        @if(count($tabs) > 0)
            <div class="bg-[#E6F0FF] rounded-xl p-1 flex flex-col sm:flex-row items-center w-full lg:w-fit gap-1 sm:gap-0">
                @foreach($tabs as $key => $label)
                    <button
                        wire:click="$set('activeTab', '{{ $key }}')"
                        class="w-full sm:w-auto px-6 py-2 rounded-lg font-opensans font-semibold text-[16px] md:text-[20px] tracking-[-0.05em] transition-all duration-200
                        {{ $activeTab === $key ? 'bg-[#3D79FF] text-white shadow-md' : 'text-gray-500 hover:text-gray-700' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Filters Slot --}}
        @if($filters)
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto justify-end">
                {{ $filters }}
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="relative flex-grow">
        {{ $slot }}
    </div>

    {{-- Footer/Pagination --}}
    @if(isset($footer))
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex justify-center">
                {{ $footer }}
            </div>
        </div>
    @endif
</div>
