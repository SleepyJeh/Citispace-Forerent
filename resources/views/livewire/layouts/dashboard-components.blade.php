<div class="w-full space-y-6">
    {{-- Announcement Widget --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-blue-800 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white text-lg font-semibold">Announcement</h3>
            <button
                wire:click="$dispatch('open-announcement-modal')"
                type="button"
                class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </div>
        <div class="p-6 space-y-4 max-h-64 overflow-y-auto">
            @forelse($this->announcements as $announcement)
            <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                <div class="text-sm text-blue-700 font-semibold mb-1">{{ $announcement['date'] }}</div>
                <h4 class="text-base font-bold text-gray-900 mb-1">{{ $announcement['title'] }}</h4>
                <p class="text-sm text-gray-600">{{ $announcement['description'] }}</p>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">No announcements yet</p>
            @endforelse
        </div>
    </div>

    {{-- Schedule & Events Block --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Calendar --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $currentMonth }}</h3>
            <div class="grid grid-cols-7 gap-2 text-center">
                {{-- Day headers --}}
                @foreach(['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'] as $day)
                <div class="text-xs font-medium text-gray-600 pb-2">{{ $day }}</div>
                @endforeach

                {{-- Calendar days --}}
                @foreach($this->calendarDays as $day)
                    @if($day === null)
                        <div class="aspect-square"></div>
                    @else
                        <button
                            wire:click="selectDate('{{ $currentYear }}-{{ date('m', strtotime($currentMonth)) }}-{{ $day }}')"
                            class="aspect-square flex items-center justify-center rounded-lg text-sm
                                {{ $selectedDate->day == $day && $selectedDate->format('F Y') == $currentMonth
                                    ? 'bg-blue-700 text-white font-bold'
                                    : 'hover:bg-gray-100 text-gray-700' }}">
                            {{ $day }}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Daily Events --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-blue-700 px-6 py-4">
                <h3 class="text-white text-lg font-semibold">{{ $selectedDate->format('F d, Y') }}</h3>
            </div>
            <div class="p-6 space-y-4 max-h-80 overflow-y-auto">
                @forelse($this->dailyEvents as $event)
                <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                    <h4 class="text-base font-bold text-gray-900 mb-1">{{ $event['title'] }}</h4>
                    <p class="text-sm text-gray-600">{{ $event['description'] }}</p>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No events for this day</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Financial Overview --}}
    <div class="space-y-6">
        <h3 class="text-2xl font-bold text-gray-900">Financial Overview</h3>

        {{-- Top Row: Donut Charts --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Total Rent Collected --}}
            <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-2">Total Rent Collected</p>
                        <p class="text-3xl font-bold">â‚± {{ number_format($totalRentCollected) }}</p>
                    </div>
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-800" stroke-width="3"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-white" stroke-width="3"
                                stroke-dasharray="75, 100" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-semibold">Collected</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Uncollected Rent --}}
            <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-2">Total Uncollected Rent</p>
                        <p class="text-3xl font-bold">â‚± {{ number_format($totalUncollectedRent) }}</p>
                    </div>
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-800" stroke-width="3"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-white" stroke-width="3"
                                stroke-dasharray="25, 100" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-semibold">Uncollected</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Income --}}
            <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm opacity-90 mb-2">Total Income</p>
                        <p class="text-3xl font-bold">â‚± {{ number_format($totalIncome) }}</p>
                    </div>
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-800" stroke-width="3"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-white" stroke-width="3"
                                stroke-dasharray="75, 100" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-semibold">Collected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Row: Gauge Charts --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Revenue --}}
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Revenue</h4>
                <div class="flex flex-col items-center">
                    <div class="relative w-40 h-20 mb-4">
                        <svg class="w-40 h-20" viewBox="0 0 100 50">
                            <path d="M 10,50 A 40,40 0 0,1 90,50" fill="none" class="stroke-current text-gray-200" stroke-width="8" stroke-linecap="round"></path>
                            <path d="M 10,50 A 40,40 0 0,1 90,50" fill="none" class="stroke-current text-blue-600" stroke-width="8"
                                stroke-dasharray="{{ $revenuePercentage }}, 100" stroke-linecap="round"></path>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold text-gray-900">{{ $revenuePercentage }}%</span>
                        </div>
                    </div>
                    <div class="w-full space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Current Value</span>
                            <span class="text-lg font-bold text-gray-900">â‚± {{ number_format($revenueCurrentValue) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Target Value</span>
                            <span class="text-lg font-bold text-gray-900">â‚± {{ number_format($revenueTargetValue) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Expenses --}}
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Total Expenses</h4>
                <div class="flex flex-col items-center">
                    <div class="relative w-40 h-20 mb-4">
                        <svg class="w-40 h-20" viewBox="0 0 100 50">
                            <path d="M 10,50 A 40,40 0 0,1 90,50" fill="none" class="stroke-current text-gray-200" stroke-width="8" stroke-linecap="round"></path>
                            <path d="M 10,50 A 40,40 0 0,1 90,50" fill="none" class="stroke-current text-blue-600" stroke-width="8"
                                stroke-dasharray="{{ $expensesPercentage }}, 100" stroke-linecap="round"></path>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold text-gray-900">{{ $expensesPercentage }}%</span>
                        </div>
                    </div>
                    <div class="w-full space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Current Value</span>
                            <span class="text-lg font-bold text-gray-900">â‚± {{ number_format($expensesCurrentValue) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Target Value</span>
                            <span class="text-lg font-bold text-gray-900">â‚± {{ number_format($expensesTargetValue) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Return On Investment --}}
            <div class="bg-white rounded-xl p-6 shadow-md">
                <h4 class="text-lg font-bold text-gray-900 mb-4">Return On Investment</h4>
                <div class="flex flex-col items-center">
                    <div class="relative w-40 h-20 mb-4">
                        <svg class="w-40 h-20" viewBox="0 0 100 50">
                            <path d="M 10,50 A 40,40 0 0,1 90,50" fill="none" class="stroke-current text-gray-200" stroke-width="8" stroke-linecap="round"></path>
                            <path d="M 10,50 A 40,40 0 0,1 90,50" fill="none" class="stroke-current text-blue-600" stroke-width="8"
                                stroke-dasharray="{{ $roiPercentage }}, 100" stroke-linecap="round"></path>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold text-gray-900">{{ $roiPercentage }}%</span>
                        </div>
                    </div>
                    <div class="w-full space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Current Value</span>
                            <span class="text-lg font-bold text-gray-900">+ {{ $roiCurrentValue }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Target Value</span>
                            <span class="text-lg font-bold text-gray-900">{{ $roiTargetValue }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include Announcement Modal --}}
    <livewire:layouts.announcement-modal />
</div>
