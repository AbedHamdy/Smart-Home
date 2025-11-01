@extends("layouts.app")
@section('title', 'My Ratings & Reviews')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .ratings-section {
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .ratings-header {
            background: linear-gradient(135deg, #050f96 0%, #2aaaff 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 238, 255, 0.329);
        }

        .ratings-header h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
            font-weight: 700;
        }

        .ratings-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .stat-info h3 {
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: 700;
        }

        .stat-info p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .ratings-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .ratings-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            transition: all 0.3s;
        }

        .filter-btn:hover {
            border-color: #1441bd;
            color: #1441bd;
        }

        .filter-btn.active {
            background: #033fc0;
            border-color: #033fc0;
            color: white;
        }

        .rating-card {
            background: white;
            border: 2px solid #f1f5f9;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .rating-card:hover {
            border-color: #1441bd;
            box-shadow: 0 8px 25px rgba(5, 63, 150, 0.15);
            transform: translateY(-2px);
        }

        .rating-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 20px;
        }

        .client-info {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
        }

        .client-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            border: 3px solid #d1e7ff;
        }

        .client-details h4 {
            margin: 0 0 5px 0;
            font-size: 17px;
            font-weight: 600;
            color: #1e293b;
        }

        .service-type {
            display: inline-block;
            padding: 4px 12px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .rating-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
            border-radius: 12px;
            font-size: 20px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .stars {
            display: flex;
            gap: 3px;
            font-size: 20px;
        }

        .star {
            color: #fbbf24;
        }

        .star.empty {
            color: #e5e7eb;
        }

        .rating-comment {
            background: #f8fafc;
            border-left: 4px solid #051eff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .rating-comment p {
            margin: 0;
            color: #475569;
            font-size: 15px;
            line-height: 1.6;
        }

        .rating-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            flex-wrap: wrap;
            gap: 10px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
        }

        .meta-item strong {
            color: #1e293b;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 24px;
            color: #64748b;
            margin: 0 0 10px 0;
        }

        .empty-state p {
            color: #94a3b8;
            font-size: 16px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .ratings-header {
                padding: 30px 20px;
            }

            .ratings-header h1 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .rating-card-header {
                flex-direction: column;
            }

            .rating-badge {
                align-self: flex-start;
            }

            .ratings-filter {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-buttons {
                width: 100%;
            }

            .filter-btn {
                flex: 1;
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
                <h1 class="page-title">Ratings & Reviews</h1>
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

        <section class="ratings-section">
            <!-- Ratings Header -->
            <div class="ratings-header">
                <h1>⭐ My Ratings & Reviews</h1>
                <p>View all feedback and ratings from your clients</p>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-info">
                            <h3>{{ $totalReview }}</h3>
                            <p>Total Reviews</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-info">
                            <h3>{{ $technician->rating }}</h3>
                            <p>Average Rating</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">🌟</div>
                        <div class="stat-info">
                            <h3>{{ $positiveReviews }}</h3>
                            <p>Positive Reviews</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ratings Container -->
            <div class="ratings-container">
                <div class="ratings-filter">
                    <h2 class="filter-title">All Reviews ({{ $rating->total() }})</h2>

                    <div class="filter-buttons">
                        <button class="filter-btn active" onclick="filterRatings('all')">All</button>
                        <button class="filter-btn" onclick="filterRatings('5')">⭐ 5 Stars</button>
                        <button class="filter-btn" onclick="filterRatings('4')">⭐ 4 Stars</button>
                        <button class="filter-btn" onclick="filterRatings('3')">⭐ 3 Stars</button>
                        <button class="filter-btn" onclick="filterRatings('low')">⭐ Low</button>
                    </div>
                </div>

                @if($rating->count() > 0)
                    @php
                        $num = 1;
                    @endphp
                    @foreach($rating as $review)
                        <div class="rating-card" data-rating="{{ $review->rating }}">
                            <div class="rating-card-header">
                                <div class="client-info">
                                    <img src="https://ui-avatars.com/api/?name={{ $review->client->user->name ?? 'Client' }}&background=2563eb&color=fff"
                                         alt="Client"
                                         class="client-avatar">
                                    <div class="client-details">
                                        <h4>{{ $review->client->user->name ?? 'Anonymous Client' }}</h4>
                                        <span class="service-type">
                                            🔧 {{ $review->serviceRequest->title ?? 'Service Request #' . $num++ }}
                                        </span>
                                    </div>
                                </div>

                                <div class="rating-badge">
                                    <span>{{ $review->rating }}</span>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">⭐</span>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            @if($review->comment)
                                <div class="rating-comment">
                                    <p>"{{ $review->comment }}"</p>
                                </div>
                            @endif

                            <div class="rating-meta">
                                <div class="meta-item">
                                    📅 <strong>Date:</strong> {{ $review->created_at->format('d M Y') }}
                                </div>
                                <div class="meta-item">
                                    🕒 <strong>Time:</strong> {{ $review->created_at->format('h:i A') }}
                                </div>
                                {{-- <div class="meta-item">
                                    📋 <strong>Request ID:</strong> #{{ $review->service_request_id }}
                                </div> --}}
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $rating->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">⭐</div>
                        <h3>No Ratings Yet</h3>
                        <p>You haven't received any ratings from clients yet. Complete more service requests to start receiving feedback!</p>
                    </div>
                @endif
            </div>
        </section>
    </main>
</div>
@endsection

@section('scripts')
    <script>
        // Filter ratings by star count
        function filterRatings(filter) {
            const cards = document.querySelectorAll('.rating-card');
            const buttons = document.querySelectorAll('.filter-btn');

            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            cards.forEach(card => {
                const rating = parseInt(card.getAttribute('data-rating'));

                if (filter === 'all') {
                    card.style.display = 'block';
                } else if (filter === 'low') {
                    card.style.display = rating <= 2 ? 'block' : 'none';
                } else {
                    card.style.display = rating === parseInt(filter) ? 'block' : 'none';
                }
            });
        }

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.rating-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            observer.observe(card);
        });
    </script>
@endsection
