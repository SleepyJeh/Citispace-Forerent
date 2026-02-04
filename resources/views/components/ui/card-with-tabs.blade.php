@props([
    'tabs' => [],
    'activeTab' => '',
    'filters' => null,
    'counts' => [] // 1. New Prop for the numbers
])

<div class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm p-4 md:p-8 min-h-[600px] flex flex-col relative">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6 md:mb-8">

        {{-- Tabs --}}
        @if(count($tabs) > 0)
            <div class="bg-[#E6F0FF] rounded-xl p-1 flex flex-col sm:flex-row items-center w-full lg:w-fit gap-1 sm:gap-0">
                @foreach($tabs as $key => $label)
                    <button
                        wire:click="$set('activeTab', '{{ $key }}')"
                        class="w-full sm:w-auto px-6 py-2 rounded-lg font-opensans font-semibold text-[16px] md:text-[20px] tracking-[-0.05em] transition-all duration-200 flex items-center justify-center gap-2
                        {{ $activeTab === $key ? 'bg-[#3D79FF] text-white shadow-md' : 'text-gray-500 hover:text-gray-700' }}">

                        {{-- Tab Title --}}
                        <span>{{ $label }}</span>

                        {{-- 2. The Count Badge --}}
                        @if(isset($counts[$key]))
                            <span class="flex items-center justify-center min-w-[20px] h-6 px-1.5 text-xs rounded-full transition-colors
                                {{ $activeTab === $key ? 'bg-white text-[#3D79FF]' : 'bg-white/60 text-gray-400' }}">
                                {{ $counts[$key] }}
                            </span>
                        @endif

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

    {{-- Footer --}}
    @if(isset($footer))
        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex justify-center">
                {{ $footer }}
            </div>
        </div>
    @endif
</div>
