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
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Admin">
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
                        {{-- <a href="#" class="view-all">View All →</a> --}}
                    </div>
                    <div class="technicians-list">
                        @foreach ($techniciansTopRating as $tech)
                            <div class="tech-item">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Str::of($tech->user->name)->substr(0, 2)) }}&background=2563eb" alt="image">

                                <div class="tech-info">
                                    <h4>{{ $tech->user->name }}</h4>
                                    <p>{{ $tech->category->name ?? 'No specialization' }}</p>
                                </div>

                                <div class="tech-rating">
                                    <span class="rating">⭐ {{ number_format($tech->rating, 1) }}</span>
                                    {{-- <span class="jobs">{{ $tech->completed_jobs_count ?? 0 }} jobs</span> --}}
                                </div>
                            </div>
                        @endforeach
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
