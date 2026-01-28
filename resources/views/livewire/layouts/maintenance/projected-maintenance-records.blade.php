<div>
    {{-- Tab Navigation --}}
    <div>
        <div class="flex gap-2 bg-white rounded-t-xl shadow-md overflow-hidden">
            <button wire:click="$set('activeTab', 'schedule')"
                class="flex-1 px-6 py-4 font-semibold transition-all duration-200 {{ $activeTab === 'schedule' ? 'bg-blue-600 text-white rounded-t-xl' : 'text-gray-600 hover:bg-gray-50' }}">
                Maintenance Schedule
            </button>
            <button wire:click="$set('activeTab', 'cost')"
                class="flex-1 px-6 py-4 font-semibold transition-all duration-200 {{ $activeTab === 'cost' ? 'bg-blue-600 text-white rounded-t-xl' : 'text-gray-600 hover:bg-gray-50' }}">
                Cost Breakdown
            </button>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="bg-white  shadow-md p-6">

        {{-- Maintenance Schedule Table --}}
        @if ($activeTab === 'schedule')
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Unit/Area</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Task</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Scheduled Date</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Urgency</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scheduleHistory as $item)
                            <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                                <td class="py-4 px-4">
                                    <span class="text-blue-700 font-semibold">{{ $item['unit'] }}</span>
                                </td>
                                <td class="py-4 px-4 text-gray-700">{{ $item['task'] }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $item['scheduled_date'] }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $item['urgency'] }}</td>
                                <td class="py-4 px-4">
                                    @if($item['status'] === 'Scheduled')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Scheduled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Cost Breakdown Table --}}
        @if ($activeTab === 'cost')
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Service Category</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Provider</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Estimated Cost</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Last Serviced</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($costBreakdown as $item)
                            <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                                <td class="py-4 px-4">
                                    <span class="text-blue-700 font-semibold">{{ $item['category'] }}</span>
                                </td>
                                <td class="py-4 px-4 text-gray-700">{{ $item['provider'] }}</td>
                                <td class="py-4 px-4 text-gray-700 font-semibold">₱
                                    {{ number_format($item['estimated_cost']) }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $item['last_serviced'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
