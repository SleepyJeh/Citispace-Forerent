<div class="w-full space-y-6">
    {{-- Announcement Widget --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-blue-800 px-6 py-4 flex justify-between items-center">
            <h3 class="text-white text-lg font-semibold">Announcements</h3>
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
                    <div class="flex justify-between items-center mb-1">
                        <div class="text-sm text-blue-700 font-semibold">{{ $announcement['date'] }}</div>
                        <div class="text-xs bg-blue-100 text-blue-800 font-medium px-2 py-0.5 rounded-md">
                            {{ $announcement['property'] }}
                        </div>
                    </div>
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
                        @php
                            $hasAnnouncement = in_array($day, $this->announcementDays);
                            $isSelected = $selectedDate->day == $day && $selectedDate->format('F Y') == $currentMonth;
                        @endphp

                        <div class="relative flex items-center justify-center">
                            <button
                                wire:click="selectDate('{{ $currentYear }}-{{ date('m', strtotime($currentMonth)) }}-{{ $day }}')"
                                class="aspect-square w-full flex flex-col items-center justify-center rounded-lg text-sm transition
                    {{ $isSelected
                        ? 'bg-blue-700 text-white font-semibold shadow-md'
                        : 'hover:bg-gray-100 text-gray-700' }}">
                                <span>{{ $day }}</span>

                                {{-- 🔵 Blue dot indicator for announcements --}}
                                @if($hasAnnouncement)
                                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                @endif
                            </button>
                        </div>
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
                    <div class="border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow bg-gray-50 w-full">
                        <div class="flex flex-col h-full justify-between">
                            <div>
                                <h4 class="text-base font-bold text-gray-900 mb-1 break-words">{{ $event['title'] }}</h4>
                                <p class="text-sm text-gray-600 leading-relaxed break-words">
                                    {{ $event['description'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No events for this day</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Role-Based Content --}}
    @if($userRole === 'landlord')
        {{-- Financial Overview (Landlord Only) --}}
        <div class="space-y-6">
            <h3 class="text-2xl font-bold text-gray-900">Financial Overview</h3>

            {{-- Top Row: Donut Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Rent Collected --}}
                <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-2">Total Rent Collected</p>
                            <p class="text-3xl font-bold">₱ {{ number_format($totalRentCollected) }}</p>
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
                            <p class="text-3xl font-bold">₱ {{ number_format($totalUncollectedRent) }}</p>
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
                            <p class="text-3xl font-bold">₱ {{ number_format($totalIncome) }}</p>
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
                                <span class="text-lg font-bold text-gray-900">₱ {{ number_format($revenueCurrentValue) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Target Value</span>
                                <span class="text-lg font-bold text-gray-900">₱ {{ number_format($revenueTargetValue) }}</span>
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
                                <span class="text-lg font-bold text-gray-900">₱ {{ number_format($expensesCurrentValue) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Target Value</span>
                                <span class="text-lg font-bold text-gray-900">₱ {{ number_format($expensesTargetValue) }}</span>
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
    @elseif($userRole === 'manager')
        {{-- Maintenance Overview (Manager Only) --}}
        <div class="space-y-6">
            <h3 class="text-2xl font-bold text-gray-900">Maintenance</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Maintenance Cost --}}
                <div class="bg-blue-700 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-2">Total Maintenance Cost</p>
                            <p class="text-3xl font-bold">₱ {{ number_format($totalMaintenanceCost ?? 120000) }}</p>
                            <p class="text-xs opacity-75 mt-1">This Month</p>
                        </div>
                    </div>
                </div>

                {{-- New Requests --}}
                <div class="bg-blue-700 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-2">New Requests</p>
                            <p class="text-3xl font-bold">{{ $newRequests ?? 3 }}</p>
                            <p class="text-xs opacity-75 mt-1">This Week</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <rect width="50" height="50" fill="url(#pattern0_1199_1827)"/>
                                <defs>
                                    <pattern id="pattern0_1199_1827" patternContentUnits="objectBoundingBox" width="1" height="1">
                                        <use xlink:href="#image0_1199_1827" transform="scale(0.00390625)"/>
                                    </pattern>
                                    <image id="image0_1199_1827" width="256" height="256" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                                </defs>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Pending Requests --}}
                <div class="bg-blue-700 rounded-xl p-6 text-white shadow-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm opacity-90 mb-2">Pending Requests</p>
                            <p class="text-3xl font-bold">{{ $pendingRequests ?? 3 }}</p>
                            <p class="text-xs opacity-75 mt-1">This Week</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Include Announcement Modal --}}
    <livewire:layouts.announcement-modal />
</div>
