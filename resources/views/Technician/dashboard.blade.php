@extends('layouts.app')
@section('title', 'Technician Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .status-badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
            color: white;
        }

        .status-badge.assigned {
            background-color: #2563eb;
        }

        .status-badge.in_progress {
            background-color: #f59e0b;
        }

        .status-badge.waiting_for_approval {
            background-color: #8b5cf6;
        }

        .status-badge.approved_for_repair {
            background-color: #10b981;
        }

        .status-badge.issue_reported {
            background-color: #ef4444;
        }

        .status-badge.rescheduled {
            background-color: #06b6d4;
        }

        .status-badge.completed {
            background-color: #16a34a;
        }

        .status-badge.pending {
            background-color: #9ca3af;
        }

        .status-badge.canceled {
            background-color: #dc2626;
        }

        .chart-container {
            position: relative;
            height: 320px;
            padding: 25px 20px;
        }

        .period-select {
            padding: 8px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            color: #475569;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .period-select:hover {
            border-color: #033fc0;
            background: #f8fafc;
        }

        .period-select:focus {
            outline: none;
            border-color: #033fc0;
            box-shadow: 0 0 0 3px rgba(3, 63, 192, 0.1);
        }

        .chart-stats {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            border-radius: 0 0 12px 12px;
            gap: 15px;
        }

        .stat-item-mini {
            text-align: center;
            flex: 1;
        }

        .stat-label-mini {
            display: block;
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .stat-value-mini {
            display: block;
            font-size: 20px;
            color: #033fc0;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
                padding: 15px 10px;
            }

            .chart-stats {
                flex-direction: column;
                gap: 10px;
            }

            .stat-item-mini {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-wrapper">
        @include('layouts.sidebar_admin')

        <main class="main-content">
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title">Technician Dashboard</h1>
                </div>
                <div class="topbar-right">
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff"
                            alt="Technician">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-icon">📋</div>
                    <div class="stat-details">
                        <div class="stat-value">{{ $jobs }}</div>
                        <div class="stat-label">Total Jobs</div>
                        <span class="stat-change positive">+{{ $recentJobs }} This Week</span>
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-icon">✅</div>
                    <div class="stat-details">
                        <div class="stat-value">{{ $completed }}</div>
                        <div class="stat-label">Completed Jobs</div>
                        <span class="stat-change positive">{{ $successRate }}% Success Rate</span>
                    </div>
                </div>

                <div class="stat-card purple">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-details">
                        <div class="stat-value">{{ $progress }}</div>
                        <div class="stat-label">In Progress</div>
                        <span class="stat-change neutral">{{ $dueToday }} Due Today</span>
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-details">
                        <div class="stat-value">{{ $technician->rating }}</div>
                        <div class="stat-label">Rating</div>
                        <span class="stat-change positive">+{{ $averageRating }} This Month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Line Chart - Weekly Performance -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">📈 Performance Trend</h3>
                        <select class="period-select" id="periodSelectLine">
                            <option value="7days">Last 7 days</option>
                            <option value="30days">Last 30 days</option>
                            <option value="6months">Last 6 months</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="weeklyPerformanceChart"></canvas>
                    </div>
                    <div class="chart-stats">
                        <div class="stat-item-mini">
                            <span class="stat-label-mini">Total Jobs</span>
                            <span class="stat-value-mini" id="totalJobsLine">{{ $chartData->sum() }}</span>
                        </div>
                        <div class="stat-item-mini">
                            <span class="stat-label-mini">Average</span>
                            <span class="stat-value-mini" id="averageJobsLine">{{ $chartData->count() > 0 ? round($chartData->avg(), 1) : 0 }}</span>
                        </div>
                        <div class="stat-item-mini">
                            <span class="stat-label-mini">Peak Day</span>
                            <span class="stat-value-mini" id="peakDayLine">{{ $chartData->max() ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Bar Chart - Daily Breakdown -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">📊 Daily Breakdown</h3>
                        <select class="period-select" id="periodSelectBar">
                            <option value="7days">Last 7 days</option>
                            <option value="30days">Last 30 days</option>
                            <option value="6months">Last 6 months</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="dailyBreakdownChart"></canvas>
                    </div>
                    <div class="chart-stats">
                        <div class="stat-item-mini">
                            <span class="stat-label-mini">Total Jobs</span>
                            <span class="stat-value-mini" id="totalJobsBar">{{ $chartData->sum() }}</span>
                        </div>
                        <div class="stat-item-mini">
                            <span class="stat-label-mini">Average</span>
                            <span class="stat-value-mini" id="averageJobsBar">{{ $chartData->count() > 0 ? round($chartData->avg(), 1) : 0 }}</span>
                        </div>
                        <div class="stat-item-mini">
                            <span class="stat-label-mini">Best Day</span>
                            <span class="stat-value-mini" id="bestDayBar">{{ $chartData->max() ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tables Grid -->
            <div class="tables-grid">
                <!-- Assigned Jobs -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Assigned Jobs</h3>
                        <a href="{{ route('technician_request.myRequests') }}" class="view-all">View All →</a>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Job Type</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignedJobs as $job)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($job->client->user->name) }}&background=2563eb&color=fff"
                                                    alt="Client">
                                                <span>{{ $job->client->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $job->description }}</td>
                                        <td>
                                            <span class="status-badge {{ str_replace(' ', '_', strtolower($job->status)) }}">
                                                @switch($job->status)
                                                    @case('pending')
                                                        ⏳ Pending
                                                        @break
                                                    @case('assigned')
                                                        👤 Assigned
                                                        @break
                                                    @case('in_progress')
                                                        🔄 In Progress
                                                        @break
                                                    @case('waiting_for_approval')
                                                        ⏰ Waiting Approval
                                                        @break
                                                    @case('approved_for_repair')
                                                        ✅ Approved
                                                        @break
                                                    @case('issue_reported')
                                                        ⚠️ Issue Reported
                                                        @break
                                                    @case('rescheduled')
                                                        📅 Rescheduled
                                                        @break
                                                    @case('completed')
                                                        ✅ Completed
                                                        @break
                                                    @case('canceled')
                                                        ❌ Canceled
                                                        @break
                                                    @default
                                                        {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>{{ $job->created_at->format('M d, h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Reviews</h3>
                        <a href="{{ route('technician_rating.index') }}" class="view-all">View All →</a>
                    </div>
                    <div class="technicians-list">
                        @forelse ($recentRating as $review)
                            <div class="tech-item">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($review->client->user->name ?? 'Unknown') }}&background=2563eb&color=fff"
                                    alt="{{ $review->client->name ?? 'Unknown' }}">
                                <div class="tech-info">
                                    <h4>{{ $review->client->user->name ?? 'Anonymous' }}</h4>
                                    <p>{{ Str::limit($review->comment ?? 'Service', 50) }}</p>
                                </div>
                                <div class="tech-rating">
                                    <span class="rating">⭐ {{ number_format($review->rating, 1) }}</span>
                                    <span class="jobs">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500">No recent reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Geolocation
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            }

            function successCallback(position) {
                fetch("{{ route('technician.updateLocation') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    })
                }).then(response => response.json())
                .then(data => console.log("Location updated:", data))
                .catch(error => console.error("Error updating location:", error));
            }

            function errorCallback(error) {
                console.log("Location error:", error.message);
            }
        });

        // Chart Data from Laravel
        const chartDataStore = {
            '7days': {
                labels: @json($last7Days->pluck('date')),
                data: @json($last7Days->pluck('count'))
            },
            '30days': {
                labels: @json($last30Days->pluck('date')),
                data: @json($last30Days->pluck('count'))
            },
            '6months': {
                labels: @json($last6Months->pluck('date')),
                data: @json($last6Months->pluck('count'))
            }
        };

        // ============ Line Chart ============
        const ctxLine = document.getElementById('weeklyPerformanceChart').getContext('2d');
        const weeklyChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: chartDataStore['7days'].labels,
                datasets: [{
                    label: 'Completed Jobs',
                    data: chartDataStore['7days'].data,
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        gradient.addColorStop(0, 'rgba(3, 63, 192, 0.3)');
                        gradient.addColorStop(1, 'rgba(3, 63, 192, 0.0)');
                        return gradient;
                    },
                    borderColor: '#033fc0',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#033fc0',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            font: {size: 13, weight: '600'},
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.95)',
                        padding: 12,
                        borderColor: '#033fc0',
                        borderWidth: 2,
                        callbacks: {
                            label: function(context) {
                                return 'Completed: ' + context.parsed.y + ' jobs';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {stepSize: 1},
                        grid: {color: '#f1f5f9'}
                    },
                    x: {
                        grid: {display: false}
                    }
                }
            }
        });

        // ============ Bar Chart ============
        const ctxBar = document.getElementById('dailyBreakdownChart').getContext('2d');
        const barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: chartDataStore['7days'].labels,
                datasets: [{
                    label: 'Jobs Completed',
                    data: chartDataStore['7days'].data,
                    backgroundColor: function(context) {
                        const value = context.parsed.y;
                        if (value === 0) return 'rgba(156, 163, 175, 0.5)';
                        if (value >= 3) return 'rgba(34, 197, 94, 0.8)';
                        if (value >= 2) return 'rgba(59, 130, 246, 0.8)';
                        return 'rgba(251, 146, 60, 0.8)';
                    },
                    borderColor: function(context) {
                        const value = context.parsed.y;
                        if (value === 0) return 'rgba(156, 163, 175, 1)';
                        if (value >= 3) return 'rgba(34, 197, 94, 1)';
                        if (value >= 2) return 'rgba(59, 130, 246, 1)';
                        return 'rgba(251, 146, 60, 1)';
                    },
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end'
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 41, 59, 0.95)',
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return 'Jobs: ' + context.parsed.y;
                            },
                            afterLabel: function(context) {
                                const value = context.parsed.y;
                                if (value >= 3) return '🔥 High Performance';
                                if (value >= 2) return '💪 Good Work';
                                if (value === 1) return '👍 Keep Going';
                                return '😴 No Activity';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {stepSize: 1},
                        grid: {color: '#f1f5f9'}
                    },
                    x: {
                        grid: {display: false}
                    }
                }
            }
        });

        // Update Stats Function
        function updateStats(data, prefix) {
            const total = data.reduce((a, b) => a + b, 0);
            const average = data.length > 0 ? (total / data.length).toFixed(1) : 0;
            const peak = Math.max(...data, 0);

            document.getElementById(`totalJobs${prefix}`).textContent = total;
            document.getElementById(`averageJobs${prefix}`).textContent = average;
            document.getElementById(`${prefix === 'Line' ? 'peakDayLine' : 'bestDayBar'}`).textContent = peak;
        }

        // Period Select for Line Chart
        document.getElementById('periodSelectLine').addEventListener('change', function() {
            const period = this.value;
            weeklyChart.data.labels = chartDataStore[period].labels;
            weeklyChart.data.datasets[0].data = chartDataStore[period].data;
            weeklyChart.update();
            updateStats(chartDataStore[period].data, 'Line');
        });

        // Period Select for Bar Chart
        document.getElementById('periodSelectBar').addEventListener('change', function() {
            const period = this.value;
            barChart.data.labels = chartDataStore[period].labels;
            barChart.data.datasets[0].data = chartDataStore[period].data;
            barChart.update();
            updateStats(chartDataStore[period].data, 'Bar');
        });
    </script>
@endsection
