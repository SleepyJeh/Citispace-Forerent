<div class="w-full">
    {{-- Projected Maintenance Cost Section --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6">{{ $title }}</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($buildingData as $building)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-600 mb-1">{{ $building['name'] }}</span>
                    <span class="text-2xl font-bold text-gray-800 mb-2">₱ {{ number_format($building['cost']) }}</span>
                    <span class="text-xs font-medium {{ $building['change_type'] === 'higher' ? 'text-red-600' : 'text-green-600' }}">
                        {{ $building['change_type'] === 'higher' ? '↑' : '↓' }}
                        {{ $building['change'] }}% {{ $building['change_type'] }} from last month
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Maintenance Cost Prediction Section --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Maintenance Cost Prediction</h3>
            <div class="text-xs text-gray-500">
                <span class="font-semibold">{{ count($predictionData['data']) }}/9</span> × 552
            </div>
        </div>

        <div id="maintenancePredictionChart" style="height: 300px;"></div>
    </div>

    {{-- Projected Net Revenue Section --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Projected Net Revenue</h3>

        <div id="projectedNetRevenueChart" style
