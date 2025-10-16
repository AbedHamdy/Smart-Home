@extends("layouts.app")
@section('title', 'Technician Dashboard')

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
                    <h1 class="page-title">Technician Dashboard</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search jobs...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Technician">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card blue">
                    <div class="stat-icon">📋</div>
                    <div class="stat-details">
                        <div class="stat-value">12</div>
                        <div class="stat-label">Total Jobs</div>
                        <span class="stat-change positive">+3 This Week</span>
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-icon">✅</div>
                    <div class="stat-details">
                        <div class="stat-value">8</div>
                        <div class="stat-label">Completed Jobs</div>
                        <span class="stat-change positive">67% Success Rate</span>
                    </div>
                </div>

                <div class="stat-card purple">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-details">
                        <div class="stat-value">3</div>
                        <div class="stat-label">In Progress</div>
                        <span class="stat-change neutral">2 Due Today</span>
                    </div>
                </div>

                <div class="stat-card orange">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-details">
                        <div class="stat-value">4.8</div>
                        <div class="stat-label">Rating</div>
                        <span class="stat-change positive">+0.2 This Month</span>
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <!-- Weekly Performance Chart -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">Weekly Performance</h3>
                        <select class="period-select">
                            <option>This Week</option>
                            <option>Last Week</option>
                            <option>Last Month</option>
                        </select>
                    </div>
                    <div class="chart-placeholder">
                        <div class="placeholder-content">
                            <span class="placeholder-icon">📊</span>
                            <p>Performance chart will appear here</p>
                        </div>
                    </div>
                </div>

                <!-- Job Categories -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="card-title">Job Categories</h3>
                        <a href="#" class="view-all">View All →</a>
                    </div>
                    <div class="categories-list">
                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">🔧</div>
                                <span class="category-name">Installation</span>
                            </div>
                            <span class="category-count">5 jobs</span>
                        </div>

                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">🛠️</div>
                                <span class="category-name">Maintenance</span>
                            </div>
                            <span class="category-count">4 jobs</span>
                        </div>

                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">⚠️</div>
                                <span class="category-name">Repair</span>
                            </div>
                            <span class="category-count">2 jobs</span>
                        </div>

                        <div class="category-item">
                            <div class="category-info">
                                <div class="category-icon">🔍</div>
                                <span class="category-name">Inspection</span>
                            </div>
                            <span class="category-count">1 job</span>
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
                        <a href="#" class="view-all">View All →</a>
                    </div>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Job Type</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Ahmed+Hassan&background=2563eb&color=fff" alt="Ahmed Hassan">
                                            <span>Ahmed Hassan</span>
                                        </div>
                                    </td>
                                    <td>Smart Lock Installation</td>
                                    <td><span class="status-badge in-progress">In Progress</span></td>
                                    <td>Today, 3:00 PM</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Sara+Mohamed&background=16a34a&color=fff" alt="Sara Mohamed">
                                            <span>Sara Mohamed</span>
                                        </div>
                                    </td>
                                    <td>Thermostat Repair</td>
                                    <td><span class="status-badge pending">Pending</span></td>
                                    <td>Tomorrow, 10:00 AM</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Omar+Ali&background=9333ea&color=fff" alt="Omar Ali">
                                            <span>Omar Ali</span>
                                        </div>
                                    </td>
                                    <td>Camera Maintenance</td>
                                    <td><span class="status-badge completed">Completed</span></td>
                                    <td>Yesterday</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Fatma+Khalil&background=ea580c&color=fff" alt="Fatma Khalil">
                                            <span>Fatma Khalil</span>
                                        </div>
                                    </td>
                                    <td>Light System Setup</td>
                                    <td><span class="status-badge in-progress">In Progress</span></td>
                                    <td>Today, 5:00 PM</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <img src="https://ui-avatars.com/api/?name=Youssef+Ibrahim&background=0891b2&color=fff" alt="Youssef Ibrahim">
                                            <span>Youssef Ibrahim</span>
                                        </div>
                                    </td>
                                    <td>Speaker Installation</td>
                                    <td><span class="status-badge pending">Scheduled</span></td>
                                    <td>Oct 14, 2:00 PM</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Reviews</h3>
                        <a href="#" class="view-all">View All →</a>
                    </div>
                    <div class="technicians-list">
                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Mona+Adel&background=2563eb&color=fff" alt="Mona Adel">
                            <div class="tech-info">
                                <h4>Mona Adel</h4>
                                <p>Smart Lock Installation</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 5.0</span>
                                <span class="jobs">2 days ago</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Khaled+Samir&background=16a34a&color=fff" alt="Khaled Samir">
                            <div class="tech-info">
                                <h4>Khaled Samir</h4>
                                <p>Thermostat Repair</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 4.5</span>
                                <span class="jobs">3 days ago</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Nour+Hassan&background=9333ea&color=fff" alt="Nour Hassan">
                            <div class="tech-info">
                                <h4>Nour Hassan</h4>
                                <p>Camera Installation</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 5.0</span>
                                <span class="jobs">5 days ago</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Hany+Mahmoud&background=ea580c&color=fff" alt="Hany Mahmoud">
                            <div class="tech-info">
                                <h4>Hany Mahmoud</h4>
                                <p>Light System Setup</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 4.8</span>
                                <span class="jobs">1 week ago</span>
                            </div>
                        </div>

                        <div class="tech-item">
                            <img src="https://ui-avatars.com/api/?name=Laila+Fathy&background=0891b2&color=fff" alt="Laila Fathy">
                            <div class="tech-info">
                                <h4>Laila Fathy</h4>
                                <p>Speaker Installation</p>
                            </div>
                            <div class="tech-rating">
                                <span class="rating">⭐ 5.0</span>
                                <span class="jobs">1 week ago</span>
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

        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            } else {
                console.log("المتصفح لا يدعم تحديد الموقع");
            }

            function successCallback(position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;

                // أرسل الموقع للـ backend
                fetch("{{ route('technician.updateLocation') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        latitude: latitude,
                        longitude: longitude
                    })
                }).then(response => response.json())
                .then(data => console.log("Location updated:", data))
                .catch(error => console.error("Error updating location:", error));
            }

            function errorCallback(error) {
                console.log("خطأ في تحديد الموقع:", error.message);
            }
        });
    </script>
@endsection
