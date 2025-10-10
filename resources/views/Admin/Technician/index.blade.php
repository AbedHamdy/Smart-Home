{{-- @php
    use Carbon\Carbon;
@endphp --}}
@extends('layouts.app')
@section('title', 'Technician Management')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .add-btn {
            background: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            margin-left: 15px;
            transition: background-color 0.3s;
        }

        .add-btn:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }

        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .filter-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .filter-btn {
            padding: 10px 25px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
        }

        .filter-btn:hover {
            background: #5568d3;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .availability-badge {
            padding: 4px 10px;
            border-radius: 12px;
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

        .verified-badge {
            background: #d4edda;
            color: #155724;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .not-verified-badge {
            background: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .rating-cell {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rating-stars {
            color: #ffc107;
            font-size: 14px;
        }

        .category-badge {
            background: #e7f3ff;
            color: #0066cc;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
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
                    <h1 class="page-title">Technician Management</h1>
                    <a href="{{ route('technician.create') }}" class="add-btn">Add Technician</a>
                </div>
                <div class="topbar-right">
                    <form action="{{ route('admin.technician') }}" method="GET" class="search-box" id="searchForm">
                        <input type="text" name="search" id="searchInput" placeholder="Search technicians..."
                               value="{{ request('search') }}">
                        <span class="search-icon">🔍</span>

                        <!-- Preserve other filters when searching -->
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('availability'))
                            <input type="hidden" name="availability" value="{{ request('availability') }}">
                        @endif
                        @if(request('rating'))
                            <input type="hidden" name="rating" value="{{ request('rating') }}">
                        @endif
                    </form>
                    @include('layouts.notification')
                </div>
            </header>

            @include('layouts.message_admin')

            <!-- Statistics Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-value">{{ $technicians->total() }}</div>
                    <div class="stat-label">Total Technicians</div>
                </div>
                <div class="stat-card green">
                    <div class="stat-value">{{ $technicians->where('availability_status', 'available')->count() }}</div>
                    <div class="stat-label">Available Now</div>
                </div>
                <div class="stat-card blue">
                    <div class="stat-value">{{ number_format($technicians->avg('rating'), 1) }}</div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <form action="{{ route('admin.technician') }}" method="GET">
                    <!-- Preserve search term when filtering -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div class="filter-row">
                        <div class="filter-group">
                            <label>Category</label>
                            <select name="category" id="categoryFilter">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Availability</label>
                            <select name="availability" id="availabilityFilter">
                                <option value="">All Status</option>
                                <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="busy" {{ request('availability') == 'busy' ? 'selected' : '' }}>Busy</option>
                                <option value="offline" {{ request('availability') == 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label>Min Rating</label>
                            <select name="rating" id="ratingFilter">
                                <option value="">All Ratings</option>
                                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2+ Stars</option>
                            </select>
                        </div>
                        <button type="submit" class="filter-btn">Apply Filters</button>
                    </div>
                </form>
            </div>

            <!-- Technicians Table -->
            <div class="table-responsive">
                <table class="client-table">
                    <thead>
                        <tr>
                            <th>Technician</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Category</th>
                            <th>Experience</th>
                            <th>Rating</th>
                            <th>Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($technicians as $technician)
                            <tr>
                                <td class="client-info-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($technician->user->name) }}&background=667eea&color=fff&size=32"
                                        alt="{{ $technician->user->name }}" class="client-avatar-small">
                                    {{ $technician->user->name }}
                                </td>
                                <td>{{ $technician->user->email }}</td>
                                <td>{{ $technician->user->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="category-badge">
                                        {{ $technician->category->name }}
                                    </span>
                                </td>
                                <td>{{ $technician->experience_years }} years</td>
                                <td>
                                    <div class="rating-cell">
                                        <span class="rating-stars">⭐</span>
                                        <span>{{ number_format($technician->rating, 1) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="availability-badge availability-{{ $technician->availability_status }}">
                                        {{ ucfirst($technician->availability_status) }}
                                    </span>
                                </td>
                                <td class="action-cell">
                                    <a href="{{ route('technician.show', $technician->id) }}"
                                       class="table-action-btn view"
                                       title="View Details">
                                        <span>👁️</span>
                                    </a>
                                    <form action="{{ route('technician.destroy', $technician->id) }}"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirm('Are you sure you want to delete this technician?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action-btn delete" title="Delete Technician">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" style="text-align: center; padding: 40px; color: #6c757d;">
                                    No technicians found. Try adjusting your filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $technicians->appends(request()->query())->links() }}
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        // Toggle Sidebar
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // Search functionality with debounce
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        if (searchInput && searchForm) {
            let debounceTimer;

            searchInput.addEventListener('input', function(e) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    searchForm.submit();
                }, 500); // Wait 500ms after user stops typing
            });
        }
    </script>
@endsection
