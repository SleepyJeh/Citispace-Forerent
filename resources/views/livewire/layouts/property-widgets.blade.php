<div class="flex flex-col gap-6 w-full max-w-sm shrink-0">

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-gray-900 font-bold mb-4">Unit Status</h3>

        <div class="relative w-40 h-40 mx-auto mb-6">
            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                <path class="text-gray-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.8" />
                <path class="text-blue-600" stroke-dasharray="75, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.8" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-2xl font-bold text-gray-900">200</span>
                <span class="text-xs text-gray-500">Units</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-xs">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#070589]"></span>
                <span class="text-gray-600">Occupied</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <span class="text-gray-600">Vacant</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                <span class="text-gray-600">Maintenance</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-200"></span>
                <span class="text-gray-600">Available</span>
            </div>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between text-center">
            <div>
                <p class="text-xs text-gray-500">Occupancy Rate</p>
                <p class="font-bold text-gray-900">64.0%</p>
            </div>
            <div>
                <p class="text-xs text-gray-500">Available Units</p>
                <p class="font-bold text-gray-900">15</p>
            </div>
        </div>
    </div>

    <livewire:layouts.units.vacancy-metrics />

</div>
