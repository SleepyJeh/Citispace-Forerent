<div class="w-full space-y-6">

    <div class="bg-white rounded-2xl shadow-md p-4 md:p-6">


        <h3 class="text-xl font-bold text-gray-900 text-center mb-4">Unit Status</h3>


        <div class="flex justify-center items-center my-6 h-48">
            <div id="unit-status-chart-placeholder" class="relative w-48 h-48">

                <div class="w-full h-full rounded-full bg-gray-200 border-[24px] border-indigo-900" style="border-top-color: #3B82F6; border-left-color: #60A5FA; border-right-color: #93C5FD;"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-4xl font-bold text-gray-900">{{ $totalUnits }}</span>
                    <span class="text-sm text-gray-500">Units</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">

            <div class="bg-slate-50 rounded-xl p-3 flex gap-3 items-center">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-gray-800 text-white">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.47 3.841a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.061l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 101.061 1.06l8.69-8.689z" /><path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" /></svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Occupied</p>
                    <p class="text-base font-bold text-gray-900">{{ $occupied }} Units</p>
                </div>
                <span class="text-xs text-gray-500 self-start">{{ $occupiedPercent }}%</span>
            </div>

            <div class="bg-slate-50 rounded-xl p-3 flex gap-3 items-center">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-600 text-white">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4.5 6.375a.75.75 0 01.75-.75h9a.75.75 0 01.75.75v11.25a.75.75 0 01-.75.75h-9a.75.75 0 01-.75-.75V6.375z" /><path d="M16.5 6.375a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v11.25a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75V6.375zM19.5 9.375a.75.75 0 01.75-.75h.75a.75.75 0 01.75.75v5.25a.75.75 0 01-.75.75h-.75a.75.75 0 01-.75-.75V9.375zM2.25 18.375a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-1.5a.75.75 0 01-.75-.75v-.75a.75.75 0 01.75-.75h1.5zM2.25 15.375a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-1.5a.75.75 0 01-.75-.75v-.75a.75.75 0 01.75-.75h1.5zM2.25 12.375a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-1.5a.75.75 0 01-.75-.75v-.75a.75.75 0 01.75-.75h1.5zM2.25 9.375a.75.75 0 01.75.75v.75a.75.75 0 01-.75.75h-1.5a.75.75 0 01-.75-.75v-.75a.75.75 0 01.75-.75h1.5z" /></svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Vacant</p>
                    <p class="text-base font-bold text-gray-900">{{ $vacant }} Units</p>
                </div>
                <span class="text-xs text-gray-500 self-start">{{ $vacantPercent }}%</span>
            </div>

            <div class="bg-slate-50 rounded-xl p-3 flex gap-3 items-center">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-500 text-white">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 00-1.071 1.05l.004.004A20.317 20.317 0 0111.02 5.62a20.317 20.317 0 01-2.923 2.924.75.75 0 00-1.061 1.061 20.317 20.317 0 01-2.924 2.923.75.75 0 00-1.06 1.061 20.317 20.317 0 01-2.924 2.924.75.75 0 101.06 1.06 20.317 20.317 0 012.924-2.924 20.317 20.317 0 012.923-2.924.75.75 0 001.061-1.06 20.317 20.317 0 012.924-2.924.75.75 0 001.06-1.061 20.317 20.317 0 012.924-2.923.75.75 0 00-1.06-1.061 20.317 20.317 0 01-2.924 2.923 20.317 20.317 0 01-2.923 2.924.75.75 0 00-1.061 1.06 20.317 20.317 0 01-2.924 2.924.75.75 0 00-1.06 1.061 20.317 20.317 0 01-2.925 2.924.75.75 0 101.06 1.06 20.317 20.317 0 012.925-2.924 20.317 20.317 0 012.924-2.924.75.75 0 001.06-1.061 20.317 20.317 0 012.924-2.924.75.75 0 001.061-1.06 20.317 20.317 0 012.924-2.924.75.75 0 10-1.06-1.061 20.317 20.317 0 01-2.924 2.924 20.317 20.317 0 01-2.924 2.923.75.75 0 00-1.06 1.061 20.317 20.317 0 01-2.924 2.924.75.75 0 00-1.061 1.06 20.317 20.317 0 01-2.923 2.924.75.75 0 101.06 1.06 20.317 20.317 0 012.923-2.924 20.317 20.317 0 012.924-2.924.75.75 0 001.06-1.061 20.317 20.317 0 012.924-2.924.75.75 0 00.004-.004l.004-.004a.75.75 0 00-1.061-1.06z" clip-rule="evenodd" /></svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Maintenance</p>
                    <p class="text-base font-bold text-gray-900">{{ $maintenance }} Units</p>
                </div>
                <span class="text-xs text-gray-500 self-start">{{ $maintenancePercent }}%</span>
            </div>

            <div class="bg-slate-50 rounded-xl p-3 flex gap-3 items-center">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-9 w-9 rounded-lg bg-sky-500 text-white">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.75 0a.75.75 0 00-1.5 0v2.258A42.13 42.13 0 006.2 3.107a.75.75 0 00-.64.308L3.23 6.29a.75.75 0 00-.03 1.06l4.1 3.73-1.015 5.56a.75.75 0 001.091.84L12 14.249l4.424 2.22a.75.75 0 001.09-.84l-1.015-5.56 4.1-3.73a.75.75 0 00-.03-1.06l-2.33-2.875a.75.75 0 00-.64-.308 42.13 42.13 0 00-5.05- .85V0z" /></svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Move-In Ready</p>
                    <p class="text-base font-bold text-gray-900">{{ $moveInReady }} Units</p>
                </div>
                <span class="text-xs text-gray-500 self-start">{{ $moveInReadyPercent }}%</span>
            </div>

        </div>

        <div class="grid grid-cols-2 pt-6 border-t border-gray-100">
            <div class="text-center">
                <p class="text-sm text-gray-500">Occupancy Rate</p>
                <p class="text-2xl font-bold text-blue-900">{{ $occupancyRate }}%</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-500">Available Units</p>
                <p class="text-2xl font-bold text-blue-900">{{ $availableUnits }}</sppan>
            </div>
        </div>

    </div>


    <livewire:layouts.vacancy-metrics />


    <livewire:layouts.lease-expiration-overview />

    <livewire:layouts.maintenance-status-metrics />

</div>
