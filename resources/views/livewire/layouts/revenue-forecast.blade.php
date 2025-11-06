<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Revenue Forecast</h2>
        
        <div class="flex items-center space-x-4">
            <select wire:model="forecastYear" class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(range(now()->year, now()->year + 2) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            
            <button 
                wire:click="generateForecast" 
                wire:loading.attr="disabled"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 disabled:opacity-50 transition duration-200"
            >
                <span wire:loading.remove>Generate Forecast</span>
                <span wire:loading>
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Generating...
                </span>
            </button>
        </div>
    </div>

    @if($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Error:</strong> {{ $error }}
        </div>
    @endif

    @if($dataPointsUsed > 0)
        <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-4">
            <p class="text-sm text-blue-800">
                Forecast generated using {{ $dataPointsUsed }} months of historical data
            </p>
        </div>
    @endif

    @if(!empty($monthlyForecasts))
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm">
                <h3 class="text-lg font-semibold text-green-800 mb-2">Annual Forecast</h3>
                <p class="text-2xl font-bold text-green-600">₱{{ number_format($totalAnnualRevenue, 2) }}</p>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow-sm">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">Remaining Revenue</h3>
                <p class="text-2xl font-bold text-blue-600">₱{{ number_format($totalRemainingRevenue, 2) }}</p>
            </div>
            
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 shadow-sm">
                <h3 class="text-lg font-semibold text-purple-800 mb-2">Monthly Average</h3>
                <p class="text-2xl font-bold text-purple-600">₱{{ number_format($averageMonthlyRevenue, 2) }}</p>
            </div>
        </div>

        <!-- Monthly Forecast Table -->
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Month
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Forecasted Revenue
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($monthlyForecasts as $forecast)
                        @php
                            $isCurrentMonth = $forecast['month'] == now()->month && $forecast['year'] == now()->year;
                            $isPastMonth = $forecast['month'] < now()->month && $forecast['year'] == now()->year;
                        @endphp
                        <tr class="{{ $isCurrentMonth ? 'bg-yellow-50' : '' }} hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $forecast['month_name'] }} {{ $forecast['year'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                ₱{{ number_format($forecast['forecasted_revenue'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($isCurrentMonth)
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-medium">Current Month</span>
                                @elseif($isPastMonth)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">Past Month</span>
                                @else
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">Future</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No forecast generated</h3>
            <p class="mt-1 text-sm text-gray-500">Click "Generate Forecast" to see revenue predictions.</p>
        </div>
    @endif
</div>