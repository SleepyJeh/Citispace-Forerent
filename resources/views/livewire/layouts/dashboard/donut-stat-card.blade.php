<div class="bg-[#2563EB] rounded-2xl px-6 py-8 text-white shadow-lg relative overflow-hidden flex items-center justify-between min-h-[160px]">

    <div class="flex flex-col gap-2 z-10 relative">
        <span class="text-sm font-medium text-blue-100 opacity-90 leading-tight">
            {!! nl2br(e($title)) !!} {{-- Allows line breaks if passed --}}
        </span>
        <span class="text-3xl font-bold">&#8369; {{ number_format($amount) }}</span>
    </div>

    {{-- Donut Chart --}}
    <div class="relative w-32 h-32 flex-shrink-0">
        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
            <path class="text-blue-800"
                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="3"
                  stroke-opacity="0.5" />

            <path class="text-white"
                  stroke-dasharray="{{ $percentage }}, 100"
                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="3"
                  stroke-linecap="round" />
        </svg>
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-[10px] font-medium text-white tracking-wide">{{ $label }}</span>
        </div>
    </div>
</div>
