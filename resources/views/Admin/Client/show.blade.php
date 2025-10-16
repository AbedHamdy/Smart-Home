@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('title', 'Client Details - ' . $client->user->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .client-details-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 14px;
            transition: background 0.3s;
        }

        .back-button:hover {
            background: #5a6268;
            color: white;
        }

        .client-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 12px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .client-header-content {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .client-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            color: #667eea;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .client-info h2 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }

        .client-meta {
            display: flex;
            gap: 20px;
            font-size: 14px;
            opacity: 0.95;
        }

        .client-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .detail-card h3 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
        }

        .detail-card h3 span {
            font-size: 22px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f3f5;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #6c757d;
            font-weight: 500;
            font-size: 14px;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 600;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .services-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .services-section h3 {
            margin: 0 0 25px 0;
            color: #2c3e50;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .service-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: default;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .service-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .service-card h4 {
            margin: 0 0 8px 0;
            color: #2c3e50;
            font-size: 16px;
        }

        .service-card p {
            margin: 0;
            color: #6c757d;
            font-size: 13px;
            line-height: 1.5;
        }

        .map-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .map-container h3 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .map-placeholder {
            width: 100%;
            height: 400px;
            background: #e9ecef;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 16px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn-action {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #9e9e9e, #616161);
            /* تدرّج رمادي */
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #757575, #424242);
            /* رمادي أغمق عند الـ hover */
        }


        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }

            .client-header-content {
                flex-direction: column;
                text-align: center;
            }

            .client-meta {
                flex-direction: column;
                gap: 10px;
            }

            .services-grid {
                grid-template-columns: 1fr;
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
                    <h1 class="page-title">Client Details</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="client-details-container">
                {{-- <a href="{{ route('admin.client') }}" class="back-button">
                    ← Back to Clients
                </a> --}}

                <!-- Client Header -->
                <div class="client-header">
                    <div class="client-header-content">
                        <div class="client-avatar">
                            {{ strtoupper(substr($client->user->name, 0, 2)) }}
                        </div>
                        <div class="client-info">
                            <h2>{{ $client->user->name }}</h2>
                            <div class="client-meta">
                                <span>📧 {{ $client->user->email }}</span>
                                <span>📱 {{ $client->user->phone ?? 'N/A' }}</span>
                                {{-- <span>👤 Client ID: #{{ $client->id }}</span> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="details-grid">
                    <!-- Personal Information -->
                    <div class="detail-card">
                        <h3><span>👤</span> Personal Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Full Name</span>
                            <span class="detail-value">{{ $client->user->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email Address</span>
                            <span class="detail-value">{{ $client->user->email }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phone Number</span>
                            <span class="detail-value">{{ $client->user->phone ?? 'Not Provided' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Role</span>
                            <span class="detail-value">
                                <span class="status-badge status-active">{{ ucfirst($client->user->role) }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="detail-card">
                        <h3><span>📊</span> Account Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Registered Since</span>
                            <span class="detail-value">{{ $client->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Last Activity</span>
                            <span class="detail-value">
                                {{ $client->last_activity ? \Carbon\Carbon::parse($client->last_activity)->diffForHumans() : 'Never' }}
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email Verified</span>
                            <span class="detail-value">
                                @if ($client->user->email_verified_at)
                                    <span class="status-badge status-active">✓ Verified</span>
                                @else
                                    <span class="status-badge status-inactive">✗ Not Verified</span>
                                @endif
                            </span>
                        </div>
                        {{-- @php
                            $lastActivity = $client->last_activity ? Carbon::parse($client->last_activity) : null;
                            $isActive = $lastActivity && $lastActivity->greaterThanOrEqualTo(now()->subMinutes(1));
                            $statusClass = $isActive ? 'status-active' : 'status-inactive';
                            $statusText = $isActive ? 'Active' : 'Inactive';
                        @endphp --}}

                        {{-- <div class="detail-row">
                            <span class="detail-label">Account Status</span>
                            <span class="detail-value">
                                <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                            </span>
                        </div> --}}

                    </div>

                    <!-- Location Information -->
                    <div class="detail-card">
                        <h3><span>📍</span> Location Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Address</span>
                            <span class="detail-value">{{ $client->address ?? 'Not Provided' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Latitude</span>
                            <span class="detail-value">{{ $client->latitude ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Longitude</span>
                            <span class="detail-value">{{ $client->longitude ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Coordinates</span>
                            <span class="detail-value">
                                @if ($client->latitude && $client->longitude)
                                    <a href="https://www.google.com/maps?q={{ $client->latitude }},{{ $client->longitude }}"
                                        target="_blank" style="color: #667eea;">
                                        View on Map 🗺️
                                    </a>
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Available Services -->
                <div class="services-section">
                    <h3>🔧 Available Home Services</h3>
                    <div class="services-grid">
                        <div class="service-card">
                            <div class="service-icon">⚡</div>
                            <h4>Electrical Services</h4>
                            <p>Installation, repair, and maintenance of electrical systems and appliances</p>
                        </div>
                        <div class="service-card">
                            <div class="service-icon">🚿</div>
                            <h4>Plumbing Services</h4>
                            <p>Fix leaks, install fixtures, and maintain water systems</p>
                        </div>
                        <div class="service-card">
                            <div class="service-icon">❄️</div>
                            <h4>AC & Cooling</h4>
                            <p>Air conditioning installation, repair, and maintenance</p>
                        </div>
                        <div class="service-card">
                            <div class="service-icon">🎨</div>
                            <h4>Painting & Decoration</h4>
                            <p>Interior and exterior painting, wall treatments</p>
                        </div>
                        <div class="service-card">
                            <div class="service-icon">🪛</div>
                            <h4>Carpentry</h4>
                            <p>Furniture repair, door installation, and woodwork</p>
                        </div>
                        <div class="service-card">
                            <div class="service-icon">🧹</div>
                            <h4>Cleaning Services</h4>
                            <p>Deep cleaning, regular maintenance, and sanitization</p>
                        </div>
                        <div class="service-card">
                            <div class="service-icon">🏠</div>
                            <h4>General Maintenance</h4>
                            <p>All-around home repairs and maintenance tasks</p>
                        </div>
                        <div class="service-card">
                            <div class="service-icon">🔨</div>
                            <h4>Renovation</h4>
                            <p>Home improvement and remodeling services</p>
                        </div>
                    </div>
                </div>

                <!-- Map Section -->
                @if ($client->latitude && $client->longitude)
                    <div class="map-container">
                        <h3>📍 Client Location</h3>
                        <div class="map-placeholder">
                            <div style="text-align: center;">
                                <p style="margin: 0 0 10px 0;">📍 Location: {{ $client->latitude }},
                                    {{ $client->longitude }}</p>
                                <a href="https://www.google.com/maps?q={{ $client->latitude }},{{ $client->longitude }}"
                                    target="_blank" class="btn-action btn-edit">
                                    Open in Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.client') }}" class="btn-action btn-edit">
                        ← Back to Clients
                    </a>
                    <button onclick="deleteClient({{ $client->id }})" class="btn-action btn-delete">
                        🗑️ Delete Client
                    </button>
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

        // Delete Client Function
        function deleteClient(id) {
            if (confirm('Are you sure you want to delete this client? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/management/client/${id}/delete`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
