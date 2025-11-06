<div class="w-full space-y-8">
    <!-- Projected Maintenance Cost Section -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Projected Maintenance Cost</h2>

        <!-- Horizontal Scroll Container -->
        <div class="relative">
            <div class="flex space-x-4 overflow-x-auto pb-4 custom-scrollbar">
                @foreach($buildings as $building)
                <div class="maintenance-card">
                    <div class="flex flex-col space-y-2">
                        <!-- Building Name - Top -->
                        <span class="building-name">{{ $building['name'] }}</span>

                        <!-- Cost Amount - Medium size -->
                        <span class="cost-amount">P {{ $building['current_cost'] }}</span>

                        <!-- Percentage Change with Checkmark -->
                        <div class="percentage-change">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ $building['change_percentage'] }}% {{ $building['change_direction'] }} from last month
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Maintenance Cost Prediction Section -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Maintenance Cost Prediction</h2>

        <div id="maintenanceCostChart" style="height: 350px;"></div>
    </div>

    <!-- Projected Net Revenue Section -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Projected Net Revenue</h2>
            <div class="flex items-center space-x-4 mt-2 md:mt-0">
                <div class="text-sm bg-blue-50 text-blue-700 px-3 py-1 rounded-lg">
                    17/9 × 552
                </div>
            </div>
        </div>

        <div id="projectedRevenueChart" style="height: 300px;"></div>

        <!-- X-axis title -->
        <div class="text-center text-sm text-gray-600 mt-4">Month</div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Maintenance Cost Prediction Line Chart
            const maintenanceCostOptions = {
                series: [{
                    name: 'Maintenance Cost',
                    data: @json($costPredictions['data'])
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#3B82F6'],
                stroke: {
                    width: 3,
                    curve: 'smooth'
                },
                markers: {
                    size: 5,
                    hover: {
                        size: 7
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($costPredictions['labels']),
                    labels: {
                        style: {
                            fontSize: '11px',
                            colors: '#6B7280'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Cost (in thousands)',
                        style: {
                            fontSize: '12px',
                            color: '#6B7280'
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return 'P' + value + '.00';
                        },
                        style: {
                            fontSize: '11px',
                            colors: '#6B7280'
                        }
                    },
                    min: 20,
                    max: 60
                },
                grid: {
                    borderColor: '#F3F4F6',
                    strokeDashArray: 4,
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'P' + value + ',000.00';
                        }
                    }
                }
            };

            const maintenanceCostChart = new ApexCharts(document.querySelector("#maintenanceCostChart"), maintenanceCostOptions);
            maintenanceCostChart.render();

            // Projected Net Revenue Line Chart
            const projectedRevenueOptions = {
                series: [{
                    name: 'Projected Net Revenue',
                    data: @json($revenueProjections['data'])
                }],
                chart: {
                    type: 'line',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#10B981'],
                stroke: {
                    width: 3,
                    curve: 'smooth'
                },
                markers: {
                    size: 5,
                    hover: {
                        size: 7
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($revenueProjections['labels']),
                    labels: {
                        style: {
                            fontSize: '10px',
                            colors: '#6B7280'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Revenue (in thousands)',
                        style: {
                            fontSize: '12px',
                            color: '#6B7280'
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return 'P' + value + '.00';
                        },
                        style: {
                            fontSize: '11px',
                            colors: '#6B7280'
                        }
                    },
                    min: 40,
                    max: 100
                },
                grid: {
                    borderColor: '#F3F4F6',
                    strokeDashArray: 4,
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return 'P' + value + ',000.00';
                        }
                    }
                }
            };

            const projectedRevenueChart = new ApexCharts(document.querySelector("#projectedRevenueChart"), projectedRevenueOptions);
            projectedRevenueChart.render();
        });
    </script>
    @endpush
</div>
