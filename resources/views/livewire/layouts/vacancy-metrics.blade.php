<div class="w-full bg-white rounded-2xl shadow-md p-4 md:p-6">

    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-4">
        Vacancy Metrics
    </h3>

    <div>
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-medium text-gray-700">Vacancy Rate</span>
            <span class="text-sm font-medium text-gray-700">{{ $vacantCount }} of {{ $totalCount }}</span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-1.5">
            <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $vacancyPercent }}%"></div>
        </div>

        <div class="w-full flex" style="padding-left: {{ $vacancyPercent }}%">
            <span class="text-xs text-gray-500 mt-1 -translate-x-full">{{ $vacancyPercent }}%</span>
        </div>
    </div>

    <hr class="my-6 border-gray-200">

    <div class="space-y-3">

        <div class="bg-blue-600 rounded-2xl p-4 flex items-center gap-4 text-white">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg" style="background-color: #629BF8;">
                <svg class="w-6 h-6" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.64062 5.79688V7.86087" stroke="white" stroke-width="1.0062" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.7676 5.79688V7.86087" stroke="white" stroke-width="1.0062" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.3165 6.82812H7.09255C6.52259 6.82812 6.06055 7.29017 6.06055 7.86013V15.0841C6.06055 15.6541 6.52259 16.1161 7.09255 16.1161H14.3165C14.8865 16.1161 15.3485 15.6541 15.3485 15.0841V7.86013C15.3485 7.29017 14.8865 6.82812 14.3165 6.82812Z" stroke="white" stroke-width="1.0062" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6.06055 9.92383H15.3485" stroke="white" stroke-width="1.0062" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-light text-blue-100">AverageDaysVacant</p>
                <p class="text-2xl font-bold">{{ $avgDaysVacant }} Days</p>
            </div>
        </div>

        <div class="bg-blue-600 rounded-2xl p-4 flex items-center gap-4 text-white">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg" style="background-color: #629BF8;">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <div class="flex-1 flex justify-between items-center">
                <div>
                    <p class="text-sm font-light text-blue-100">LongestVacantUnit</p>
                    <p class="text-2xl font-bold">{{ $longestVacantUnit }}</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold">{{ $longestVacantDays }} Days</p>
                    <p class="text-sm font-light text-blue-100">Vacant</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-600 rounded-2xl p-4 flex items-center gap-4 text-white">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg" style="background-color: #629BF8;">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M11.47 3.841a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.061l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 101.061 1.06l8.69-8.689z" />
                    <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-light text-blue-100">ReadyToLease</p>
                <p class="text-2xl font-bold">{{ $readyToLeaseCount }} Units</p>
            </div>
        </div>

    </div>
</div>
