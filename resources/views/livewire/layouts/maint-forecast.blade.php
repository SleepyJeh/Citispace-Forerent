<div class="maintenance-forecast-component">

    {{-- This is your debug box --}}
    <div class="alert alert-warning mt-3">
        <h5><i class="fas fa-exclamation-triangle"></i> All Available Variables</h5>
        <p><strong>hasData:</strong> {{ $hasData ? 'true' : 'false' }}</p>
        <p><strong>forecast exists:</strong> {{ isset($forecast) ? 'true' : 'false' }}</p>
        <p><strong>forecast success:</strong> {{ isset($forecast['success']) ? ($forecast['success'] ? 'true' : 'false') : 'not set' }}</p>
        <p><strong>debugInfo exists:</strong> {{ isset($debugInfo) ? 'true' : 'false' }}</p>
        <p><strong>error:</strong> {{ $error ?? 'null' }}</p>
        <p><strong>isGenerating:</strong> {{ $isGenerating ? 'true' : 'false' }}</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-tools mr-2"></i>Maintenance Cost Forecast
            </h3>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">
                Generate maintenance cost forecasts using historical maintenance data.
            </p>

            {{-- THIS IS THE BUTTON THAT WAS MISSING --}}
            <form wire:submit.prevent="generateForecast">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="year">Forecast Year</label>
                            <select wire:model="year" id="year" class="form-control" required>
                                @for($y = date('Y'); $y <= date('Y') + 3; $y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class="fas fa-chart-line"></i> Generate Forecast
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin"></i> Generating...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            @if($hasData && $maintenanceStats)
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Historical Maintenance Data Summary</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Total Records</th>
                                    <th>Date Range</th>
                                    <th>Total Cost</th>
                                    <th>Average Monthly Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($maintenanceStats['total_records']) }}</td>
                                    <td>{{ $maintenanceStats['date_range'] }}</td>
                                    <td>₱{{ number_format($maintenanceStats['total_cost'], 2) }}</td>
                                    <td>₱{{ number_format($maintenanceStats['avg_monthly_cost'], 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if($error)
            <div class="alert alert-danger mt-3">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                {{ $error }}
            </div>
            @endif

            @if($debugInfo)
            <div class="alert alert-info mt-3">
                <h5><i class="fas fa-bug"></i> Debug Information</h5>
                <pre>{{ json_encode($debugInfo, JSON_PRETTY_PRINT) }}</pre>
            </div>
            @endif

            @if($forecast && isset($forecast['success']) && $forecast['success'])
            <div class="forecast-results mt-4">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            <h5><i class="fas fa-check-circle"></i> Forecast Generated Successfully!</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>Annual Cost:</strong> ₱{{ number_format($forecast['total_annual_cost'] ?? 0, 2) }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Monthly Average:</strong> ₱{{ number_format($forecast['average_monthly_cost'] ?? 0, 2) }}
                                </div>
                                <div class="col-md-3">
                                    <strong>Data Points:</strong> {{ $forecast['data_points_used'] ?? 0 }}
                                </div>
                                <div class="col-md-3">
                                    <strong>R² Score:</strong> {{ number_format($forecast['model_performance']['r2_score'] ?? 0, 3) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Monthly Cost Forecast for {{ $year }}</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Month</th>
                                                <th>Forecasted Cost</th>
                                                <th>Est. Jobs</th>
                                                <th>Urgency Score</th>
                                                <th>Seasonal Factor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(($forecast['monthly_forecasts'] ?? []) as $monthly)
                                            <tr>
                                                <td><strong>{{ $monthly['month_name'] ?? '' }}</strong></td>
                                                <td>₱{{ number_format($monthly['forecasted_cost'] ?? 0, 2) }}</td>
                                                <td>{{ $monthly['maintenance_count_estimate'] ?? 0 }}</td>
                                                <td>{{ number_format($monthly['urgency_estimate'] ?? 0, 1) }}</td>
                                                <td>{{ number_format($monthly['seasonal_factor'] ?? 0, 2) }}x</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recommended Maintenance Schedule (Top 5)</h4>
                            </div>
                            <div class="card-body p-0">
                                @if(!empty($forecast['maintenance_schedule']))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm mb-0">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Month</th>
                                                <th>Category</th>
                                                <th>Priority</th>
                                                <th>Estimated Cost</th>
                                                <th>Reason</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(($forecast['maintenance_schedule'] ?? []) as $schedule)
                                            <tr>
                                                <td><strong>{{ $schedule['month_name'] ?? '' }}</strong></td>
                                                <td>{{ $schedule['category'] ?? '' }}</td>
                                                <td>
                                                    <span class="badge badge-{{ ($schedule['priority'] ?? '') == 'High' ? 'danger' : 'warning' }}">
                                                        {{ $schedule['priority'] ?? '' }}
                                                    </span>
                                                </td>
                                                <td>₱{{ number_format($schedule['estimated_cost'] ?? 0, 2) }}</td>
                                                <td>{{ $schedule['reason'] ?? '' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <p class="text-muted p-3 mb-0">No maintenance schedule generated.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- This is the end of the success block --}}
            @elseif($forecast && isset($forecast['success']) && !$forecast['success'])
            <div class="alert alert-warning mt-3">
                <h5><i class="fas fa-exclamation-triangle"></i> Forecast Failed</h5>
                <p>{{ $forecast['error'] ?? 'Unknown error' }}</p>
            </div>
            {{-- This is the initial "no data" block --}}
            @else
            <div class="alert alert-info mt-3">
                No forecast data available. Click "Generate Forecast" to start.
            </div>
            @endif
        </div>
    </div>
</div>