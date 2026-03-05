<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Revenue Forecast</h2>
        
        <div class="flex items-center">
            <select wire:model.live="forecastYear" class="border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-700">
                @foreach(range(now()->year, now()->year + 2) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6 shadow-sm">
                <p class="text-sm font-medium text-green-700 mb-2">Annual Forecast</p>
                <p class="text-3xl font-bold text-green-600">₱{{ number_format($totalAnnualRevenue, 0) }}</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6 shadow-sm">
                <p class="text-sm font-medium text-blue-700 mb-2">Remaining Revenue</p>
                <p class="text-3xl font-bold text-blue-600">₱{{ number_format($totalRemainingRevenue, 0) }}</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6 shadow-sm">
                <p class="text-sm font-medium text-purple-700 mb-2">Monthly Average</p>
                <p class="text-3xl font-bold text-purple-600">₱{{ number_format($averageMonthlyRevenue, 0) }}</p>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Monthly Revenue Forecast - {{ $forecastYear }}</h3>
            <div id="revenueChart" style="height: 400px;"></div>
        </div>

        <!-- Chart.js/ApexCharts Script -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('livewire:navigated', () => { renderRevenueChart(); });
            document.addEventListener('DOMContentLoaded', () => { renderRevenueChart(); });

            function renderRevenueChart() {
                const monthlyForecasts = @json($monthlyForecasts);
                
                if (!monthlyForecasts || monthlyForecasts.length === 0) return;

                const categories = monthlyForecasts.map(f => f.month_name);
                const series = [
                    {
                        name: 'Actual Earnings',
                        data: monthlyForecasts.map(f => f.actual_revenue || 0)
                    },
                    {
                        name: 'Forecasted Revenue',
                        data: monthlyForecasts.map(f => f.forecasted_revenue)
                    }
                ];

                const options = {
                    chart: {
                        type: 'bar',
                        height: 400,
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: true,
                                zoom: true,
                                zoomin: true,
                                zoomout: true,
                                pan: true,
                                reset: true
                            }
                        },
                        animations: {
                            enabled: true,
                            speed: 800,
                            animateGradually: {
                                enabled: true,
                                delay: 150
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            borderRadius: 6,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) {
                            return '₱' + (val / 1000).toFixed(0) + 'K';
                        },
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ['#304758']
                        }
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: categories,
                        labels: {
                            style: {
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Revenue (₱)',
                            style: {
                                fontSize: '13px',
                                fontWeight: 600
                            }
                        },
                        labels: {
                            formatter: function (val) {
                                return '₱' + (val / 1000).toFixed(0) + 'K';
                            }
                        }
                    },
                    fill: {
                        opacity: 0.9
                    },
                    colors: ['#118DFF', '#06D6A0'],
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return '₱' + val.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            }
                        },
                        theme: 'light'
                    },
                    grid: {
                        borderColor: '#E7E7E7',
                        strokeDashArray: 4,
                        show: true
                    },
                    states: {
                        hover: {
                            filter: {
                                type: 'darken',
                                value: 0.15
                            }
                        },
                        active: {
                            filter: {
                                type: 'darken',
                                value: 0.15
                            }
                        }
                    }
                };

                // Destroy existing chart if it exists
                if (window.revenueChartInstance) {
                    window.revenueChartInstance.destroy();
                }

                // Create new chart
                window.revenueChartInstance = new ApexCharts(
                    document.getElementById('revenueChart'),
                    {
                        series,
                        ...options
                    }
                );
                
                window.revenueChartInstance.render();
            }
        </script>
    @else
        <div class="text-center py-16 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-700">Loading Forecast</h3>
            <p class="mt-1 text-sm text-gray-500">Generating revenue predictions...</p>
        </div>
    @endif
</div>