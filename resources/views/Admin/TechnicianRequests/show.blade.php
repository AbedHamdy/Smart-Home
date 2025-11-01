@extends('layouts.app')
@section('title', 'Technician Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --neutral-gradient: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.12);
            --radius-lg: 20px;
            --radius-md: 12px;
            --radius-sm: 8px;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* Make page header responsive to sidebar */
        .sidebar.collapsed ~ .main-content .page-header {
            margin-left: 0;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .page-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .page-header-icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            border: 3px solid rgba(255,255,255,0.3);
        }

        .page-header-text h1 {
            color: white;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
        }

        .page-header-text p {
            color: rgba(255,255,255,0.9);
            font-size: 0.95rem;
            margin: 0;
        }

        .details-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        /* Dynamic width based on sidebar state */
        .sidebar.collapsed ~ .main-content .details-container {
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        }

        .detail-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .detail-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0;
            background: var(--primary-gradient);
            transition: height 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .detail-card:hover::before {
            height: 100%;
        }

        .detail-card.full-width {
            grid-column: 1 / -1;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .card-header .icon {
            font-size: 1.75rem;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-gradient);
            border-radius: var(--radius-md);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .card-header h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
            transition: padding-left 0.3s ease;
        }

        .detail-item:hover {
            padding-left: 0.5rem;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-label::before {
            content: '•';
            color: #667eea;
            font-size: 1.2rem;
        }

        .detail-value {
            color: #1f2937;
            font-size: 0.95rem;
            font-weight: 600;
            text-align: right;
        }

        /* Enhanced Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: capitalize;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .status-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: blink 2s ease-in-out infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }

        .status-pending::before {
            background: #f59e0b;
        }

        .status-approved {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
        }

        .status-approved::before {
            background: #10b981;
        }

        .status-rejected {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }

        .status-rejected::before {
            background: #ef4444;
        }

        /* Enhanced Skills Section */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .skill-tag {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #4338ca;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 2px solid rgba(67, 56, 202, 0.2);
            transition: all 0.3s ease;
            cursor: default;
            position: relative;
            overflow: hidden;
        }

        .skill-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s ease;
        }

        .skill-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 56, 202, 0.25);
        }

        .skill-tag:hover::before {
            left: 100%;
        }

        /* Enhanced Documents Section */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem;
            margin-top: 1rem;
        }

        .document-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
            border: 2px solid #e5e7eb;
            border-radius: var(--radius-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .document-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .document-card:hover {
            border-color: #667eea;
            transform: translateY(-4px) scale(1.02);
            box-shadow: var(--shadow-md);
        }

        .document-card:hover::before {
            opacity: 1;
        }

        .document-icon {
            font-size: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .document-info {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .document-name {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 0.25rem 0;
        }

        .document-size {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 500;
        }

        .download-btn {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
            position: relative;
            z-index: 1;
        }

        .download-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        }

        .download-btn:active {
            transform: scale(0.98);
        }

        /* Enhanced Actions Container */
        .actions-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        /* Expand actions when sidebar collapsed */
        .sidebar.collapsed ~ .main-content .actions-container {
            justify-content: flex-start;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .action-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .action-button:hover::before {
            width: 300px;
            height: 300px;
        }

        .action-button span {
            position: relative;
            z-index: 1;
            font-size: 1.2rem;
        }

        .btn-back {
            background: var(--neutral-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
        }

        .btn-approve {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-approve:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-reject {
            background: var(--danger-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-reject:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        /* Enhanced Bio Section */
        .bio-content {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 1.5rem;
            border-radius: var(--radius-md);
            color: #4b5563;
            line-height: 1.8;
            margin-top: 0.75rem;
            border-left: 4px solid #667eea;
            font-size: 0.95rem;
        }

        .no-data {
            color: #9ca3af;
            font-style: italic;
        }

        .status-info-box {
            padding: 1.5rem;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: var(--radius-md);
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-left: 4px solid #9ca3af;
        }

        .status-info-box strong {
            color: #1f2937;
            text-transform: uppercase;
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .details-container {
                grid-template-columns: 1fr;
            }

            .page-header {
                padding: 1.5rem;
            }

            .page-header-content {
                flex-direction: column;
                text-align: center;
            }

            .page-header-text h1 {
                font-size: 1.5rem;
            }

            .actions-container {
                flex-direction: column;
                padding: 1.5rem;
            }

            .action-button {
                width: 100%;
                justify-content: center;
            }

            .documents-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Optimize for larger screens when sidebar is collapsed */
        @media (min-width: 1400px) {
            .sidebar.collapsed ~ .main-content .details-container {
                grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
                gap: 2rem;
            }

            .sidebar.collapsed ~ .main-content .detail-card {
                padding: 2rem;
            }
        }

        /* Smooth transition for main content */
        .main-content {
            transition: margin-left 0.3s ease, width 0.3s ease;
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
                    <h1 class="page-title">Technician Requests</h1>
                </div>
                <div class="topbar-right">
                @include('layouts.notification')
                </div>
            </header>

            @include('layouts.message_admin')

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-header-icon">🔍</div>
                    <div class="page-header-text">
                        <h1>Technician Application Review</h1>
                        <p>Complete review of technician registration request</p>
                    </div>
                </div>
            </div>

            <div class="details-container">
                <!-- Personal Information -->
                <div class="detail-card">
                    <div class="card-header">
                        <div class="icon">👤</div>
                        <h3>Personal Information</h3>
                    </div>
                    <ul class="detail-list">
                        <li class="detail-item">
                            <span class="detail-label">Full Name</span>
                            <span class="detail-value">{{ $technicianRequest->name }}</span>
                        </li>
                        <li class="detail-item">
                            <span class="detail-label">Email Address</span>
                            <span class="detail-value">{{ $technicianRequest->email }}</span>
                        </li>
                        <li class="detail-item">
                            <span class="detail-label">Phone Number</span>
                            <span class="detail-value">{{ $technicianRequest->phone }}</span>
                        </li>
                        <li class="detail-item">
                            <span class="detail-label">Application Status</span>
                            <span class="status-badge status-{{ strtolower($technicianRequest->status) }}">
                                {{ ucfirst(strtolower($technicianRequest->status)) }}
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Professional Information -->
                <div class="detail-card">
                    <div class="card-header">
                        <div class="icon">💼</div>
                        <h3>Professional Details</h3>
                    </div>
                    <ul class="detail-list">
                        <li class="detail-item">
                            <span class="detail-label">Service Category</span>
                            <span class="detail-value">{{ $technicianRequest->category->name ?? 'N/A' }}</span>
                        </li>
                        <li class="detail-item">
                            <span class="detail-label">Years of Experience</span>
                            <span class="detail-value">{{ $technicianRequest->experience }} years</span>
                        </li>
                        <li class="detail-item">
                            <span class="detail-label">Application Date</span>
                            <span class="detail-value">{{ $technicianRequest->created_at->format('F d, Y') }}</span>
                        </li>
                        <li class="detail-item">
                            <span class="detail-label">Last Updated</span>
                            <span class="detail-value">{{ $technicianRequest->updated_at->format('F d, Y h:i A') }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Skills -->
                @if($technicianRequest->skills)
                <div class="detail-card full-width">
                    <div class="card-header">
                        <div class="icon">🛠️</div>
                        <h3>Technical Skills</h3>
                    </div>
                    <div class="skills-grid">
                        @foreach(explode(',', $technicianRequest->skills) as $skill)
                            <span class="skill-tag">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Notes -->
                @if($technicianRequest->notes)
                <div class="detail-card full-width">
                    <div class="card-header">
                        <div class="icon">📝</div>
                        <h3>Admin Notes</h3>
                    </div>
                    <div class="bio-content">
                        {{ $technicianRequest->notes }}
                    </div>
                </div>
                @endif

                <!-- Documents -->
                <div class="detail-card full-width">
                    <div class="card-header">
                        <div class="icon">📎</div>
                        <h3>Uploaded Documents</h3>
                    </div>
                    <div class="documents-grid">
                        @if($technicianRequest->cv_file)
                            <div class="document-card" onclick="window.open('{{ asset($technicianRequest->cv_file) }}', '_blank')">
                                <div class="document-icon">📄</div>
                                <div class="document-info">
                                    <h4 class="document-name">Curriculum Vitae (CV)</h4>
                                    <span class="document-size">PDF Document</span>
                                </div>
                                <button class="download-btn">Download</button>
                            </div>
                        @else
                            <div class="document-card" style="opacity: 0.6; cursor: default; border-style: dashed;">
                                <div class="document-icon">❌</div>
                                <div class="document-info">
                                    <h4 class="document-name no-data">No CV uploaded</h4>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="actions-container">
                <a href="{{ route('admin_technician_requests.index') }}" class="action-button btn-back">
                    <span>←</span> Back to Requests
                </a>

                @if(strtolower($technicianRequest->status) === 'pending')
                    <form action="{{ route('admin_technician_requests.approve', $technicianRequest->id) }}"
                          method="POST"
                          style="display: inline;"
                          onsubmit="return confirm('Are you sure you want to approve this technician application?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="action-button btn-approve">
                            <span>✓</span> Approve Request
                        </button>
                    </form>

                    <form action="{{ route('admin_technician_requests.reject', $technicianRequest->id) }}"
                          method="POST"
                          style="display: inline;"
                          onsubmit="return confirm('Are you sure you want to reject this application?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="action-button btn-reject">
                            <span>✕</span> Reject Request
                        </button>
                    </form>
                @else
                    <div class="status-info-box">
                        <span style="font-size: 1.5rem;">ℹ️</span>
                        <span>This request has already been <strong>{{ strtolower($technicianRequest->status) }}</strong>.</span>
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection
