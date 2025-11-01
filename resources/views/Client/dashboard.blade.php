@extends("layouts.app")
@section('title', 'Client Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .chart-container {
            position: relative;
            height: 300px;
            padding: 20px;
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
            border-color: #2563eb;
        }

        .period-select:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-assigned {
            background: #E3F2FD;
            color: #1565C0;
        }

        .status-in-progress {
            background: #F3E5F5;
            color: #6A1B9A;
        }

        .status-completed {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .status-canceled {
            background: #FFEBEE;
            color: #C62828;
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
                    <h1 class="page-title">Client Dashboard</h1>
                </div>
                <div class="topbar-right">
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Client">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-icon">📋</div>
                    <div class="stat-details">
                        <div class="stat-value">{{ $totalRequests }}</div>
                        <div class="stat-label">Total Requests</div>
                        <span class="stat-change positive">{{ $successRate }}% Success Rate</span>
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-icon">✅</div>
                    <div class="stat-details">
                        <div class="stat-value">{{ $completedRequests }}</div>
                        <div class="stat-label">Completed</div>
                        <span class="stat-change positive">{{ $pendingRequests }} Pending</span>
                    </div>
                </div>

                <div class="stat-card purple">
                    <div class="stat-icon">🔄</div>
                    <div class="stat-details">
                        <div class="stat-value">{{ $inProgressRequests }}</div>
                        <div class="stat-label">In Progress</div>
                        <span class="stat-change neutral">Active Jobs</span>
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-icon">💰</div>
                    <div class="stat-details">
                        <div class="stat-value">${{ number_format($totalSpent, 2) }}</div>
                        <div class="stat-label">Total Spent</div>
                        <span class="stat-change {{ $spendingChange >= 0 ? 'neutral' : 'positive' }}">
                            {{ $spendingChange >= 0 ? '+' : '' }}{{ number_format(abs($spendingChange), 1) }}% this month
                        </span>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Service Requests Chart -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">📊 Service Requests</h3>
                        <select class="period-select" id="periodSelectRequests">
                            <option value="7days">Last 7 Days</option>
                            <option value="30days">Last 30 Days</option>
                            <option value="6months">Last 6 Months</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="requestsChart"></canvas>
                    </div>
                </div>

                <!-- Spending Chart -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">💳 Spending Overview</h3>
                        <select class="period-select" id="periodSelectSpending">
                            <option value="7days">Last 7 Days</option>
                            <option value="30days">Last 30 Days</option>
                            <option value="6months">Last 6 Months</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="spendingChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Service Categories -->
            <div class="chart-card" style="margin-bottom: 30px;">
                <div class="card-header">
                    <h3 class="card-title">🎯 Top Service Categories</h3>
                    <a href="{{ route('client.service_requests.create') }}" class="view-all">Request Service →</a>
                </div>
                <div class="categories-list">
                    @php
                        $categoryIcons = [
                            'Electrical Systems' => '⚡',
                            'Security Systems' => '🔒',
                            'HVAC (Heating, Ventilation, Air Conditioning)' => '❄️',
                            'Home Automation / IoT' => '🏠',
                            'Plumbing' => '🚰',
                            'Carpentry' => '🔨',
                            'Painting' => '🎨',
                            'Cleaning' => '🧹',
                            'Gardening' => '🌱',
                            'Appliance Repair' => '🔧',
                        ];
                    @endphp

                    @forelse($topCategories as $item)
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">{{ $categoryIcons[$item->category->name] ?? '⚙️' }}</div>
                                <span class="category-name">{{ $item->category->name }}</span>
                            </div>
                            <span class="category-count">{{ $item->total }} requests</span>
                        </div>
                    @empty
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">📋</div>
                                <span class="category-name">No services requested yet</span>
                            </div>
                            <span class="category-count">0 requests</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Requests Table -->
            <div class="table-card">
                <div class="card-header">
                    <h3 class="card-title">📋 Recent Service Requests</h3>
                    <a href="{{ route('client.service_request.index') }}" class="view-all">View All →</a>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Technician</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRequests as $request)
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <span style="font-size: 24px;">
                                                {{ $categoryIcons[$request->category->name] ?? '⚙️' }}
                                            </span>
                                            <span>{{ $request->category->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $request->technician->user->name ?? 'Not Assigned' }}</td>
                                    <td>
                                        <span class="status-badge status-{{ str_replace('_', '-', strtolower($request->status)) }}">
                                            @switch($request->status)
                                                @case('pending')
                                                    ⏳ Pending
                                                @break
                                                @case('assigned')
                                                    👤 Assigned
                                                @break
                                                @case('in_progress')
                                                    🔄 In Progress
                                                @break
                                                @case('completed')
                                                    ✅ Completed
                                                @break
                                                @case('canceled')
                                                    ❌ Canceled
                                                @break
                                                @default
                                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 30px;">
                                        No service requests yet. <a href="{{ route('client.service_requests.create') }}">Request a service</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart Data from Laravel
        const requestsData = {
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

        const spendingData = {
            '7days': {
                labels: @json($last7DaysSpending->pluck('date')),
                data: @json($last7DaysSpending->pluck('amount'))
            },
            '30days': {
                labels: @json($last30DaysSpending->pluck('date')),
                data: @json($last30DaysSpending->pluck('amount'))
            },
            '6months': {
                labels: @json($last6MonthsSpending->pluck('date')),
                data: @json($last6MonthsSpending->pluck('amount'))
            }
        };

        // ============ Requests Chart ============
        const ctxRequests = document.getElementById('requestsChart').getContext('2d');
        const requestsChart = new Chart(ctxRequests, {
            type: 'bar',
            data: {
                labels: requestsData['7days'].labels,
                datasets: [{
                    label: 'Service Requests',
                    data: requestsData['7days'].data,
                    backgroundColor: 'rgba(37, 99, 235, 0.7)',
                    borderColor: 'rgba(37, 99, 235, 1)',
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
                        align: 'end',
                        labels: {
                            font: {size: 13, weight: '600'},
                            padding: 15
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderColor: '#2563eb',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return ' Requests: ' + context.parsed.y;
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

        // ============ Spending Chart ============
        const ctxSpending = document.getElementById('spendingChart').getContext('2d');
        const spendingChart = new Chart(ctxSpending, {
            type: 'line',
            data: {
                labels: spendingData['7days'].labels,
                datasets: [{
                    label: 'Spending ($)',
                    data: spendingData['7days'].data,
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                        gradient.addColorStop(0, 'rgba(249, 115, 22, 0.3)');
                        gradient.addColorStop(1, 'rgba(249, 115, 22, 0.0)');
                        return gradient;
                    },
                    borderColor: '#f97316',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7
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
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderColor: '#f97316',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return ' Amount: $' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        },
                        grid: {color: '#f1f5f9'}
                    },
                    x: {
                        grid: {display: false}
                    }
                }
            }
        });

        // Period Select for Requests Chart
        document.getElementById('periodSelectRequests').addEventListener('change', function() {
            const period = this.value;
            requestsChart.data.labels = requestsData[period].labels;
            requestsChart.data.datasets[0].data = requestsData[period].data;
            requestsChart.update();
        });

        // Period Select for Spending Chart
        document.getElementById('periodSelectSpending').addEventListener('change', function() {
            const period = this.value;
            spendingChart.data.labels = spendingData[period].labels;
            spendingChart.data.datasets[0].data = spendingData[period].data;
            spendingChart.update();
        });

        // Notifications
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            }).then(() => {
                location.reload();
            });
        }
    </script>
@endsection
