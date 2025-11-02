<div>
    {{-- Key Metrics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
            <h3 class="text-sm font-medium opacity-90 mb-2">Total Income</h3>
            <p class="text-3xl font-bold">₱ {{ number_format($totalIncome) }}</p>
            <p class="text-xs opacity-75 mt-1">+5% from last month</p>
        </div>

        <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
            <h3 class="text-sm font-medium opacity-90 mb-2">Total Expenses</h3>
            <p class="text-3xl font-bold">₱ {{ number_format($totalExpenses) }}</p>
            <p class="text-xs opacity-75 mt-1">+2% from last month</p>
        </div>

        <div class="bg-blue-600 rounded-xl p-6 text-white shadow-lg">
            <h3 class="text-sm font-medium opacity-90 mb-2">Net Operating Income</h3>
            <p class="text-3xl font-bold">₱ {{ number_format($netOperatingIncome) }}</p>
            <p class="text-xs opacity-75 mt-1">+3% from last month</p>
        </div>
    </div>

    {{-- Total Income Chart --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Total Income</h3>
            <select wire:model.live="selectedMonth" class="text-xs bg-[#070642] text-white rounded-lg px-3 py-1.5 border-0 focus:ring-2 focus:ring-blue-500">
                <option value="month">Month</option>
                <option value="quarter">Quarter</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div id="totalIncomeChart" style="height: 350px;"></div>
    </div>

    {{-- Financial Inflows and Outflows --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">Financial Inflows And Outflows</h3>
            <select class="text-xs bg-[#070642] text-white rounded-lg px-3 py-1.5 border-0 focus:ring-2 focus:ring-blue-500">
                <option value="month">Month</option>
                <option value="quarter">Quarter</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div id="inflowOutflowChart" style="height: 350px;"></div>
    </div>

    {{-- Maintenance Cost Breakdown & Projected Revenue --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {{-- Maintenance Cost Breakdown --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Maintenance Cost Breakdown</h3>
            <div class="flex flex-col md:flex-row items-center justify-center gap-8">
                <div id="maintenanceDonutChart" style="width: 280px; height: 280px;"></div>
                <div class="space-y-4">
                    @foreach($maintenanceCostData as $item)
                    <div class="flex flex-col">
                        <span class="text-sm text-gray-600 mb-1">{{ $item['label'] }} Maintenance Cost</span>
                        <span class="text-xl font-bold text-gray-800">₱ {{ number_format($item['amount']) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-center gap-6 mt-6">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-[#070642]"></div>
                    <span class="text-sm text-gray-600">Unit Structure</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                    <span class="text-sm text-gray-600">Plumbing</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded-full bg-blue-300"></div>
                    <span class="text-sm text-gray-600">Electrical</span>
                </div>
            </div>
        </div>

        {{-- Projected Revenue --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Projected Revenue</h3>
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-lg font-semibold text-gray-700">Next Month's Projected Revenue</h4>
                    <select class="text-xs bg-[#070642] text-white rounded-lg px-3 py-1.5 border-0">
                        <option value="month">Month</option>
                    </select>
                </div>
                <div id="projectedRevenueChart" style="height: 200px;"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-[#070642] rounded-xl p-4 text-white">
                    <p class="text-sm opacity-90 mb-1">Total Expenses</p>
                    <p class="text-2xl font-bold">₱ 120,000</p>
                </div>
                <div class="bg-[#070642] rounded-xl p-4 text-white">
                    <p class="text-sm opacity-90 mb-1">Net Revenue</p>
                    <p class="text-2xl font-bold">₱ 120,000</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Total Income Chart
            const incomeOptions = {
                series: [{
                    name: 'Income',
                    data: @js($incomeData['data'])
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '60%',
                    }
                },
                colors: ['#070642'],
                dataLabels: { enabled: false },
                xaxis: {
                    categories: @js($incomeData['labels']),
                    labels: { style: { fontSize: '11px' } }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toLocaleString();
                        }
                    }
                },
                grid: { borderColor: '#f1f1f1' }
            };
            new ApexCharts(document.querySelector("#totalIncomeChart"), incomeOptions).render();

            // Inflow/Outflow Chart
            const inflowOptions = {
                series: [{
                    name: 'Total Income',
                    data: @js($inflowOutflowData['income'])
                }, {
                    name: 'Total Expenses',
                    data: @js($inflowOutflowData['expenses'])
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        columnWidth: '70%',
                    }
                },
                colors: ['#070642', '#60a5fa'],
                dataLabels: { enabled: false },
                xaxis: {
                    categories: @js($inflowOutflowData['labels']),
                    labels: { style: { fontSize: '11px' } }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
                grid: { borderColor: '#f1f1f1' }
            };
            new ApexCharts(document.querySelector("#inflowOutflowChart"), inflowOptions).render();

            // Maintenance Donut Chart
            const maintenanceOptions = {
                series: @js(array_column($maintenanceCostData, 'value')),
                chart: {
                    type: 'donut',
                    height: 280
                },
                labels: @js(array_column($maintenanceCostData, 'label')),
                colors: ['#070642', '#3b82f6', '#93c5fd'],
                legend: { show: false },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function () {
                                        return '100%'
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return Math.round(val) + '%'
                    }
                }
            };
            new ApexCharts(document.querySelector("#maintenanceDonutChart"), maintenanceOptions).render();

            // Projected Revenue Chart
            const projectedOptions = {
                series: [{
                    name: 'Projected Revenue',
                    data: @js($projectedRevenueData['projected'])
                }, {
                    name: 'Projected Net Revenue',
                    data: @js($projectedRevenueData['projectedNet'])
                }],
                chart: {
                    type: 'line',
                    height: 200,
                    toolbar: { show: false }
                },
                colors: ['#93c5fd', '#070642'],
                stroke: {
                    width: 3,
                    curve: 'smooth'
                },
                xaxis: {
                    categories: @js($projectedRevenueData['labels']),
                    labels: { style: { fontSize: '10px' } }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val;
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right'
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 4
                }
            };
            new ApexCharts(document.querySelector("#projectedRevenueChart"), projectedOptions).render();
        });
    </script>
    @endpush
</div>
