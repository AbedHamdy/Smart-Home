@extends('layouts.app')
@section('title', 'Category Management')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .categories-container {
            padding: 20px;
            max-width: 1600px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 30px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
        }

        .page-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .add-btn {
            background: white;
            color: #667eea;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .add-btn:hover {
            background: #f8f9fa;
            color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .category-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }

        .category-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 25px;
            color: white;
            position: relative;
        }

        .category-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .category-name {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .category-price {
            font-size: 18px;
            opacity: 0.95;
            font-weight: 600;
        }

        .category-body {
            padding: 25px;
        }

        .category-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .mini-stat {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .mini-stat-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .mini-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .mini-stat-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
        }

        .rating-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .rating-stars {
            font-size: 20px;
            color: #f39c12;
        }

        .rating-value {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
        }

        .category-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-top: 2px solid #f1f3f5;
            margin-bottom: 15px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #6c757d;
        }

        .category-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background: linear-gradient(135deg, #2980b9, #21618c);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .empty-state-icon {
            font-size: 80px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 18px;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            list-style: none;
            gap: 8px;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination a, .pagination span {
            display: block;
            padding: 12px 18px;
            border-radius: 10px;
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            border: 2px solid #e9ecef;
            background: white;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
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

        @media (max-width: 768px) {
            .categories-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .category-stats {
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
                    <h1 class="page-title">Category Management</h1>
                </div>
                <div class="topbar-right">
                    @include('layouts.notification')
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="categories-container">
                <!-- Page Header with Add Button -->
                <div class="page-header">
                    <h2>🏷️ Service Categories</h2>
                    <a href="{{ route('category.create') }}" class="add-btn">
                        ➕ Add New Category
                    </a>
                </div>

                <!-- Statistics Overview -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">📊</div>
                        <div class="stat-value">{{ $categories->total() }}</div>
                        <div class="stat-label">Total Categories</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">👨‍🔧</div>
                        <div class="stat-value">{{ $categories->sum('technicians_count') }}</div>
                        <div class="stat-label">Total Technicians</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-value">{{ number_format($categories->where('average_rating', '>', 0)->avg('average_rating'), 1) }}</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">✅</div>
                        <div class="stat-value">{{ $categories->where('technicians_count', '>', 0)->count() }}</div>
                        <div class="stat-label">Active Categories</div>
                    </div>
                </div>

                <!-- Categories Grid -->
                @if($categories->count() > 0)
                    <div class="categories-grid">
                        @foreach($categories as $category)
                            <div class="category-card">
                                <!-- Category Header -->
                                <div class="category-header">
                                    {{-- <div class="category-icon">
                                        {{ mb_substr($category->name, 0, 1) }}
                                    </div> --}}
                                    <h3 class="category-name">{{ $category->name }}</h3>
                                    <div class="category-price">💰 {{ number_format($category->price, 2) }} EGP</div>
                                </div>

                                <!-- Category Body -->
                                <div class="category-body">
                                    <!-- Statistics -->
                                    <div class="category-stats">
                                        <div class="mini-stat">
                                            <div class="mini-stat-icon">👨‍🔧</div>
                                            <div class="mini-stat-value">{{ $category->technicians_count }}</div>
                                            <div class="mini-stat-label">Technicians</div>
                                        </div>
                                        <div class="mini-stat">
                                            <div class="mini-stat-icon">📅</div>
                                            <div class="mini-stat-value">{{ $category->created_at->format('M Y') }}</div>
                                            <div class="mini-stat-label">Created</div>
                                        </div>
                                    </div>

                                    <!-- Rating Display -->
                                    <div class="rating-display">
                                        <div class="rating-stars">
                                            @if($category->average_rating > 0)
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($category->average_rating))
                                                        ⭐
                                                    @elseif($i - 0.5 <= $category->average_rating)
                                                        ⭐
                                                    @else
                                                        ☆
                                                    @endif
                                                @endfor
                                            @else
                                                ☆☆☆☆☆
                                            @endif
                                        </div>
                                        <div class="rating-value">
                                            {{ $category->average_rating > 0 ? number_format($category->average_rating, 1) : 'N/A' }}
                                        </div>
                                    </div>

                                    <!-- Meta Information -->
                                    <div class="category-meta">
                                        <div class="meta-item">
                                            📅 {{ $category->created_at->diffForHumans() }}
                                        </div>
                                        <div class="meta-item">
                                            🔄 {{ $category->updated_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="category-actions">
                                        <a href="{{ route('category.edit', $category->id) }}" class="action-btn btn-edit">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="flex: 1;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-delete" style="width: 100%;"
                                                onclick="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $categories->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <div class="empty-state-text">No categories found. Start by adding your first category!</div>
                        <a href="{{ route('category.create') }}" class="add-btn">
                            ➕ Add First Category
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

        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        }
    </script>
@endsection --}}
