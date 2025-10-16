@extends("layouts.app")
@section('title', 'Service Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .details-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .header-left {
            flex: 1;
        }

        .details-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .request-id {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .header-actions {
            display: flex;
            gap: 12px;
        }

        .btn-back {
            padding: 10px 20px;
            border: 2px solid var(--border);
            border-radius: 10px;
            background: white;
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            border-color: var(--primary-light);
            color: var(--primary-light);
        }

        .status-badge-large {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pending {
            background: #FFF3E0;
            color: #E65100;
        }

        .status-assigned {
            background: #E3F2FD;
            color: #1565C0;
        }

        .status-in_progress {
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

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: var(--background);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--border);
        }

        .detail-card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-card-content {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .detail-card-content.large {
            font-size: 20px;
        }

        .image-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .request-image-large {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 15px;
            border: 3px solid var(--border);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .no-image-large {
            width: 100%;
            max-width: 600px;
            height: 300px;
            border-radius: 15px;
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 3px solid var(--border);
        }

        .no-image-icon {
            font-size: 64px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .no-image-text {
            font-size: 16px;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .description-section {
            margin-bottom: 30px;
        }

        .description-content {
            background: var(--background);
            padding: 20px;
            border-radius: 15px;
            border: 2px solid var(--border);
            font-size: 15px;
            line-height: 1.6;
            color: var(--text-primary);
        }

        .description-content.empty {
            color: var(--text-secondary);
            font-style: italic;
            text-align: center;
            padding: 40px 20px;
        }

        .map-section {
            margin-bottom: 30px;
        }

        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            border: 3px solid var(--border);
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .coordinates-info {
            margin-top: 15px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .coordinate-item {
            background: var(--background);
            padding: 12px 20px;
            border-radius: 10px;
            border: 2px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .coordinate-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .coordinate-value {
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 600;
            font-family: monospace;
        }

        .technician-section {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .technician-section.not-assigned {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
        }

        .technician-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .technician-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .technician-info h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .technician-info p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .timeline-section {
            background: var(--background);
            padding: 25px;
            border-radius: 15px;
            border: 2px solid var(--border);
        }

        .timeline-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            width: 2px;
            height: calc(100% - 20px);
            background: var(--border);
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            z-index: 1;
        }

        .timeline-icon.created {
            background: #E3F2FD;
        }

        .timeline-icon.completed {
            background: #E8F5E9;
        }

        .timeline-content h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .timeline-content p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        @media (max-width: 768px) {
            .details-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .header-actions {
                width: 100%;
            }

            .btn-back {
                flex: 1;
                justify-content: center;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                    <h1 class="page-title">Service Request Details</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Client">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <!-- Details Container -->
            <div class="details-container">
                <!-- Header -->
                <div class="details-header">
                    <div class="header-left">
                        <h2>{{ $order->title }}</h2>
                        {{-- <p class="request-id">Request ID: #{{ $order->id }}</p> --}}
                    </div>
                    <div class="header-actions">
                        <span class="status-badge-large status-{{ $order->status }}">
                            @switch($order->status)
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
                            @endswitch
                        </span>
                        <a href="{{ route('client.service_request.index') }}" class="btn-back">
                            ← Back
                        </a>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="details-grid">
                    <div class="detail-card">
                        <div class="detail-card-title">
                            📂 Category
                        </div>
                        <div class="detail-card-content large">
                            {{ $order->category->name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="detail-card">
                        <div class="detail-card-title">
                            📅 Created Date
                        </div>
                        <div class="detail-card-content">
                            {{ $order->created_at->format('M d, Y') }}<br>
                            <small style="font-size: 13px; color: var(--text-secondary);">
                                {{ $order->created_at->format('h:i A') }}
                            </small>
                        </div>
                    </div>

                    @if($order->completed_at)
                        <div class="detail-card">
                            <div class="detail-card-title">
                                ✅ Completed Date
                            </div>
                            <div class="detail-card-content">
                                {{ \Carbon\Carbon::parse($order->completed_at)->format('M d, Y') }}<br>
                                <small style="font-size: 13px; color: var(--text-secondary);">
                                    {{ \Carbon\Carbon::parse($order->completed_at)->format('h:i A') }}
                                </small>
                            </div>
                        </div>
                    @endif

                    <div class="detail-card">
                        <div class="detail-card-title">
                            📍 Address
                        </div>
                        <div class="detail-card-content">
                            {{ $order->address ?? 'No address provided' }}
                        </div>
                    </div>
                </div>

                <!-- Technician Section -->
                @if($order->technician_id)
                    <div class="technician-section">
                        <div class="section-title">
                            👨‍🔧 Assigned Technician
                        </div>
                        <div class="technician-header">
                            <img src="https://ui-avatars.com/api/?name={{ $order->technician->user->name }}&background=4CAF50&color=fff"
                                 alt="Technician"
                                 class="technician-avatar">
                            <div class="technician-info">
                                <h3>{{ $order->technician->user->name }}</h3>
                                <p>📧 {{ $order->technician->user->email }}</p>
                                <p>📱 {{ $order->technician->user->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="technician-section not-assigned">
                        <div class="section-title">
                            ⏳ Waiting for Technician Assignment
                        </div>
                        <p style="color: var(--text-secondary); margin-top: 10px;">
                            Your request is pending. A technician will be assigned soon.
                        </p>
                    </div>
                @endif

                <!-- Image Section -->
                <div class="image-section">
                    <div class="section-title">
                        🖼️ Service Image
                    </div>
                    @if($order->image)
                        <img src="{{ asset($order->image) }}"
                             alt="Service Request Image"
                             class="request-image-large">
                    @else
                        <div class="no-image-large">
                            <div class="no-image-icon">🔧</div>
                            <div class="no-image-text">No image uploaded</div>
                        </div>
                    @endif
                </div>

                <!-- Description Section -->
                <div class="description-section">
                    <div class="section-title">
                        📝 Description
                    </div>
                    @if($order->description)
                        <div class="description-content">
                            {{ $order->description }}
                        </div>
                    @else
                        <div class="description-content empty">
                            No description provided
                        </div>
                    @endif
                </div>

                <!-- Map Section -->
                <div class="map-section">
                    <div class="section-title">
                        🗺️ Location
                    </div>
                    <div class="map-container" id="map"></div>
                    <div class="coordinates-info">
                        <div class="coordinate-item">
                            <span class="coordinate-label">Latitude:</span>
                            <span class="coordinate-value">{{ $order->latitude }}</span>
                        </div>
                        <div class="coordinate-item">
                            <span class="coordinate-label">Longitude:</span>
                            <span class="coordinate-value">{{ $order->longitude }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="timeline-section">
                    <div class="section-title">
                        📅 Request Timeline
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon created">
                            📝
                        </div>
                        <div class="timeline-content">
                            <h4>Request Created</h4>
                            <p>{{ $order->created_at->format('M d, Y - h:i A') }}</p>
                        </div>
                    </div>

                    @if($order->completed_at)
                        <div class="timeline-item">
                            <div class="timeline-icon completed">
                                ✅
                            </div>
                            <div class="timeline-content">
                                <h4>Request Completed</h4>
                                <p>{{ \Carbon\Carbon::parse($order->completed_at)->format('M d, Y - h:i A') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Toggle Sidebar
        // const menuToggle = document.getElementById('menuToggle');
        // const sidebar = document.querySelector('.sidebar');

        // menuToggle.addEventListener('click', () => {
        //     sidebar.classList.toggle('collapsed');
        // });

        // Initialize Map with Leaflet (OpenStreetMap)
        document.addEventListener('DOMContentLoaded', function() {
            const latitude = {{ $order->latitude }};
            const longitude = {{ $order->longitude }};

            // Initialize map
            const map = L.map('map').setView([latitude, longitude], 15);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Custom marker icon
            const customIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: #3949ab; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 3px 10px rgba(0,0,0,0.3); border: 3px solid white;">📍</div>',
                iconSize: [40, 40],
                iconAnchor: [20, 40]
            });

            // Add marker
            const marker = L.marker([latitude, longitude], { icon: customIcon }).addTo(map);

            // Add popup
            marker.bindPopup(`
                <div style="padding: 10px; min-width: 200px;">
                    <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 700; color: #333;">{{ $order->title }}</h3>
                    <p style="margin: 0; font-size: 13px; color: #666;">{{ $order->address ?? 'Service Location' }}</p>
                </div>
            `).openPopup();
        });
    </script>
@endsection
