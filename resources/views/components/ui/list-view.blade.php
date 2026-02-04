@props([
    'title' => 'List',
    'tabs' => [],
    'activeTab' => null,
    'counts' => []
])

<div class="bg-white rounded-2xl shadow-md h-full flex flex-col w-full border border-gray-100 overflow-hidden">

    {{-- 1. Header Section (Title + Tabs) --}}
    <div class="flex-shrink-0 px-5 pt-5 pb-0 bg-white z-10">
        <h2 class="text-xl font-bold text-[#070642] mb-4">{{ $title }}</h2>

        {{-- Optional Tabs --}}
        @if(count($tabs) > 0)
        <div class="flex items-center gap-6 border-b border-gray-100">
            @foreach($tabs as $key => $label)
                <button
                    wire:click="setTab('{{ $key }}')"
                    class="pb-3 text-sm font-bold transition-all relative
                    {{ $activeTab === $key ? 'text-[#070642]' : 'text-gray-400 hover:text-gray-600' }}">
                    {{ $label }}

                    {{-- Count Badge --}}
                    @if(isset($counts[$key]))
                        <span class="ml-1 text-xs opacity-70 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $counts[$key] }}</span>
                    @endif

                    {{-- Active Line --}}
                    @if($activeTab === $key)
                        <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#070642] rounded-t-full"></div>
                    @endif
                </button>
            @endforeach
        </div>
        @endif
    </div>

    {{-- 2. Scrollable List Area --}}
    {{-- 'flex-1 min-h-0' is the magic combo that forces the scrollbar to appear instead of growing endlessly --}}
    <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar min-h-0">
        {{ $slot }}
    </div>
</div>
