@extends('layouts.app')
@section('title', 'Technician Request Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">

    <style>
        .details-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }

        .detail-card.full-width {
            grid-column: 1 / -1;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .card-header .icon {
            font-size: 1.5rem;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
        }

        .card-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
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
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #1f2937;
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        /* Skills Section */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .skill-tag {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #4338ca;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Documents Section */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .document-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .document-card:hover {
            border-color: #667eea;
            background: #f3f4f6;
            transform: translateY(-2px);
        }

        .document-icon {
            font-size: 2rem;
        }

        .document-info {
            flex: 1;
        }

        .document-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.25rem 0;
        }

        .document-size {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .download-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .download-btn:hover {
            transform: scale(1.05);
        }

        /* Actions Container */
        .actions-container {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 1.5rem;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-back {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3);
        }

        .btn-approve {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }

        .btn-approve:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Bio Section */
        .bio-content {
            background: #f9fafb;
            padding: 1rem;
            border-radius: 10px;
            color: #4b5563;
            line-height: 1.6;
            margin-top: 0.5rem;
        }

        .no-data {
            color: #9ca3af;
            font-style: italic;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .details-container {
                grid-template-columns: 1fr;
            }

            .actions-container {
                flex-direction: column;
            }

            .action-button {
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
                    <h1 class="page-title">Technician Request Details</h1>
                </div>
                <div class="topbar-right">
                @include('layouts.notification')>
                </div>
            </header>

            @include('layouts.message_admin')

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
                            <div class="document-card" style="opacity: 0.6; cursor: default;">
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
                    <div style="padding: 1rem; background: #f3f4f6; border-radius: 10px; color: #6b7280;">
                        This request has already been <strong>{{ strtolower($technicianRequest->status) }}</strong>.
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
@endsection
