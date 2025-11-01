@extends('layouts.app')
@section('title', 'Service Request #' . $order->id . ' - Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        .request-details-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        .details-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 16px;
            padding: 35px 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .details-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            backdrop-filter: blur(10px);
        }

        .header-text h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
        }

        .header-meta {
            font-size: 14px;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 15px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .status-pending {
            background: rgba(251, 191, 36, 0.9);
            color: #78350f;
        }

        .status-assigned {
            background: rgba(59, 130, 246, 0.9);
            color: #1e3a8a;
        }

        .status-in_progress {
            background: rgba(168, 85, 247, 0.9);
            color: #4c1d95;
        }

        .status-completed {
            background: rgba(16, 185, 129, 0.9);
            color: #064e3b;
        }

        .status-issue_reported {
            background: rgba(245, 158, 11, 0.9);
            color: #78350f;
        }

        .status-rescheduled {
            background: rgba(14, 165, 233, 0.9);
            color: #0c4a6e;
        }

        .status-canceled {
            background: rgba(239, 68, 68, 0.9);
            color: #7f1d1d;
        }

        .status-waiting_for_approval {
            background: rgba(251, 191, 36, 0.9);
            color: #78350f;
        }

        .status-approved_for_repair {
            background: rgba(16, 185, 129, 0.9);
            color: #064e3b;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--gray-100);
        }

        .card-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .info-group {
            display: grid;
            gap: 20px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px;
            background: var(--gray-50);
            border-radius: 12px;
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: var(--gray-100);
            transform: translateX(5px);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: var(--gray-900);
            font-weight: 600;
        }

        .person-card {
            background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
            border-radius: 16px;
            padding: 25px;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .person-card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.1);
        }

        .person-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .person-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .person-info h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 5px 0;
        }

        .person-role {
            font-size: 13px;
            color: var(--gray-600);
            font-weight: 500;
        }

        .person-details {
            display: grid;
            gap: 12px;
        }

        .person-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--gray-700);
        }

        .person-detail-icon {
            width: 32px;
            height: 32px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .description-box {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 16px;
            padding: 25px;
            border-left: 5px solid var(--primary-color);
            margin-bottom: 30px;
        }

        .description-box h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-box p {
            color: var(--gray-700);
            line-height: 1.8;
            font-size: 15px;
            margin: 0;
        }

        .cost-summary {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px;
            padding: 30px;
            border: 3px solid var(--warning-color);
            margin-bottom: 30px;
        }

        .cost-summary h3 {
            font-size: 20px;
            font-weight: 700;
            color: #92400e;
            margin: 0 0 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cost-items {
            display: grid;
            gap: 15px;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: white;
            border-radius: 12px;
            font-size: 15px;
        }

        .cost-item.total {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            font-size: 18px;
            font-weight: 700;
            padding: 20px;
        }

        .cost-label {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cost-value {
            font-weight: 700;
            color: #92400e;
        }

        .cost-item.total .cost-value {
            color: white;
        }

        .btn-pay-now {
            width: 100%;
            padding: 18px 30px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-pay-now:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(16, 185, 129, 0.5);
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .btn-pay-now:active {
            transform: translateY(-1px);
        }

        .alert-box {
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid;
        }

        .alert-box h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 15px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-box p {
            line-height: 1.7;
            margin: 0;
        }

        .alert-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: var(--success-color);
            color: #065f46;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            border-color: var(--warning-color);
            color: #92400e;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
            border-color: var(--danger-color);
            color: #7f1d1d;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: var(--info-color);
            color: #1e40af;
        }

        .map-container {
            margin: 30px 0;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            height: 450px;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .request-image {
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            margin: 30px 0;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .request-image:hover {
            transform: scale(1.02);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-dark));
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 30px;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            width: 42px;
            height: 42px;
            background: white;
            border: 4px solid var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            z-index: 1;
        }

        .timeline-content {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .timeline-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 5px;
        }

        .timeline-date {
            font-size: 13px;
            color: var(--gray-600);
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .request-details-container {
                padding: 15px;
            }

            .details-header {
                padding: 25px 20px;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .card {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
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

            @include('layouts.message_admin')

            <div class="request-details-container">
                <!-- Header Section -->
                <div class="details-header">
                    <div class="header-content">
                        <div class="header-title">
                            <div class="header-icon">📋</div>
                            <div class="header-text">
                                <h1>Service Request # {{ $order->title }}</h1>
                                <div class="header-meta">
                                    <span>📅 {{ $order->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>
                        </div>
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

                                @case('waiting_for_approval')
                                    ⏸️ Waiting for Approval
                                @break

                                @case('approved_for_repair')
                                    ✔️ Approved for Repair
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
                                    {{ ucfirst($order->status) }}
                            @endswitch
                        </span>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="content-grid">
                    <!-- Left Column -->
                    <div>
                        <!-- Request Information Card -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">📝</div>
                                <h2 class="card-title">Request Information</h2>
                            </div>
                            <div class="info-group">
                                @if ($order->title)
                                    <div class="info-item">
                                        <div class="info-icon">📌</div>
                                        <div class="info-content">
                                            <div class="info-label">Title</div>
                                            <div class="info-value">{{ $order->title }}</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="info-item">
                                    <div class="info-icon">🏷️</div>
                                    <div class="info-content">
                                        <div class="info-label">Service Category</div>
                                        <div class="info-value">{{ $order->category->name }}</div>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">📍</div>
                                    <div class="info-content">
                                        <div class="info-label">Service Address</div>
                                        <div class="info-value">{{ $order->address }}</div>
                                    </div>
                                </div>

                                @if ($order->inspection_fee)
                                    <div class="info-item" style="border-left-color: #f59e0b;">
                                        <div class="info-icon">💰</div>
                                        <div class="info-content">
                                            <div class="info-label">Inspection Fee</div>
                                            <div class="info-value" style="color: #d97706; font-size: 20px;">
                                                {{ number_format($order->inspection_fee, 2) }} EGP
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($order->completed_at)
                                    <div class="info-item" style="border-left-color: #10b981;">
                                        <div class="info-icon">✅</div>
                                        <div class="info-content">
                                            <div class="info-label">Completed At</div>
                                            <div class="info-value">{{ $order->completed_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        @if ($order->description)
                            <div class="description-box">
                                <h3>📄 Request Description</h3>
                                <p>{{ $order->description }}</p>
                            </div>
                        @endif

                        <!-- Payment Status Section (Only show if repair_cost exists) -->
                        @if ($order->repair_cost)
                            <div class="card" style="margin-bottom: 30px;">
                                <div class="card-header">
                                    <div class="card-icon">💳</div>
                                    <h2 class="card-title">Payment Status</h2>
                                </div>

                                <div
                                    style="padding: 20px; background: {{ $order->payment_status == 'paid' ? 'linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%)' : ($order->payment_status == 'refunded' ? 'linear-gradient(135deg, #fef3c7 0%, #fde68a 100%)' : 'linear-gradient(135deg, #fed7aa 0%, #fdba74 100%)') }}; border-radius: 12px; text-align: center;">
                                    @switch($order->payment_status)
                                        @case('paid')
                                            <div style="font-size: 48px; margin-bottom: 15px;">✅</div>
                                            <h3 style="color: #065f46; font-size: 24px; font-weight: 700; margin: 0 0 10px 0;">
                                                Payment Completed</h3>
                                            <p style="color: #047857; margin: 0;">This service has been fully paid</p>
                                        @break

                                        @case('refunded')
                                            <div style="font-size: 48px; margin-bottom: 15px;">↩️</div>
                                            <h3 style="color: #92400e; font-size: 24px; font-weight: 700; margin: 0 0 10px 0;">
                                                Payment Refunded</h3>
                                            <p style="color: #b45309; margin: 0;">The payment has been refunded</p>
                                        @break

                                        @default
                                            <div style="font-size: 48px; margin-bottom: 15px;">⏳</div>
                                            <h3 style="color: #92400e; font-size: 24px; font-weight: 700; margin: 0 0 10px 0;">
                                                Payment Pending</h3>
                                            <p style="color: #78350f; margin: 0;">Payment is required to complete this service</p>
                                    @endswitch
                                </div>
                            </div>
                        @endif

                        <!-- Cost Summary with Payment -->
                        @if ($order->repair_cost)
                            <div class="cost-summary">
                                <h3>💰 Cost Breakdown & Payment</h3>
                                <div class="cost-items">
                                    <div class="cost-item">
                                        <span class="cost-label">🔍 Inspection Fee</span>
                                        <span class="cost-value">{{ number_format($order->inspection_fee ?? 0, 2) }}
                                            EGP</span>
                                    </div>
                                    <div class="cost-item">
                                        <span class="cost-label">🔧 Repair Cost</span>
                                        <span class="cost-value">{{ number_format($order->repair_cost, 2) }} EGP</span>
                                    </div>

                                    @php
                                        $total = $order->inspection_fee ?? 0;
                                        if ($order->client_approved && $order->repair_cost) {
                                            $total += $order->repair_cost;
                                        }
                                    @endphp

                                    <div class="cost-item total">
                                        <span class="cost-label">💵 Total Amount</span>
                                        <span class="cost-value">{{ number_format($total, 2) }} EGP</span>
                                    </div>
                                </div>

                                {{-- Payment Button Section --}}
                                @if (
                                    $order->repair_cost &&
                                        $order->status == 'approved_for_repair' &&
                                        $order->client_approved &&
                                        $order->payment_status != 'paid')
                                    <div
                                        style="margin-top: 25px; padding-top: 25px; border-top: 2px dashed rgba(146, 64, 14, 0.3);">
                                        <div
                                            style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 15px;">
                                            <div
                                                style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                                <span style="font-size: 24px;">💳</span>
                                                <h4 style="margin: 0; color: #92400e; font-size: 18px;">Ready to Pay?</h4>
                                            </div>
                                            <p style="margin: 0; color: #78350f; font-size: 14px;">Complete your payment
                                                securely through our payment gateway</p>
                                        </div>

                                        <form action="{{ route('client.service_request.payment', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn-pay-now">
                                                <span style="font-size: 20px;">💳</span>
                                                <span>Pay Now - {{ number_format($total, 2) }} EGP</span>
                                                <span style="font-size: 16px;">→</span>
                                            </button>
                                        </form>

                                        <div style="margin-top: 15px; text-align: center;">
                                            <p style="font-size: 12px; color: #92400e; margin: 0;">
                                                🔒 Secure payment powered by Stripe
                                            </p>
                                        </div>
                                    </div>
                                @elseif($order->payment_status == 'paid')
                                    <div
                                        style="margin-top: 25px; padding: 20px; background: white; border-radius: 12px; text-align: center;">
                                        <span style="font-size: 32px;">✅</span>
                                        <p style="margin: 10px 0 0 0; color: #065f46; font-weight: 600;">Payment
                                            Successfully Completed</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Payment History Section --}}
                            @if ($order->payments && $order->payments->count() > 0)
                                <div class="card" style="margin-top: 30px;">
                                    <div class="card-header">
                                        <div class="card-icon">📜</div>
                                        <h2 class="card-title">Payment History</h2>
                                    </div>

                                    <div style="overflow-x: auto;">
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr
                                                    style="background: var(--gray-50); border-bottom: 2px solid var(--gray-200);">
                                                    <th
                                                        style="padding: 15px; text-align: left; font-size: 13px; font-weight: 600; color: var(--gray-700);">
                                                        DATE</th>
                                                    <th
                                                        style="padding: 15px; text-align: left; font-size: 13px; font-weight: 600; color: var(--gray-700);">
                                                        AMOUNT</th>
                                                    <th
                                                        style="padding: 15px; text-align: left; font-size: 13px; font-weight: 600; color: var(--gray-700);">
                                                        TYPE</th>
                                                    <th
                                                        style="padding: 15px; text-align: left; font-size: 13px; font-weight: 600; color: var(--gray-700);">
                                                        STATUS</th>
                                                    <th
                                                        style="padding: 15px; text-align: left; font-size: 13px; font-weight: 600; color: var(--gray-700);">
                                                        TRANSACTION ID</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->payments as $payment)
                                                    <tr style="border-bottom: 1px solid var(--gray-200);">
                                                        <td
                                                            style="padding: 15px; font-size: 14px; color: var(--gray-700);">
                                                            {{ $payment->created_at->format('d M Y, h:i A') }}
                                                        </td>
                                                        <td
                                                            style="padding: 15px; font-size: 16px; font-weight: 700; color: var(--gray-900);">
                                                            {{ number_format($payment->amount, 2) }} EGP
                                                        </td>
                                                        <td style="padding: 15px; font-size: 14px;">
                                                            <span
                                                                style="padding: 6px 12px; background: #e0f2fe; color: #075985; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                                            </span>
                                                        </td>
                                                        <td style="padding: 15px; font-size: 14px;">
                                                            @switch($payment->status)
                                                                @case('completed')
                                                                    <span
                                                                        style="padding: 6px 12px; background: #d1fae5; color: #065f46; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                                        ✅ Completed
                                                                    </span>
                                                                @break

                                                                @case('pending')
                                                                    <span
                                                                        style="padding: 6px 12px; background: #fef3c7; color: #92400e; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                                        ⏳ Pending
                                                                    </span>
                                                                @break

                                                                @case('failed')
                                                                    <span
                                                                        style="padding: 6px 12px; background: #fecaca; color: #7f1d1d; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                                        ❌ Failed
                                                                    </span>
                                                                @break

                                                                @case('refunded')
                                                                    <span
                                                                        style="padding: 6px 12px; background: #fef3c7; color: #92400e; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                                                        ↩️ Refunded
                                                                    </span>
                                                                @break
                                                            @endswitch
                                                        </td>
                                                        <td
                                                            style="padding: 15px; font-size: 12px; color: var(--gray-600); font-family: monospace;">
                                                            {{ $payment->stripe_charge_id ? Str::limit($payment->stripe_charge_id, 20) : 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Inspection Report Alert -->
                        @if ($order->repair_cost && $order->technician_report)
                            <div class="alert-box alert-success">
                                <h3>🔍 Inspection Report</h3>
                                <p><strong>Technician's Report:</strong></p>
                                <p style="margin-top: 10px;">{{ $order->technician_report }}</p>

                                @if ($order->client_approved === null)
                                    <div
                                        style="margin-top: 15px; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px;">
                                        <strong>⏳ Status:</strong> Waiting for client approval
                                    </div>
                                @elseif($order->client_approved === 1)
                                    <div
                                        style="margin-top: 15px; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px; color: #065f46;">
                                        <strong>✅ Approved:</strong> Client has approved the repair cost
                                    </div>
                                @else
                                    <div
                                        style="margin-top: 15px; padding: 15px; background: rgba(255,255,255,0.7); border-radius: 10px; color: #7f1d1d;">
                                        <strong>❌ Rejected:</strong> Client has rejected the repair cost
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Issue Report Alert -->
                        @if ($order->status == 'issue_reported' && $order->issue_type)
                            <div class="alert-box alert-warning">
                                <h3>⚠️ Reported Issue</h3>
                                <p><strong>Issue Type:</strong>
                                    @switch($order->issue_type)
                                        @case('missing_parts')
                                            Missing Parts/Tools
                                        @break

                                        @case('technical_difficulty')
                                            Technical Difficulty
                                        @break

                                        @case('client_unavailable')
                                            Client Unavailable
                                        @break

                                        @case('additional_work')
                                            Additional Work Required
                                        @break

                                        @case('other')
                                            Other Issue
                                        @break

                                        @default
                                            {{ $order->issue_type }}
                                    @endswitch
                                </p>
                                @if ($order->technician_report)
                                    <p style="margin-top: 12px;">
                                        <strong>Details:</strong><br>{{ $order->technician_report }}</p>
                                @endif
                                @if ($order->issue_reported_at)
                                    <p style="margin-top: 10px; font-size: 13px; opacity: 0.8;">
                                        📅 Reported at: {{ $order->issue_reported_at->format('d M Y, h:i A') }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        <!-- Cancellation Report -->
                        @if ($order->status == 'canceled' && $order->technician_report)
                            <div class="alert-box alert-danger">
                                <h3>❌ Cancellation Report</h3>
                                <p>{{ $order->technician_report }}</p>
                            </div>
                        @endif

                        <!-- Request Image -->
                        @if ($order->image)
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-icon">🖼️</div>
                                    <h2 class="card-title">Request Image</h2>
                                </div>
                                <img src="{{ asset($order->image) }}" alt="Request Image" class="request-image">
                            </div>
                        @endif

                        <!-- Location Map -->
                        @if ($order->latitude && $order->longitude)
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-icon">📍</div>
                                    <h2 class="card-title">Service Location</h2>
                                </div>
                                <div class="map-container">
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&hl=en&z=15&output=embed"
                                        allowfullscreen loading="lazy">
                                    </iframe>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column -->
                    <div>
                        <!-- Client Information Card -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">👤</div>
                                <h2 class="card-title">Client Information</h2>
                            </div>
                            <div class="person-card">
                                <div class="person-header">
                                    <img src="https://ui-avatars.com/api/?name={{ $order->client->user->name }}&background=10b981&color=fff"
                                        alt="{{ $order->client->user->name }}" class="person-avatar">
                                    <div class="person-info">
                                        <h3>{{ $order->client->user->name }}</h3>
                                        <span class="person-role">Client</span>
                                    </div>
                                </div>
                                <div class="person-details">
                                    <div class="person-detail">
                                        <div class="person-detail-icon">📧</div>
                                        <span>{{ $order->client->user->email }}</span>
                                    </div>
                                    @if ($order->client->user->phone)
                                        <div class="person-detail">
                                            <div class="person-detail-icon">📱</div>
                                            <span>{{ $order->client->user->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Technician Information Card -->
                        @if ($order->technician)
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-icon">🔧</div>
                                    <h2 class="card-title">Technician Information</h2>
                                </div>
                                <div class="person-card">
                                    <div class="person-header">
                                        <img src="https://ui-avatars.com/api/?name={{ $order->technician->user->name }}&background=2563eb&color=fff"
                                            alt="{{ $order->technician->user->name }}" class="person-avatar">
                                        <div class="person-info">
                                            <h3>{{ $order->technician->user->name }}</h3>
                                            <span class="person-role">Assigned Technician</span>
                                        </div>
                                    </div>
                                    <div class="person-details">
                                        <div class="person-detail">
                                            <div class="person-detail-icon">📧</div>
                                            <span>{{ $order->technician->user->email }}</span>
                                        </div>
                                        @if ($order->technician->user->phone)
                                            <div class="person-detail">
                                                <div class="person-detail-icon">📱</div>
                                                <span>{{ $order->technician->user->phone }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Service Timeline -->
                        <div class="card">
                            <div class="card-header">
                                <div class="card-icon">📊</div>
                                <h2 class="card-title">Service Timeline</h2>
                            </div>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-icon">📝</div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Request Created</div>
                                        <div class="timeline-date">{{ $order->created_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                </div>

                                @if ($order->technician)
                                    <div class="timeline-item">
                                        <div class="timeline-icon">👤</div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Technician Assigned</div>
                                            <div class="timeline-date">{{ $order->updated_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($order->status == 'in_progress' || $order->status == 'completed')
                                    <div class="timeline-item">
                                        <div class="timeline-icon">🔄</div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Work In Progress</div>
                                            <div class="timeline-date">{{ $order->updated_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($order->repair_cost)
                                    <div class="timeline-item">
                                        <div class="timeline-icon">🔍</div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Inspection Report Submitted</div>
                                            <div class="timeline-date">{{ $order->updated_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($order->payment_status == 'paid')
                                    <div class="timeline-item">
                                        <div class="timeline-icon">💳</div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Payment Completed</div>
                                            <div class="timeline-date">{{ $order->updated_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($order->completed_at)
                                    <div class="timeline-item">
                                        <div class="timeline-icon">✅</div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Service Completed</div>
                                            <div class="timeline-date">{{ $order->completed_at->format('d M Y, h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-icon">⚙️</div>
                        <h2 class="card-title">Actions</h2>
                    </div>

                    <div class="action-buttons">
                        @if ($order->status == 'issue_reported')
                            <form action="{{ route('admin_service_request.update_status', $order->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">
                                    📅 Reschedule Request
                                </button>
                            </form>
                        @endif

                        @if ($order->status != 'completed' && $order->status != 'canceled')
                            <button
                                onclick="if(confirm('Are you sure you want to cancel this request?')) document.getElementById('cancel-form').submit();"
                                class="btn btn-danger">
                                ❌ Cancel Request
                            </button>
                            <form id="cancel-form" action="" method="POST" style="display: none;">
                                @csrf
                                @method('PUT')
                            </form>
                        @endif

                        <a href="{{ route('admin_service_request.index') }}" class="btn btn-secondary">
                            ← Back to All Requests
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        // Print functionality
        window.addEventListener('beforeprint', function() {
            const topbar = document.querySelector('.topbar');
            const sidebar = document.querySelector('.sidebar');
            const actionButtons = document.querySelector('.action-buttons');

            if (topbar) topbar.style.display = 'none';
            if (sidebar) sidebar.style.display = 'none';
            if (actionButtons) actionButtons.style.display = 'none';
        });

        window.addEventListener('afterprint', function() {
            const topbar = document.querySelector('.topbar');
            const sidebar = document.querySelector('.sidebar');
            const actionButtons = document.querySelector('.action-buttons');

            if (topbar) topbar.style.display = 'flex';
            if (sidebar) sidebar.style.display = 'block';
            if (actionButtons) actionButtons.style.display = 'flex';
        });

        // Image lightbox on click
        document.querySelectorAll('.request-image').forEach(img => {
            img.addEventListener('click', function() {
                const lightbox = document.createElement('div');
                lightbox.style.cssText =
                    'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);display:flex;align-items:center;justify-content:center;z-index:10000;cursor:pointer;';
                const imgClone = this.cloneNode();
                imgClone.style.cssText =
                    'max-width:90%;max-height:90%;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.5);';
                lightbox.appendChild(imgClone);
                lightbox.addEventListener('click', () => lightbox.remove());
                document.body.appendChild(lightbox);
            });
        });
    </script>
@endsection
