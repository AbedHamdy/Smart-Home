@extends("layouts.app")
@section('title', 'Client Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endsection

@section('content')
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar_admin')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title">Smart Home Dashboard</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search devices...">
                        <span class="search-icon">🔍</span>
                    </div>
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
                    <div class="stat-icon">🏠</div>
                    <div class="stat-details">
                        <div class="stat-value">24</div>
                        <div class="stat-label">Total Devices</div>
                        <span class="stat-change positive">+3 New Devices</span>
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-details">
                        <div class="stat-value">18</div>
                        <div class="stat-label">Active Now</div>
                        <span class="stat-change positive">75% Online</span>
                    </div>
                </div>

                <div class="stat-card purple">
                    <div class="stat-icon">🚪</div>
                    <div class="stat-details">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Rooms Connected</div>
                        <span class="stat-change positive">All Active</span>
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-icon">💡</div>
                    <div class="stat-details">
                        <div class="stat-value">320 kWh</div>
                        <div class="stat-label">Energy Usage</div>
                        <span class="stat-change neutral">-12% This Month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Energy Consumption Chart -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">Energy Consumption</h3>
                        <select class="period-select">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option>Last 3 Months</option>
                        </select>
                    </div>
                    <div class="chart-placeholder">
                        <div class="placeholder-content">
                            <span class="placeholder-icon">📊</span>
                            <p>Energy consumption chart will appear here</p>
                        </div>
                    </div>
                </div>

                <!-- Device Categories -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">Device Categories</h3>
                        <a href="{{ route("client.service_requests.create") }}" class="view-all">View All →</a>
                    </div>
                    <div class="categories-list">
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">💡</div>
                                <span class="category-name">Smart Lighting</span>
                            </div>
                            <span class="category-count">8 devices</span>
                        </div>

                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">🌡️</div>
                                <span class="category-name">Climate Control</span>
                            </div>
                            <span class="category-count">4 devices</span>
                        </div>

                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">📹</div>
                                <span class="category-name">Security</span>
                            </div>
                            <span class="category-count">6 devices</span>
                        </div>

                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">🔊</div>
                                <span class="category-name">Entertainment</span>
                            </div>
                            <span class="category-count">6 devices</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tables Grid -->
            <div class="tables-grid">
                <!-- Recent Activities -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activities</h3>
                        <a href="#" class="view-all">View All →</a>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Device</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <span style="font-size: 24px;">💡</span>
                                            <span>Living Room Light</span>
                                        </div>
                                    </td>
                                    <td>Turned On</td>
                                    <td><span class="status-badge completed">Active</span></td>
                                    <td>10 mins ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <span style="font-size: 24px;">🔒</span>
                                            <span>Front Door Lock</span>
                                        </div>
                                    </td>
                                    <td>Locked</td>
                                    <td><span class="status-badge completed">Secured</span></td>
                                    <td>2 hours ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <span style="font-size: 24px;">🌡️</span>
                                            <span>Bedroom Thermostat</span>
                                        </div>
                                    </td>
                                    <td>Adjusted to 22°C</td>
                                    <td><span class="status-badge in-progress">Running</span></td>
                                    <td>5 hours ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <span style="font-size: 24px;">📹</span>
                                            <span>Security Camera</span>
                                        </div>
                                    </td>
                                    <td>Motion Detected</td>
                                    <td><span class="status-badge pending">Alert</span></td>
                                    <td>Yesterday</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <span style="font-size: 24px;">🔊</span>
                                            <span>Kitchen Speaker</span>
                                        </div>
                                    </td>
                                    <td>Playing Music</td>
                                    <td><span class="status-badge completed">Active</span></td>
                                    <td>Yesterday</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Smart Rooms -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Smart Rooms</h3>
                        <a href="#" class="view-all">Manage Rooms →</a>
                    </div>
                    <div class="technicians-list">
                        <div class="tech-item">
                            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=100&h=100&fit=crop" alt="Living Room">
                            <div class="tech-info">
                                <h4>🛋️ Living Room</h4>
                                <p>6 devices connected</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">5 Active</span>
                                <span class="jobs">1 Offline</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://images.unsplash.com/photo-1540518614846-7eded433c457?w=100&h=100&fit=crop" alt="Bedroom">
                            <div class="tech-info">
                                <h4>🛏️ Bedroom</h4>
                                <p>5 devices connected</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">4 Active</span>
                                <span class="jobs">1 Offline</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://images.unsplash.com/photo-1556911220-bff31c812dba?w=100&h=100&fit=crop" alt="Kitchen">
                            <div class="tech-info">
                                <h4>🍳 Kitchen</h4>
                                <p>4 devices connected</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">4 Active</span>
                                <span class="jobs">All Online</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=100&h=100&fit=crop" alt="Bathroom">
                            <div class="tech-info">
                                <h4>🚿 Bathroom</h4>
                                <p>3 devices connected</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">2 Active</span>
                                <span class="jobs">1 Offline</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=100&h=100&fit=crop" alt="Garden">
                            <div class="tech-info">
                                <h4>🌳 Garden</h4>
                                <p>6 devices connected</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">3 Active</span>
                                <span class="jobs">3 Scheduled</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        // Toggle Sidebar
        // const menuToggle = document.getElementById('menuToggle');
        // const sidebar = document.querySelector('.sidebar');

        // menuToggle.addEventListener('click', () => {
        //     sidebar.classList.toggle('collapsed');
        // });

        // Add active state to nav items
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
@endsection
