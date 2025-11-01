@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        /* Status Badges Styling */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
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

        .status-issue-reported {
            background: #FFF3E0;
            color: #E65100;
        }

        .status-rescheduled {
            background: #E1F5FE;
            color: #01579B;
        }

        .status-canceled {
            background: #FFEBEE;
            color: #C62828;
        }

        /* Chart Styling */
        .chart-placeholder {
            min-height: 300px;
            padding: 20px;
        }

        #revenueChart {
            max-height: 300px;
        }

        .period-select {
            padding: 8px 16px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            background: white;
            font-weight: 600;
            color: #667eea;
            cursor: pointer;
            transition: all 0.3s;
        }

        .period-select:hover {
            border-color: #667eea;
        }

        .period-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
                    <h1 class="page-title">Dashboard Overview</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff"
                            alt="Admin">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-icon">👥</div>
                    <div class="stat-details">
                        <h3 class="stat-value">{{ $totalClient }}</h3>
                        <p class="stat-label">Total Clients</p>
                        <span class="stat-change positive">+{{ number_format($growthPercentage, 1) }}% this month</span>
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-icon">🔧</div>
                    <div class="stat-details">
                        <h3 class="stat-value">{{ $activeTechnicians }}</h3>
                        <p class="stat-label">Active Technicians</p>
                        <span class="stat-change positive">+{{ $activeTechniciansNow }} new</span>
                    </div>
                </div>

                <div class="stat-card purple">
                    <div class="stat-icon">📋</div>
                    <div class="stat-details">
                        <h3 class="stat-value">{{ $RequestsCount }}</h3>
                        <p class="stat-label">Service Requests</p>
                        <span class="stat-change neutral">{{ $RequestsPendingCount }} pending</span>
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-icon">💰</div>
                    <div class="stat-details">
                        <h3 class="stat-value">${{ number_format($total, 2) }}</h3>
                        <p class="stat-label">Total Revenue</p>
                        <span class="stat-change {{ $revenueGrowthPercentage >= 0 ? 'positive' : 'negative' }}">
                            {{ $revenueGrowthPercentage >= 0 ? '+' : '' }}{{ number_format(abs($revenueGrowthPercentage), 1) }}%
                            this month
                        </span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">📈 Revenue Overview</h3>
                        <select class="period-select" id="periodSelect">
                            <option value="7days">Last 7 days</option>
                            <option value="30days">Last 30 days</option>
                            <option value="6months">Last 6 months</option>
                        </select>
                    </div>
                    <div class="chart-placeholder">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">🎯 Service Categories</h3>
                    </div>
                    <div class="categories-list">
                        @foreach ($categories as $category)
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
                                $icon = $categoryIcons[$category->name] ?? '⚙️';
                            @endphp

                            <div class="category-item">
                                <div class="category-info">
                                    <span class="category-icon">{{ $icon }}</span>
                                    <span class="category-name">{{ $category->name }}</span>
                                </div>
                                <span class="category-count">{{ $category->serviceRequests->count() }} requests</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="tables-grid">
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">📋 Recent Service Requests</h3>
                        <a href="{{ route('admin_service_request.index') }}" class="view-all">View All →</a>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Service</th>
                                    <th>Technician</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentRequests as $request)
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($request->client->user->name ?? 'Unknown') }}"
                                                    alt="">
                                                <span>{{ $request->client->user->name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $request->category->name ?? 'N/A' }}</td>
                                        <td>{{ $request->technician->user->name ?? 'Unassigned' }}</td>
                                        <td>
                                            <span
                                                class="status-badge {{ strtolower(str_replace('_', '-', $request->status)) }}">
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

                                                    @case('issue_reported')
                                                        ⚠️ Issue Reported
                                                    @break

                                                    @case('rescheduled')
                                                        📅 Rescheduled
                                                    @break

                                                    @case('canceled')
                                                        ❌ Canceled
                                                    @break

                                                    @default
                                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                                @endswitch
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">⭐ Top Rated Technicians</h3>
                    </div>
                    <div class="technicians-list">
                        @foreach ($techniciansTopRating as $tech)
                            <div class="tech-item">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Str::of($tech->user->name)->substr(0, 2)) }}&background=2563eb"
                                    alt="image">
                                <div class="tech-info">
                                    <h4>{{ $tech->user->name }}</h4>
                                    <p>{{ $tech->category->name ?? 'No specialization' }}</p>
                                </div>
                                <div class="tech-rating">
                                    <span class="rating">⭐ {{ number_format($tech->rating, 1) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Data from Laravel
        const chartData = {
            '7days': {
                labels: @json($last7Days->pluck('date')),
                data: @json($last7Days->pluck('revenue'))
            },
            '30days': {
                labels: @json($last30Days->pluck('date')),
                data: @json($last30Days->pluck('revenue'))
            },
            '6months': {
                labels: @json($last6Months->pluck('date')),
                data: @json($last6Months->pluck('revenue'))
            }
        };

        // Chart Configuration
        const ctx = document.getElementById('revenueChart').getContext('2d');
        let revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData['7days'].labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: chartData['7days'].data,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 13,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        borderColor: '#667eea',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return ' Revenue: $' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            },
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // Period Select Change Handler
        document.getElementById('periodSelect').addEventListener('change', function() {
            const period = this.value;
            revenueChart.data.labels = chartData[period].labels;
            revenueChart.data.datasets[0].data = chartData[period].data;
            revenueChart.update();
        });
    </script>
@endsection
