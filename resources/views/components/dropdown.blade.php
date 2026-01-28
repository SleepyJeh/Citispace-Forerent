@props(['label' => 'Select', 'width' => 'w-48', 'align' => 'right'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'left-0 origin-top-left',
        'right' => 'right-0 origin-top-right',
        default => 'right-0 origin-top-right',
    };
@endphp

<div x-data="{ open: false }" @click.away="open = false" @keydown.escape.stop="open = false" class="relative w-full sm:w-auto">
    {{-- Trigger Button (Exact Style from Revenue Records) --}}
    <button
        @click="open = !open"
        type="button"
        class="w-full sm:w-auto flex items-center justify-between gap-3 bg-[#2B66F5] hover:bg-blue-700 text-white rounded-full px-6 py-2.5 font-opensans font-semibold text-[16px] tracking-[-0.05em] shadow-md transition-all focus:ring-4 focus:ring-blue-300 outline-none"
        aria-haspopup="true"
        :aria-expanded="open"
    >
        <span>{{ $label }}</span>

        {{-- Animated Arrow --}}
        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 text-white transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- Dropdown Panel --}}
    <div
        x-show="open"
        x-transition.origin.top.right
        style="display: none;"
        class="absolute {{ $alignmentClasses }} z-30 w-full sm:{{ $width }} mt-2 bg-white border border-gray-100 rounded-xl shadow-xl overflow-hidden max-h-60 overflow-y-auto custom-scrollbar"
    >
        {{ $slot }}
    </div>
</div>
