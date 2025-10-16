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
            padding: 30px;
            border-radius: 12px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .tech-header-content {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .tech-avatar {
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

        .tech-info h2 {
            margin: 0 0 10px 0;
            font-size: 28px;
        }

        .tech-meta {
            display: flex;
            gap: 20px;
            font-size: 14px;
            opacity: 0.95;
        }

        .tech-meta span {
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

        .reviews-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .reviews-section h3 {
            margin: 0 0 25px 0;
            color: #2c3e50;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reviews-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .review-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .review-card:hover {
            transform: translateY(-5px);
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .review-client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            background: #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .review-client-info {
            flex: 1;
        }

        .review-client-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .review-date {
            font-size: 12px;
            color: #6c757d;
        }

        .review-rating {
            color: #f59e0b;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .review-comment {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.5;
        }

        .availability-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-action {
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-back {
            background: linear-gradient(135deg, #9e9e9e, #616161);
            color: white;
            text-decoration: none;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #757575, #424242);
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background: #c82333;
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

            .reviews-grid {
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
                    <h1 class="page-title">Technician Details</h1>
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
                            <span class="detail-label">Rating</span>
                            <span class="detail-value">⭐ {{ number_format($technician->rating, 1) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Availability Status</span>
                            <span class="detail-value">
                                <span class="availability-badge availability-{{ $technician->availability_status }}">
                                    {{ ucfirst($technician->availability_status) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="detail-card">
                        <h3><span>📈</span> Performance Statistics</h3>
                        <div class="detail-row">
                            <span class="detail-label">Average Response Time</span>
                            <span class="detail-value">2.5 hours</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Completion Rate</span>
                            <span class="detail-value">95%</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Client Satisfaction</span>
                            <span class="detail-value">4.8/5.0</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">On-Time Arrival</span>
                            <span class="detail-value">98%</span>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                {{-- <div class="reviews-section">
                    <h3>⭐ Client Reviews</h3>
                    <div class="reviews-grid">
                        @forelse($technician->reviews as $review)
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="review-client-avatar">
                                        {{ strtoupper(substr($review->client->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="review-client-info">
                                        <div class="review-client-name">{{ $review->client->user->name ?? 'Anonymous' }}</div>
                                        <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    @for($i = 0; $i < $review->rating; $i++)
                                        ⭐
                                    @endfor
                                </div>
                                <div class="review-comment">
                                    {{ $review->comment }}
                                </div>
                            </div>
                        @empty
                            <p style="grid-column: 1/-1; text-align: center; color: #6c757d;">
                                No reviews yet.
                            </p>
                        @endforelse
                    </div>
                </div> --}}

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
