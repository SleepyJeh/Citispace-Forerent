<div class="bg-white rounded-2xl px-6 py-8 shadow-sm border border-gray-100 flex flex-col justify-between h-full">
    <h4 class="text-lg font-bold text-gray-900 mb-6 text-center">{{ $title }}</h4>

    <div class="flex flex-col items-center justify-center flex-1 gap-6">
        {{-- Gauge SVG --}}
        <div class="relative w-64 h-32">
            <svg class="w-full h-full" viewBox="0 0 100 50">
                <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#E5E7EB" stroke-width="6" stroke-linecap="round"/>
                <path d="M 10 50 A 40 40 0 0 1 90 50" fill="none" stroke="#1D4ED8" stroke-width="6" stroke-linecap="round"
                      stroke-dasharray="{{ (min($percentage, 100) / 100) * 126 }}, 126" />
            </svg>
            <div class="absolute inset-0 flex items-end justify-center pb-2">
                <span class="text-2xl font-bold text-gray-900">{{ $percentage }}%</span>
            </div>
        </div>

        {{-- Stats --}}
        <div class="w-full space-y-2 px-4">
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-gray-500">Current Value</span>
                <span class="text-lg font-bold text-gray-900">{{ $prefix }}{{ $currentValue }}{{ $suffix }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-gray-500">Target Value</span>
                <span class="text-lg font-bold text-gray-900">{{ $prefix }}{{ $targetValue }}</span>
            </div>
        </div>
    </div>
</div>
