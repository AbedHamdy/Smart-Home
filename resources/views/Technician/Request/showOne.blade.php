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

        /* Status Badge Styles - Clean & Modern */
        .status-badge {
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        /* Pending - Yellow/Amber */
        .status-badge.status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        /* Assigned - Blue */
        .status-badge.status-assigned {
            background: #E3F2FD;
            color: #1565C0;
        }

        /* In Progress - Purple */
        .status-badge.status-in_progress {
            background: #F3E5F5;
            color: #6A1B9A;
        }

        /* Waiting for Approval - Violet */
        .status-badge.status-waiting_for_approval {
            background: #F3E8FF;
            color: #6B21A8;
        }

        /* Approved for Repair - Green */
        .status-badge.status-approved_for_repair {
            background: #D1FAE5;
            color: #065F46;
        }

        /* Issue Reported - Orange */
        .status-badge.status-issue_reported {
            background: #FFF3E0;
            color: #E65100;
            animation: pulse 2s ease-in-out infinite;
        }

        /* Rescheduled - Light Blue */
        .status-badge.status-rescheduled {
            background: #E1F5FE;
            color: #01579B;
        }

        /* Completed - Green */
        .status-badge.status-completed {
            background: #E8F5E9;
            color: #2E7D32;
        }

        /* Canceled - Red */
        .status-badge.status-canceled {
            background: #FFEBEE;
            color: #C62828;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 4px 12px rgba(230, 81, 0, 0.3);
            }
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

        /* Issue Alert Banner - Very Prominent */
        .issue-alert-banner {
            background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
            border: 3px solid #FF9800;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            box-shadow: 0 4px 20px rgba(255, 152, 0, 0.3);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .issue-alert-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #FF9800;
        }

        .issue-alert-icon {
            font-size: 48px;
            animation: shake 1s ease-in-out infinite;
        }

        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
        }

        .issue-alert-title {
            flex: 1;
        }

        .issue-alert-title h3 {
            color: #E65100;
            font-size: 24px;
            margin: 0 0 5px 0;
            font-weight: 700;
        }

        .issue-alert-subtitle {
            color: #EF6C00;
            font-size: 14px;
            margin: 0;
        }

        .issue-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .issue-detail-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #FF9800;
        }

        .issue-detail-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .issue-detail-value {
            font-size: 15px;
            color: #1f2937;
            font-weight: 600;
        }

        .issue-report-text {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #FF9800;
        }

        .issue-report-text p {
            color: #4b5563;
            line-height: 1.8;
            margin: 0;
            font-size: 15px;
        }

        .status-change-section {
            background: #f9fafb;
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            border: 2px solid #e5e7eb;
        }

        .issue-report-section {
            background: #FFF8E1;
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            border: 2px solid #FFB300;
        }

        .inspection-report-section {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            border: 2px solid #4CAF50;
        }

        .awaiting-approval-section {
            background: linear-gradient(135deg, #FFF9C4 0%, #FFF59D 100%);
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
            border: 2px solid #FFC107;
        }

        .status-change-section h3,
        .issue-report-section h3,
        .inspection-report-section h3,
        .awaiting-approval-section h3 {
            color: #1f2937;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .issue-report-section h3 {
            color: #E65100;
        }

        .inspection-report-section h3 {
            color: #2E7D32;
        }

        .awaiting-approval-section h3 {
            color: #F57F17;
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group select,
        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group select:focus,
        .form-group textarea:focus,
        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
            font-family: inherit;
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

        .btn-report {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: white;
        }

        .btn-report:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .btn-inspection {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }

        .btn-inspection:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.4);
        }

        .btn-update:disabled,
        .btn-report:disabled,
        .btn-inspection:disabled {
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

        .alert-box {
            background: #FFF3E0;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #F59E0B;
        }

        .alert-box.danger {
            background: #FFEBEE;
            border-left-color: #EF4444;
        }

        .alert-box.success {
            background: #E8F5E9;
            border-left-color: #4CAF50;
        }

        .alert-info-box {
            background: #E3F2FD;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2196F3;
            color: #1565C0;
            font-size: 14px;
        }

        .description-box h3,
        .alert-box h3 {
            color: #1f2937;
            margin-bottom: 12px;
            font-size: 18px;
        }

        .alert-box h3 {
            color: #E65100;
        }

        .alert-box.danger h3 {
            color: #C62828;
        }

        .alert-box.success h3 {
            color: #2E7D32;
        }

        .description-box p,
        .alert-box p {
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

        .cost-summary-box {
            background: linear-gradient(135deg, #FFF9C4 0%, #FFECB3 100%);
            padding: 25px;
            border-radius: 12px;
            margin: 20px 0;
            border: 3px solid #FFC107;
        }

        .cost-summary-box h4 {
            color: #E65100;
            font-size: 18px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cost-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .cost-item:last-child {
            border-bottom: none;
            font-size: 18px;
            font-weight: 700;
            color: #E65100;
            padding-top: 15px;
            border-top: 2px solid #FFC107;
        }

        .cost-label {
            font-weight: 600;
        }

        .cost-value {
            font-weight: 700;
            color: #E65100;
        }

        @media (max-width: 768px) {
            .status-options {
                flex-direction: column;
            }

            .status-option {
                min-width: 100%;
            }

            .issue-details-grid {
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
                    <h1 class="page-title">Service Request Details</h1>
                </div>
                <div class="topbar-right">
                    {{-- <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div> --}}
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
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        @endswitch
                    </span>
                </div>

                {{-- ISSUE ALERT BANNER - Very Prominent --}}
                @if($order->status == 'issue_reported' && $order->issue_type)
                <div class="issue-alert-banner">
                    <div class="issue-alert-header">
                        <div class="issue-alert-icon">⚠️</div>
                        <div class="issue-alert-title">
                            <h3>🚨 Issue Reported - Waiting for Admin</h3>
                            <p class="issue-alert-subtitle">You have reported an issue with this request. Please wait for admin response.</p>
                        </div>
                    </div>

                    <div class="issue-details-grid">
                        <div class="issue-detail-box">
                            <div class="issue-detail-label">Issue Type</div>
                            <div class="issue-detail-value">
                                @switch($order->issue_type)
                                    @case('missing_parts')
                                        🔧 Missing Parts/Tools
                                        @break
                                    @case('technical_difficulty')
                                        ⚙️ Technical Difficulty
                                        @break
                                    @case('client_unavailable')
                                        👤 Client Unavailable
                                        @break
                                    @case('additional_work')
                                        📋 Additional Work Required
                                        @break
                                    @case('other')
                                        📝 Other Issue
                                        @break
                                    @default
                                        {{ $order->issue_type }}
                                @endswitch
                            </div>
                        </div>

                        @if($order->issue_reported_at)
                        <div class="issue-detail-box">
                            <div class="issue-detail-label">Reported At</div>
                            <div class="issue-detail-value">
                                📅 {{ $order->issue_reported_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                        @endif

                        <div class="issue-detail-box">
                            <div class="issue-detail-label">Current Status</div>
                            <div class="issue-detail-value" style="color: #E65100;">
                                ⏳ Waiting for Admin to Reschedule
                            </div>
                        </div>
                    </div>

                    @if($order->technician_report)
                    <div class="issue-report-text">
                        <div class="issue-detail-label">Your Report Details</div>
                        <p>{{ $order->technician_report }}</p>
                    </div>
                    @endif

                    <div class="alert-info-box" style="background: #FFF8E1; border-left-color: #FF9800; color: #EF6C00;">
                        <strong>💡 What's Next:</strong> The admin will review your issue and either reschedule the request or provide further instructions. You will be notified once a decision is made.
                    </div>
                </div>
                @endif

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

                    @if($order->inspection_fee)
                    <div class="detail-item" style="border-left-color: #FFC107;">
                        <span class="detail-label">💰 Inspection Fee</span>
                        <span class="detail-value" style="color: #E65100; font-size: 20px;">
                            {{ number_format($order->inspection_fee, 2) }} EGP
                        </span>
                    </div>
                    @endif

                    @if($order->completed_at)
                    <div class="detail-item">
                        <span class="detail-label">Completed At</span>
                        <span class="detail-value">{{ $order->completed_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                </div>

                @if($order->description)
                <div class="description-box">
                    <h3>📝 Description</h3>
                    <p>{{ $order->description }}</p>
                </div>
                @endif

                <!-- عرض تقرير المعاينة إذا كان موجود -->
                @if($order->repair_cost && $order->technician_report)
                <div class="alert-box success">
                    <h3>🔍 Inspection Report Submitted</h3>
                    <p><strong>Report:</strong><br>{{ $order->technician_report }}</p>

                    <div class="cost-summary-box" style="margin-top: 20px;">
                        <h4>💰 Cost Breakdown</h4>
                        <div class="cost-item">
                            <span class="cost-label">Inspection Fee:</span>
                            <span class="cost-value">{{ number_format($order->inspection_fee ?? 0, 2) }} EGP</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Repair Cost:</span>
                            <span class="cost-value">{{ number_format($order->repair_cost, 2) }} EGP</span>
                        </div>
                        <div class="cost-item">
                            <span class="cost-label">Total Amount:</span>
                            <span class="cost-value">{{ number_format(($order->inspection_fee ?? 0) + $order->repair_cost, 2) }} EGP</span>
                        </div>
                    </div>

                    @if($order->client_approved === null)
                    <div class="alert-info-box">
                        ⏳ <strong>Status:</strong> Waiting for client approval
                    </div>
                    @elseif($order->client_approved === 1)
                    <div class="alert-info-box" style="background: #E8F5E9; border-left-color: #4CAF50; color: #2E7D32;">
                        ✅ <strong>Approved:</strong> Client has approved the repair cost. You can proceed with the work.
                    </div>
                    @else
                    <div class="alert-info-box" style="background: #FFEBEE; border-left-color: #EF4444; color: #C62828;">
                        ❌ <strong>Rejected:</strong> Client has rejected the repair cost.
                    </div>
                    @endif
                </div>
                @endif

                @if($order->status == 'canceled' && $order->technician_report)
                <div class="alert-box danger">
                    <h3>❌ Cancellation Report</h3>
                    <p>{{ $order->technician_report }}</p>
                </div>
                @endif

                @if($order->image)
                <div>
                    <h3 style="color: #1f2937; margin-bottom: 15px;">🖼️ Request Image</h3>
                    <img src="{{ asset($order->image) }}" alt="Request Image" class="request-image">
                </div>
                @endif

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

                <!-- قسم تقديم تقرير المعاينة -->
                @if($order->status == 'in_progress' && !$order->repair_cost)
                <div class="inspection-report-section">
                    <h3>🔍 Submit Inspection Report</h3>
                    <p style="color: #2E7D32; margin-bottom: 20px; font-size: 14px;">
                        After inspecting the issue, submit your report including the estimated repair cost.
                    </p>

                    <form action="{{ route('technician_request.submit_inspection', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="inspection_report">Inspection Report <span style="color: #EF4444;">*</span></label>
                            <textarea
                                name="technician_report"
                                id="inspection_report"
                                placeholder="Describe the issue found during inspection and what needs to be repaired..."
                                required
                                style="min-height: 150px;"
                            >{{ old('technician_report') }}</textarea>
                            <small style="color: #6b7280; font-size: 12px;">Explain the problem and the required repair work</small>
                        </div>

                        <div class="form-group">
                            <label for="repair_cost">Estimated Repair Cost (EGP) <span style="color: #EF4444;">*</span></label>
                            <input
                                type="number"
                                name="repair_cost"
                                id="repair_cost"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                value="{{ old('repair_cost') }}"
                                required
                            >
                            <small style="color: #6b7280; font-size: 12px;">Enter the total cost for repair work (excluding inspection fee)</small>
                        </div>

                        <div class="alert-info-box">
                            <strong>📋 Note:</strong> After submitting this report, the client will be notified and must approve the repair cost before you can proceed with the work.
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-inspection" onclick="return confirm('Are you sure you want to submit this inspection report? The client will be notified.')">
                                📋 Submit Inspection Report
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- قسم انتظار موافقة العميل -->
                @if($order->repair_cost && $order->client_approved === null)
                <div class="awaiting-approval-section">
                    <h3>⏳ Awaiting Client Approval</h3>
                    <p style="color: #6b7280; margin-bottom: 20px;">
                        Your inspection report has been submitted. Please wait for the client to review and approve the repair cost.
                    </p>
                    <div class="alert-info-box">
                        <strong>💡 Tip:</strong> You will be notified once the client makes a decision.
                    </div>
                </div>
                @endif

                <!-- قسم بدء العمل بعد موافقة العميل -->
                @if($order->repair_cost && $order->client_approved === 1 && $order->status != 'completed')
                <div class="status-change-section" style="background: #E8F5E9; border-color: #4CAF50;">
                    <h3 style="color: #2E7D32;">✅ Client Approved - Start Repair Work</h3>
                    <p style="color: #2E7D32; margin-bottom: 20px;">
                        The client has approved the repair cost. You can now complete the repair work.
                    </p>

                    <form action="{{ route('technician_request.update_status', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-update" onclick="return confirm('Have you completed the repair work?')">
                                ✅ Mark as Completed
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Status Change Section (للحالات العادية + rescheduled) -->
                @if($order->status != 'completed' && $order->status != 'canceled' && $order->status != 'issue_reported' && !$order->repair_cost)
                <div class="status-change-section">
                    <h3>🔄 Update Request Status</h3>

                    <form action="{{ route('technician_request.update_status', $order->id) }}" method="POST" id="statusForm">
                        @csrf
                        @method('PUT')

                        <div class="status-options">
                            @if($order->status == 'assigned' || $order->status == 'rescheduled')
                            <div class="status-option">
                                <input type="radio" name="status" value="in_progress" id="status_in_progress" checked>
                                <label for="status_in_progress">
                                    <span class="status-icon">🔄</span>
                                    <span class="status-text">
                                        <span class="status-name">Start Working</span>
                                        <span class="status-desc">
                                            @if($order->status == 'rescheduled')
                                                Resume the rescheduled work
                                            @else
                                                Mark as In Progress
                                            @endif
                                        </span>
                                    </span>
                                </label>
                            </div>
                            @endif
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

                <!-- Report Issue Section -->
                @if($order->status == 'in_progress')
                <div class="issue-report-section">
                    <h3>⚠️ Report an Issue</h3>
                    <p style="color: #6b7280; margin-bottom: 20px; font-size: 14px;">
                        If you're facing any problems during the service, report them here. The admin will be notified.
                    </p>

                    <form action="{{ route('technician_request.report_issue', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="issue_type">Issue Type <span style="color: #EF4444;">*</span></label>
                            <select name="issue_type" id="issue_type" required>
                                <option value="">Select issue type...</option>
                                <option value="missing_parts">🔧 Missing Parts/Tools</option>
                                <option value="technical_difficulty">⚙️ Technical Difficulty</option>
                                <option value="client_unavailable">👤 Client Unavailable</option>
                                <option value="additional_work">📋 Additional Work Required</option>
                                <option value="other">📝 Other Issue</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="technician_report">Detailed Report <span style="color: #EF4444;">*</span></label>
                            <textarea
                                name="technician_report"
                                id="technician_report"
                                placeholder="Please describe the issue in detail..."
                                required
                            ></textarea>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-report" onclick="return confirm('Are you sure you want to report this issue? The admin will be notified.')">
                                📋 Submit Issue Report
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                @elseif($order->status == 'issue_reported')
                <div class="action-buttons" style="margin-top: 30px; padding-top: 25px; border-top: 2px solid #e5e7eb;">
                    <a href="{{ route('technician_request.myRequests') }}" class="btn btn-back">
                        ← Back to My Requests
                    </a>
                </div>

                @else
                <div class="action-buttons" style="margin-top: 30px; padding-top: 25px; border-top: 2px solid #e5e7eb;">
                    <a href="{{ route('technician_request.myRequests') }}" class="btn btn-back">
                        ← Back to My Requests
                    </a>
                </div>
                @endif
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-format repair cost input
            const repairCostInput = document.getElementById('repair_cost');
            if (repairCostInput) {
                repairCostInput.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            }

            // Highlight issue banner on page load if exists
            const issueBanner = document.querySelector('.issue-alert-banner');
            if (issueBanner) {
                // Scroll to issue banner smoothly
                setTimeout(() => {
                    issueBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 500);
            }
        });
    </script>
@endsection
