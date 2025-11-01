@extends('layouts.app')
@section('title', 'Technician Details - ' . $technician->user->name)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .tech-details-container {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .tech-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 35px;
            border-radius: 15px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .tech-header-content {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .tech-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
            color: #667eea;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            border: 4px solid rgba(255, 255, 255, 0.3);
        }

        .tech-info h2 {
            margin: 0 0 15px 0;
            font-size: 32px;
            font-weight: 700;
        }

        .tech-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            font-size: 15px;
            opacity: 0.95;
        }

        .tech-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 15px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #667eea;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 13px;
            font-weight: 500;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            transition: transform 0.3s;
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .detail-card h3 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 2px solid #667eea;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
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

        .reviews-section, .service-requests-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-header h3 {
            margin: 0;
            color: #2c3e50;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .review-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 22px;
            border-radius: 12px;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .review-client-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .review-client-info {
            flex: 1;
        }

        .review-client-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 3px;
            font-size: 15px;
        }

        .review-date {
            font-size: 12px;
            color: #6c757d;
        }

        .review-rating {
            color: #f59e0b;
            font-size: 18px;
            margin-bottom: 12px;
            display: flex;
            gap: 2px;
        }

        .review-comment {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.6;
            font-style: italic;
        }

        .availability-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .availability-available {
            background: #d4edda;
            color: #155724;
        }

        .availability-busy {
            background: #fff3cd;
            color: #856404;
        }

        .availability-offline {
            background: #f8d7da;
            color: #721c24;
        }

        .requests-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .requests-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
        }

        .requests-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .requests-table tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-accepted {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-in-progress {
            background: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        /* Pagination Styles */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }

        .pagination {
            display: flex;
            list-style: none;
            gap: 5px;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination a, .pagination span {
            display: block;
            padding: 10px 15px;
            border-radius: 8px;
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            border: 2px solid #e9ecef;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination .active span {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination .disabled span {
            color: #cbd5e0;
            cursor: not-allowed;
            border-color: #e9ecef;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-action {
            padding: 14px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-back {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #5a6268, #343a40);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .tech-header-content {
                flex-direction: column;
                text-align: center;
            }

            .tech-meta {
                flex-direction: column;
                gap: 10px;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .stats-overview {
                grid-template-columns: 1fr;
            }

            .reviews-grid {
                grid-template-columns: 1fr;
            }

            .requests-table {
                font-size: 13px;
            }

            .requests-table th,
            .requests-table td {
                padding: 10px 8px;
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
                    <h1 class="page-title">Technician Details</h1>
                </div>
                <div class="topbar-right">
                    {{-- <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div> --}}
                    @include('layouts.notification')
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="tech-details-container">
                <!-- Technician Header -->
                <div class="tech-header">
                    <div class="tech-header-content">
                        <div class="tech-avatar">
                            {{ strtoupper(substr($technician->user->name, 0, 2)) }}
                        </div>
                        <div class="tech-info">
                            <h2>{{ $technician->user->name }}</h2>
                            <div class="tech-meta">
                                <span>📧 {{ $technician->user->email }}</span>
                                <span>📱 {{ $technician->user->phone ?? 'N/A' }}</span>
                                <span>🔧 {{ $technician->category->name }}</span>
                                <span>⭐ {{ number_format($technician->rating, 1) }} Rating</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Overview -->
                <div class="stats-overview">
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-value">{{ $stats['total_requests'] }}</div>
                        <div class="stat-label">Total Requests</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-value">{{ $stats['completed_requests'] }}</div>
                        <div class="stat-label">Completed Jobs</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-value">{{ $stats['total_ratings'] }}</div>
                        <div class="stat-label">Total Reviews</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🎯</div>
                        <div class="stat-value">{{ number_format($stats['average_rating'], 1) }}</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>

                <!-- Details Grid -->
                <div class="details-grid">
                    <!-- Personal Information -->
                    <div class="detail-card">
                        <h3><span>👤</span> Personal Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Full Name</span>
                            <span class="detail-value">{{ $technician->user->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email Address</span>
                            <span class="detail-value">{{ $technician->user->email }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phone Number</span>
                            <span class="detail-value">{{ $technician->user->phone ?? 'Not Provided' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Category</span>
                            <span class="detail-value">{{ $technician->category->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Experience</span>
                            <span class="detail-value">{{ $technician->experience_years }} years</span>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="detail-card">
                        <h3><span>📊</span> Account Information</h3>
                        <div class="detail-row">
                            <span class="detail-label">Member Since</span>
                            <span class="detail-value">{{ $technician->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Last Updated</span>
                            <span class="detail-value">{{ $technician->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Rating</span>
                            <span class="detail-value">⭐ {{ number_format($technician->rating, 1) }}/5.0</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Availability Status</span>
                            <span class="detail-value">
                                <span class="availability-badge availability-{{ $technician->availability_status }}">
                                    {{ ucfirst($technician->availability_status) }}
                                </span>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Account Status</span>
                            <span class="detail-value">
                                <span class="availability-badge availability-available">Active</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Service Requests Section -->
                <div class="service-requests-section">
                    <div class="section-header">
                        <h3>🔧 Service Requests History</h3>
                    </div>

                    @if($serviceRequests->count() > 0)
                        <div style="overflow-x: auto;">
                            <table class="requests-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Service Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($serviceRequests as $request)
                                        <tr>
                                            <td>{{ $loop->iteration + ($serviceRequests->currentPage() - 1) * $serviceRequests->perPage() }}</td>
                                            <td>{{ $request->client->user->name ?? 'N/A' }}</td>
                                            <td>{{ $request->service_type }}</td>
                                            <td>
                                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $request->status)) }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $request->created_at->format('M d, Y') }}</td>
                                            <td>
                                                {{ ($request->repair_cost || $request->inspection_fee) ? number_format(($request->repair_cost ?? 0) + ($request->inspection_fee ?? 0), 2) . ' EGP ' : 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination for Service Requests -->
                        <div class="pagination-wrapper">
                            {{ $serviceRequests->appends(['ratings_page' => request('ratings_page')])->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📋</div>
                            <p>No service requests found for this technician.</p>
                        </div>
                    @endif
                </div>

                <!-- Reviews Section -->
                <div class="reviews-section">
                    <div class="section-header">
                        <h3>⭐ Client Reviews ({{ $stats['total_ratings'] }})</h3>
                    </div>

                    @if($ratings->count() > 0)
                        <div class="reviews-grid">
                            @foreach($ratings as $rating)
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-client-avatar">
                                            {{ strtoupper(substr($rating->client->user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div class="review-client-info">
                                            <div class="review-client-name">{{ $rating->client->user->name ?? 'Anonymous' }}</div>
                                            <div class="review-date">{{ $rating->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="review-rating">
                                        @for($i = 0; $i < $rating->rating; $i++)
                                            ⭐
                                        @endfor
                                        <span style="color: #6c757d; font-size: 14px; margin-left: 5px;">
                                            ({{ $rating->rating }}/5)
                                        </span>
                                    </div>
                                    @if($rating->comment)
                                        <div class="review-comment">
                                            "{{ $rating->comment }}"
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination for Reviews -->
                        <div class="pagination-wrapper">
                            {{ $ratings->appends(['requests_page' => request('requests_page')])->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">💭</div>
                            <p>No reviews yet for this technician.</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.technician') }}" class="btn-action btn-back">
                        ← Back to Technicians
                    </a>
                    <form action="{{ route('technician.destroy', $technician->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete"
                                onclick="return confirm('Are you sure you want to delete this technician? This action cannot be undone.')">
                            🗑️ Delete Technician
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        // Toggle Sidebar
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');

        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }
    </script> --}}
@endsection
