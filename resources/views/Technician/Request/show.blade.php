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
        }

        .detail-header h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-accepted {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-completed {
            background: #dbeafe;
            color: #1e40af;
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

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid #e5e7eb;
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
            display: inline-block;
        }

        .btn-accept {
            background: #10b981;
            color: white;
        }

        .btn-accept:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-reject {
            background: #ef4444;
            color: white;
        }

        .btn-reject:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-back:hover {
            background: #4b5563;
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
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Client Name</span>
                        <span class="detail-value">{{ $order->client->user->name }}</span>
                    </div>

                    {{-- <div class="detail-item">
                        <span class="detail-label">Client Email</span>
                        <span class="detail-value">{{ $order->client->user->email }}</span>
                    </div> --}}

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
                </div>

                @if($order->description)
                <div class="description-box">
                    <h3>Description</h3>
                    <p>{{ $order->description }}</p>
                </div>
                @endif

                <!-- Map Section -->
                @if($order->latitude && $order->longitude)
                <div class="map-container">
                    <iframe
                        src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=en&z=15&output=embed"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
                @endif

                <!-- Action Buttons -->
                @if($order->status == 'pending')
                <div class="action-buttons">

                    <form action="{{ route("technician_requests.accept" , $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-accept" onclick="return confirm('Are you sure you want to accept this request?')">
                            ✓ Accept Request
                        </button>
                    </form>

                    <form action="{{ route("technician_requests.reject" , $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this request?')">
                            ✗ Reject Request
                        </button>
                    </form>

                    <a href="{{ route('technician_requests.index') }}" class="btn btn-back">
                        ← Back to Requests
                    </a>
                </div>
                @else
                <div class="action-buttons">
                    <a href="{{ route('technician_requests.index') }}" class="btn btn-back">
                        ← Back to Requests
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
