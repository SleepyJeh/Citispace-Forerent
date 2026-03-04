<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    {{-- Calendar Left Side (Compact) --}}
    <div class="bg-white rounded-xl shadow-md p-4 lg:col-span-1">
        <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $currentMonth }}</h3>
        <div class="grid grid-cols-7 gap-1 text-center">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
            <div class="text-xs font-medium text-gray-600 pb-1">{{ $day }}</div>
            @endforeach

                @foreach($calendarDays as $day)
                    @if($day === null)
                        <div class="aspect-square"></div>
                    @else
                        <button
                            wire:click="selectDate('{{ $currentYear }}-{{ date('m', strtotime($currentMonth)) }}-{{ $day }}')"
                            class="aspect-square flex flex-col items-center justify-center rounded text-xs
                {{ \Carbon\Carbon::parse($selectedDate)->day == $day
                    ? 'bg-blue-700 text-white font-bold'
                    : 'hover:bg-gray-100 text-gray-700' }}">
                            <span>{{ $day }}</span>

                            {{-- Dot for days with announcements --}}
                            @if(in_array($day, $announcementDates))
                                <span class="w-1.5 h-1.5 mt-0.5 rounded-full
                    {{ \Carbon\Carbon::parse($selectedDate)->day == $day
                        ? 'bg-white'
                        : 'bg-blue-700' }}">
                </span>
                            @endif
                        </button>
                    @endif
                @endforeach
        </div>
    </div>

    {{-- Daily Events Right Side --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden lg:col-span-3 flex flex-col">
        <div class="bg-blue-700 px-6 py-4">
            <h3 class="text-white text-lg font-semibold">{{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</h3>
        </div>
        <div class="flex-1 flex flex-col">
            @forelse($dailyAnnouncements as $dailyAnnouncement)
            <div class="p-6 space-y-4 max-h-80 overflow-y-auto flex-1">
                @foreach($dailyAnnouncements as $dailyAnnouncement)
                <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                    <h4 class="text-base font-bold text-gray-900 mb-1">{{ $dailyAnnouncement->headline }}</h4>
                    <p class="text-sm text-gray-600">{{ $dailyAnnouncement->details }}</p>
                </div>
                @endforeach
            </div>
            @empty
            <div class="flex-1 flex items-center justify-center p-6">
                <p class="text-gray-500 text-center">No Events for Today</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
