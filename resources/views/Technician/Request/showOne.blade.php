@extends("layouts.app")
@section('title', 'Service Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .request-details {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .detail-header {
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .detail-header h2 {
            color: #1f2937;
            font-size: 24px;
            margin: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
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

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-item {
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #2563eb;
        }

        .detail-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
            display: block;
        }

        .detail-value {
            font-size: 16px;
            color: #1f2937;
            font-weight: 500;
        }

        .map-container {
            margin: 25px 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .map-container iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        .status-change-section {
            background: #f9fafb;
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            border: 2px solid #e5e7eb;
        }

        .status-change-section h3 {
            color: #1f2937;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .status-option {
            flex: 1;
            min-width: 200px;
        }

        .status-option input[type="radio"] {
            display: none;
        }

        .status-option label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .status-option input[type="radio"]:checked + label {
            border-color: #2563eb;
            background: #eff6ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .status-option label:hover {
            border-color: #93c5fd;
            background: #f0f9ff;
        }

        .status-icon {
            font-size: 24px;
        }

        .status-text {
            display: flex;
            flex-direction: column;
        }

        .status-name {
            font-size: 15px;
            color: #1f2937;
        }

        .status-desc {
            font-size: 12px;
            color: #6b7280;
            font-weight: 400;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-update {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .btn-update:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-back:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .description-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2563eb;
        }

        .description-box h3 {
            color: #1f2937;
            margin-bottom: 12px;
            font-size: 18px;
        }

        .description-box p {
            color: #4b5563;
            line-height: 1.6;
            font-size: 15px;
        }

        .request-image {
            max-width: 100%;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .status-options {
                flex-direction: column;
            }

            .status-option {
                min-width: 100%;
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
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Technician">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <!-- Request Details -->
            <div class="request-details">
                <div class="detail-header">
                    <h2>Request #</h2>
                    <span class="status-badge status-{{ strtolower($order->status) }}">
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
                            @default
                                {{ ucfirst($order->status) }}
                        @endswitch
                    </span>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Client Name</span>
                        <span class="detail-value">{{ $order->client->user->name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Client Phone</span>
                        <span class="detail-value">{{ $order->client->user->phone ?? 'N/A' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Service Category</span>
                        <span class="detail-value">{{ $order->category->name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Request Date</span>
                        <span class="detail-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Address</span>
                        <span class="detail-value">{{ $order->address }}</span>
                    </div>

                    @if($order->title)
                    <div class="detail-item">
                        <span class="detail-label">Title</span>
                        <span class="detail-value">{{ $order->title }}</span>
                    </div>
                    @endif
                </div>

                @if($order->description)
                <div class="description-box">
                    <h3>📝 Description</h3>
                    <p>{{ $order->description }}</p>
                </div>
                @endif

                @if($order->image)
                <div>
                    <h3 style="color: #1f2937; margin-bottom: 15px;">🖼️ Request Image</h3>
                    <img src="{{ asset($order->image) }}" alt="Request Image" class="request-image">
                </div>
                @endif

                <!-- Map Section -->
                @if($order->latitude && $order->longitude)
                <div>
                    <h3 style="color: #1f2937; margin: 25px 0 15px;">📍 Location</h3>
                    <div class="map-container">
                        <iframe
                            src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=en&z=15&output=embed"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
                @endif

                <!-- Status Change Section -->
                @if($order->status != 'completed' && $order->status != 'canceled')
                <div class="status-change-section">
                    <h3>🔄 Update Request Status</h3>

                    <form action="{{ route('technician_request.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="status-options">
                            @if($order->status == 'assigned')
                            <div class="status-option">
                                <input type="radio" name="status" value="in_progress" id="status_in_progress" checked>
                                <label for="status_in_progress">
                                    <span class="status-icon">🔄</span>
                                    <span class="status-text">
                                        <span class="status-name">Start Working</span>
                                        <span class="status-desc">Mark as In Progress</span>
                                    </span>
                                </label>
                            </div>
                            @endif

                            @if($order->status == 'in_progress')
                            <div class="status-option">
                                <input type="radio" name="status" value="completed" id="status_completed" checked>
                                <label for="status_completed">
                                    <span class="status-icon">✅</span>
                                    <span class="status-text">
                                        <span class="status-name">Complete Job</span>
                                        <span class="status-desc">Mark as Completed</span>
                                    </span>
                                </label>
                            </div>
                            @endif

                            <div class="status-option">
                                <input type="radio" name="status" value="canceled" id="status_canceled">
                                <label for="status_canceled">
                                    <span class="status-icon">❌</span>
                                    <span class="status-text">
                                        <span class="status-name">Cancel Request</span>
                                        <span class="status-desc">Unable to complete</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-update" onclick="return confirm('Are you sure you want to update the status?')">
                                💾 Update Status
                            </button>
                            <a href="{{ route('technician_request.myRequests') }}" class="btn btn-back">
                                ← Back to My Requests
                            </a>
                        </div>
                    </form>
                </div>
                @else
                <div class="action-buttons" style="margin-top: 30px; padding-top: 25px; border-top: 2px solid #e5e7eb;">
                    {{-- {{ route('technician.my_requests.index') }} --}}
                    <a href="{{ route('technician_request.myRequests') }}" class="btn btn-back">
                        ← Back to My Requests
                    </a>
                </div>
                @endif
            </div>
        </main>
    </div>
@endsection

{{-- @section('scripts')
    <script>
        // Toggle Sidebar
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
@endsection --}}
