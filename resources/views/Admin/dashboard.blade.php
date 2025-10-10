@extends("layouts.app")
@section('title', 'Admin Dashboard')

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
                    <h1 class="page-title">Dashboard Overview</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div>
                    <button class="notification-btn">
                        <span class="notif-icon">🔔</span>
                        <span class="badge">5</span>
                    </button>
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=2563eb&color=fff" alt="Admin">
                        <span class="user-name">Admin</span>
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
                        <span class="stat-change positive">+{{ $growthPercentage }}% this month</span>
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
                        <h3 class="stat-value">342</h3>
                        <p class="stat-label">Service Requests</p>
                        <span class="stat-change neutral">23 pending</span>
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-icon">💰</div>
                    <div class="stat-details">
                        <h3 class="stat-value">$45,890</h3>
                        <p class="stat-label">Total Revenue</p>
                        <span class="stat-change positive">+18% this month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">📈 Revenue Overview</h3>
                        <select class="period-select">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 6 months</option>
                        </select>
                    </div>
                    <div class="chart-placeholder">
                        <div class="placeholder-content">
                            <span class="placeholder-icon">📊</span>
                            <p>Chart will be displayed here</p>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">🎯 Service Categories</h3>
                    </div>
                    <div class="categories-list">
                        <div class="category-item">
                            <div class="category-info">
                                <span class="category-icon">⚡</span>
                                <span class="category-name">Electrical</span>
                            </div>
                            <span class="category-count">145 requests</span>
                        </div>
                        <div class="category-item">
                            <div class="category-info">
                                <span class="category-icon">🚿</span>
                                <span class="category-name">Plumbing</span>
                            </div>
                            <span class="category-count">98 requests</span>
                        </div>
                        <div class="category-item">
                            <div class="category-info">
                                <span class="category-icon">❄️</span>
                                <span class="category-name">AC Repair</span>
                            </div>
                            <span class="category-count">67 requests</span>
                        </div>
                        <div class="category-item">
                            <div class="category-info">
                                <span class="category-icon">🔨</span>
                                <span class="category-name">Carpentry</span>
                            </div>
                            <span class="category-count">32 requests</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tables Section -->
            <div class="tables-grid">
                <!-- Recent Requests -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">📋 Recent Service Requests</h3>
                        <a href="#" class="view-all">View All →</a>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Service</th>
                                    <th>Technician</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#1234</td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Ahmed+Ali" alt="">
                                            <span>Ahmed Ali</span>
                                        </div>
                                    </td>
                                    <td>Electrical Repair</td>
                                    <td>Mohamed Hassan</td>
                                    <td><span class="status-badge in-progress">In Progress</span></td>
                                    <td>
                                        <button class="action-btn view">👁️</button>
                                        <button class="action-btn edit">✏️</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#1233</td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Sara+Mohamed" alt="">
                                            <span>Sara Mohamed</span>
                                        </div>
                                    </td>
                                    <td>AC Installation</td>
                                    <td>Ali Mahmoud</td>
                                    <td><span class="status-badge pending">Pending</span></td>
                                    <td>
                                        <button class="action-btn view">👁️</button>
                                        <button class="action-btn edit">✏️</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#1232</td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Omar+Khaled" alt="">
                                            <span>Omar Khaled</span>
                                        </div>
                                    </td>
                                    <td>Plumbing Fix</td>
                                    <td>Hassan Ibrahim</td>
                                    <td><span class="status-badge completed">Completed</span></td>
                                    <td>
                                        <button class="action-btn view">👁️</button>
                                        <button class="action-btn edit">✏️</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Technicians -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">⭐ Top Rated Technicians</h3>
                        <a href="#" class="view-all">View All →</a>
                    </div>
                    <div class="technicians-list">
                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Mohamed+Hassan&background=2563eb" alt="">
                            <div class="tech-info">
                                <h4>Mohamed Hassan</h4>
                                <p>Electrical Specialist</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 4.9</span>
                                <span class="jobs">45 jobs</span>
                            </div>
                        </div>
                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Ali+Mahmoud&background=059669" alt="">
                            <div class="tech-info">
                                <h4>Ali Mahmoud</h4>
                                <p>AC Technician</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 4.8</span>
                                <span class="jobs">38 jobs</span>
                            </div>
                        </div>
                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Hassan+Ibrahim&background=7e22ce" alt="">
                            <div class="tech-info">
                                <h4>Hassan Ibrahim</h4>
                                <p>Plumber</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 4.7</span>
                                <span class="jobs">32 jobs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @section('scripts')
        <script>
            // Toggle Sidebar
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.querySelector('.sidebar');

            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });

            // Add active state to nav items
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        </script>
    @endsection
@endsection
