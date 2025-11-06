<div class="bg-white rounded-2xl shadow-md p-4 md:p-6">

    <h3 class="text-xl font-bold text-gray-900 text-center mb-6">Unit Status</h3>

    {{-- Donut Chart --}}
    <div class="flex justify-center items-center mb-6">
        <div id="unitStatusDonutChart" style="width: 280px; height: 280px;"></div>
    </div>

    {{-- Stats Grid - Updated with integrated legends --}}
    <div class="grid grid-cols-2 gap-4 mb-6">

        {{-- Occupied --}}
        <div class="bg-[#F9FAFB] rounded-xl p-3 flex flex-col border border-gray-200">
            <div class="flex gap-3 items-center mb-2">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-10 w-10 rounded-lg bg-[#070642] text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.47 3.841a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.061l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 101.061 1.06l8.69-8.689z"/>
                            <path d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z"/>
                        </svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Occupied</p>
                    <p class="text-base font-bold text-gray-900">{{ $occupied }} Units</p>
                </div>

            </div>
            {{-- Integrated Legend --}}
            <div class="mt-2 pt-2 border-t border-gray-200">
                <div class="flex items-center justify-between chart-legend" data-series="0">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-[#070642] mr-2"></div>
                        <span class="text-xs text-gray-700">Occupied</span>
                    </div>
                    <span class="text-xs font-semibold text-[#070642]">{{ $occupiedPercent }}%</span>
                </div>
            </div>
        </div>

        {{-- Vacant --}}
        <div class="bg-[#F9FAFB] rounded-xl p-3 flex flex-col border border-gray-200">
            <div class="flex gap-3 items-center mb-2">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-10 w-10 rounded-lg bg-[#043592] text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.5 6.375a.75.75 0 01.75-.75h9a.75.75 0 01.75.75v11.25a.75.75 0 01-.75.75h-9a.75.75 0 01-.75-.75V6.375z"/>
                        </svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Vacant</p>
                    <p class="text-base font-bold text-gray-900">{{ $vacant }} Units</p>
                </div>

            </div>
            {{-- Integrated Legend --}}
            <div class="mt-2 pt-2 border-t border-gray-200">
                <div class="flex items-center justify-between chart-legend" data-series="1">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-[#043592] mr-2"></div>
                        <span class="text-xs text-gray-700">Vacant</span>
                    </div>
                    <span class="text-xs font-semibold text-[#043592]">{{ $vacantPercent }}%</span>
                </div>
            </div>
        </div>

        {{-- Maintenance --}}
        <div class="bg-[#F9FAFB] rounded-xl p-3 flex flex-col border border-gray-200">
            <div class="flex gap-3 items-center mb-2">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-10 w-10 rounded-lg bg-[#1277FE] text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Maintenance</p>
                    <p class="text-base font-bold text-gray-900">{{ $maintenance }} Units</p>
                </div>

            </div>
            {{-- Integrated Legend --}}
            <div class="mt-2 pt-2 border-t border-gray-200">
                <div class="flex items-center justify-between chart-legend" data-series="2">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-[#1277FE] mr-2"></div>
                        <span class="text-xs text-gray-700">Maintenance</span>
                    </div>
                    <span class="text-xs font-semibold text-[#1277FE]">{{ $maintenancePercent }}%</span>
                </div>
            </div>
        </div>

        {{-- Move-In Ready --}}
        <div class="bg-[#F9FAFB] rounded-xl p-3 flex flex-col border border-gray-200">
            <div class="flex gap-3 items-center mb-2">
                <div class="flex-shrink-0">
                    <span class="flex items-center justify-center h-10 w-10 rounded-lg bg-[#00ABFF] text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-500">Move-In Ready</p>
                    <p class="text-base font-bold text-gray-900">{{ $moveInReady }} Units</p>
                </div>

            </div>
            {{-- Integrated Legend --}}
            <div class="mt-2 pt-2 border-t border-gray-200">
                <div class="flex items-center justify-between chart-legend" data-series="3">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-[#00ABFF] mr-2"></div>
                        <span class="text-xs text-gray-700">Move-In Ready</span>
                    </div>
                    <span class="text-xs font-semibold text-[#00ABFF]">{{ $moveInReadyPercent }}%</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom Metrics --}}
    <div class="grid grid-cols-2 pt-6 border-t border-gray-200">
        <div class="text-center">
            <p class="text-sm text-gray-500">Occupancy Rate</p>
            <p class="text-2xl font-bold text-[#070642]">{{ $occupancyRate }}%</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-500">Available Units</p>
            <p class="text-2xl font-bold text-[#070642]">{{ $availableUnits }}</p>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Unit Status Donut Chart
        const unitStatusOptions = {
            series: @js(array_column($unitStatusData, 'value')),
            chart: {
                type: 'donut',
                height: 280
            },
            labels: @js(array_column($unitStatusData, 'label')),
            colors: ['#070642', '#043592', '#1277FE', '#00ABFF'],
            legend: {
                show: false // Hide the default legend since we have integrated ones
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Units',
                                formatter: function (w) {
                                    return {{ $totalUnits }}
                                },
                                color: '#1E293B',
                                fontSize: '16px',
                                fontFamily: 'inherit',
                                fontWeight: 'bold'
                            },
                            value: {
                                fontSize: '20px',
                                fontFamily: 'inherit',
                                fontWeight: 'bold',
                                color: '#070642'
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return Math.round(val) + '%'
                },
                style: {
                    fontSize: '11px',
                    fontFamily: 'inherit',
                    fontWeight: 'bold',
                    colors: ['#FFFFFF']
                },
                dropShadow: {
                    enabled: false
                }
            },
            tooltip: {
                y: {
                    formatter: function(value, { seriesIndex }) {
                        const data = @js($unitStatusData);
                        return data[seriesIndex]?.count + ' units (' + Math.round(value) + '%)';
                    }
                }
            },
            stroke: {
                width: 1,
                colors: ['#FFFFFF']
            }
        };

        const unitStatusChart = new ApexCharts(document.querySelector("#unitStatusDonutChart"), unitStatusOptions);
        unitStatusChart.render();

        // Add click functionality to integrated legends
        document.querySelectorAll('.chart-legend').forEach(legend => {
            legend.addEventListener('click', function() {
                const seriesIndex = parseInt(this.getAttribute('data-series'));
                const isActive = !this.classList.contains('inactive');

                if (isActive) {
                    // Hide the series
                    unitStatusChart.hideSeries(unitStatusOptions.labels[seriesIndex]);
                    this.classList.add('inactive');
                } else {
                    // Show the series
                    unitStatusChart.showSeries(unitStatusOptions.labels[seriesIndex]);
                    this.classList.remove('inactive');
                }
            });
        });
    });
</script>
@endpush
