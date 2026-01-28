<div class="bg-white rounded-2xl shadow-md p-4 md:p-6">

    <h3 class="text-xl font-bold text-gray-900 mb-4">Vacancy Metrics</h3>

    {{-- Vacancy Rate Progress --}}
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Vacancy Rate</span>
            <span class="text-sm font-medium text-gray-700">{{ $vacantCount }} of {{ $totalCount }}</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-[#2360E8] h-2 rounded-full transition-all" style="width: {{ $vacancyPercent }}%"></div>
        </div>
        <div class="flex justify-end mt-1">
            <span class="text-xs text-gray-500">{{ $vacancyPercent }}%</span>
        </div>
    </div>

    <hr class="my-6 border-gray-200">

    {{-- Metric Cards --}}
    <div class="space-y-3">

        {{-- Average Days Vacant --}}
        <div class="bg-[#2360E8] rounded-2xl p-4 flex items-center gap-4 text-white">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg bg-[#629BF8]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-light text-blue-100">Average Days Vacant</p>
                <p class="text-2xl font-bold">{{ $avgDaysVacant }} Days</p>
            </div>
        </div>

        {{-- Longest Vacant Unit --}}
        <div class="bg-[#2360E8] rounded-2xl p-4 flex items-center gap-4 text-white">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg bg-[#629BF8]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1 flex justify-between items-center">
                <div>
                    <p class="text-sm font-light text-blue-100">Longest Vacant Unit</p>
                    <p class="text-2xl font-bold">{{ $longestVacantUnit }}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold">{{ $longestVacantDays }}</p>
                    <p class="text-sm font-light text-blue-100">Days</p>
                </div>
            </div>
        </div>

        {{-- Ready to Lease --}}
        <div class="bg-[#2360E8] rounded-2xl p-4 flex items-center gap-4 text-white">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg bg-[#629BF8]">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.47 3.841a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.061l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 101.061 1.06l8.69-8.689z"/>
                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-light text-blue-100">Ready to Lease</p>
                <p class="text-2xl font-bold">{{ $readyToLeaseCount }} Units</p>
            </div>
        </div>

    </div>

</div>
