@extends("layouts.app")
@section('title', 'Service Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .request-details {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            padding: 40px;
            margin: 30px 0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
        }

        .request-details::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.03) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .request-details:hover {
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            transform: translateY(-2px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .detail-header {
            background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
            border-radius: 16px;
            padding: 30px;
            margin-bottom: 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.25);
        }

        .detail-header::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .detail-header h2 {
            color: white;
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 15px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        .detail-header h2::before {
            content: '📋';
            font-size: 36px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        .status-badge:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
        }

        .status-pending {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #78350f;
            border: 2px solid rgba(251, 191, 36, 0.3);
        }

        .status-pending::before {
            content: '⏳';
            font-size: 18px;
        }

        .status-accepted {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: 2px solid rgba(16, 185, 129, 0.3);
        }

        .status-accepted::before {
            content: '✅';
            font-size: 18px;
        }

        .status-rejected {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        .status-rejected::before {
            content: '❌';
            font-size: 18px;
        }

        .status-completed {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: white;
            border: 2px solid rgba(139, 92, 246, 0.3);
        }

        .status-completed::before {
            content: '🎉';
            font-size: 18px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .detail-item {
            padding: 25px;
            background: white;
            border-radius: 16px;
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .detail-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg, #2563eb 0%, #7c3aed 100%);
            transition: width 0.3s ease;
        }

        .detail-item::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.03) 0%, rgba(124, 58, 237, 0.03) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .detail-item:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.15);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .detail-item:hover::before {
            width: 100%;
        }

        .detail-item:hover::after {
            opacity: 1;
        }

        .detail-label {
            font-size: 11px;
            color: #6b7280;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            z-index: 1;
        }

        .detail-value {
            font-size: 18px;
            color: #1f2937;
            font-weight: 700;
            line-height: 1.6;
            position: relative;
            z-index: 1;
            word-wrap: break-word;
        }

        .map-container {
            margin: 35px 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
            border: 3px solid #e5e7eb;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
        }

        .map-container:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 70px rgba(37, 99, 235, 0.2);
            border-color: #2563eb;
        }

        .map-link {
            display: block;
            position: relative;
            cursor: pointer;
            text-decoration: none;
        }

        .map-container iframe {
            width: 100%;
            height: 500px;
            border: none;
            display: block;
            pointer-events: none;
            filter: grayscale(10%);
            transition: filter 0.3s ease;
        }

        .map-link:hover iframe {
            filter: grayscale(0%);
        }

        .map-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0) 0%, rgba(37, 99, 235, 0) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.4s ease;
        }

        .map-link:hover .map-overlay {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%);
        }

        .map-overlay-text {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            color: #2563eb;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 17px;
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.3);
            opacity: 0;
            transform: translateY(20px) scale(0.9);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(37, 99, 235, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .map-link:hover .map-overlay-text {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .action-buttons {
            display: flex;
            gap: 20px;
            margin-top: 40px;
            padding-top: 35px;
            border-top: 3px solid #e5e7eb;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn {
            padding: 16px 36px;
            border: none;
            border-radius: 12px;
            font-size: 17px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-accept {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: 2px solid rgba(16, 185, 129, 0.3);
        }

        .btn-accept:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.4);
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border: 2px solid rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(239, 68, 68, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            border: 2px solid rgba(107, 114, 128, 0.3);
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 35px rgba(107, 114, 128, 0.4);
        }

        .description-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 30px;
            border-radius: 16px;
            margin: 30px 0;
            border: 2px solid rgba(37, 99, 235, 0.2);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .description-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #2563eb 0%, #7c3aed 100%);
        }

        .description-box:hover {
            box-shadow: 0 12px 40px rgba(37, 99, 235, 0.2);
            transform: translateY(-4px);
            border-color: rgba(37, 99, 235, 0.4);
        }

        .description-box h3 {
            color: #1f2937;
            margin-bottom: 18px;
            font-size: 22px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .description-box h3::before {
            content: '📝';
            font-size: 28px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .description-box p {
            color: #374151;
            line-height: 1.9;
            font-size: 17px;
            font-weight: 500;
        }

        /* Request Image Styling */
        .image-section {
            margin: 35px 0;
            position: relative;
            z-index: 1;
        }

        .image-section h3 {
            color: #1f2937;
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .image-section h3::before {
            content: '🖼️';
            font-size: 32px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .request-image-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 3px solid #e5e7eb;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        }

        .request-image-container:hover {
            transform: scale(1.02) translateY(-5px);
            box-shadow: 0 25px 70px rgba(37, 99, 235, 0.25);
            border-color: #2563eb;
        }

        .request-image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0) 0%, rgba(124, 58, 237, 0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
            pointer-events: none;
        }

        .request-image-container:hover::before {
            opacity: 0.1;
        }

        .request-image {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: contain;
            display: block;
            transition: transform 0.3s ease;
            padding: 15px;
        }

        .request-image-container:hover .request-image {
            transform: scale(1.02);
        }

        .image-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .image-badge::before {
            content: '📸';
            font-size: 16px;
        }

        /* Phone Number Click to Call */
        .phone-link {
            color: #2563eb;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .phone-link:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        @media (max-width: 968px) {
            .request-details {
                padding: 30px;
                margin: 20px 0;
            }

            .detail-header {
                padding: 25px;
                flex-direction: column;
                align-items: flex-start;
            }

            .detail-header h2 {
                font-size: 26px;
            }

            .detail-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .request-details {
                padding: 25px;
                margin: 15px 0;
                border-radius: 16px;
            }

            .detail-header h2 {
                font-size: 24px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .map-container iframe {
                height: 350px;
            }
        }

        @media (max-width: 480px) {
            .request-details {
                padding: 20px;
                border-radius: 12px;
            }

            .detail-header {
                padding: 20px;
            }

            .detail-header h2 {
                font-size: 20px;
            }

            .detail-header h2::before {
                font-size: 24px;
            }

            .status-badge {
                padding: 10px 20px;
                font-size: 13px;
            }

            .detail-item {
                padding: 20px;
            }

            .detail-value {
                font-size: 16px;
            }

            .btn {
                padding: 14px 28px;
                font-size: 15px;
            }

            .map-container iframe {
                height: 280px;
            }

            .description-box {
                padding: 20px;
            }

            .description-box h3 {
                font-size: 18px;
            }

            .description-box p {
                font-size: 15px;
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
                    <h1 class="page-title">Service Request Details</h1>
                </div>
                <div class="topbar-right">
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Technician">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="request-details">
                <div class="detail-header">
                    <h2>Request # {{ $order->title }}</h2>
                    <span class="status-badge status-{{ strtolower($order->status) }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">👤 Client Name</span>
                        <span class="detail-value">{{ $order->client->user->name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">📱 Client Phone</span>
                        <span class="detail-value">
                            @if($order->client->user->phone)
                                <a href="tel:{{ $order->client->user->phone }}" class="phone-link">
                                    {{ $order->client->user->phone }}
                                </a>
                            @else
                                N/A
                            @endif
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">🔧 Service Category</span>
                        <span class="detail-value">{{ $order->category->name }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">📅 Request Date</span>
                        <span class="detail-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">📍 Address</span>
                        <span class="detail-value">{{ $order->address }}</span>
                    </div>
                </div>

                @if($order->description)
                <div class="description-box">
                    <h3>Description</h3>
                    <p>{{ $order->description }}</p>
                </div>
                @endif

                @if($order->image)
                <div class="image-section">
                    <h3>Request Image</h3>
                    <div class="request-image-container">
                        <div class="image-badge">Attached</div>
                        <img src="{{ asset($order->image) }}" alt="Request Image" class="request-image">
                    </div>
                </div>
                @endif

                @if($order->latitude && $order->longitude)
                <div class="map-container">
                    <a href="https://www.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}" target="_blank" class="map-link">
                        <iframe
                            src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=en&z=15&output=embed"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                        <div class="map-overlay">
                            <span class="map-overlay-text">
                                🗺️ Open in Google Maps
                            </span>
                        </div>
                    </a>
                </div>
                @endif

                @if($order->status == 'pending')
                <div class="action-buttons">
                    <form action="{{ route('technician_requests.accept', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-accept" onclick="return confirm('Are you sure you want to accept this request?')">
                            <span>✓ Accept Request</span>
                        </button>
                    </form>

                    <form action="{{ route('technician_requests.reject', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-reject" onclick="return confirm('Are you sure you want to reject this request?')">
                            <span>✗ Reject Request</span>
                        </button>
                    </form>

                    <a href="{{ route('technician_requests.index') }}" class="btn btn-back">
                        <span>← Back to Requests</span>
                    </a>
                </div>
                @else
                <div class="action-buttons">
                    <a href="{{ route('technician_requests.index') }}" class="btn btn-back">
                        <span>← Back to Requests</span>
                    </a>
                </div>
                @endif
            </div>
        </main>
    </div>
@endsection
