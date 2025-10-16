@extends('layouts.app')
@section('title', 'Category Management')

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
                    <a href="{{ route('category.create') }}" class="add-btn">Add Category</a>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search categories...">
                        <span class="search-icon">🔍</span>
                    </div>
                    <button class="notification-btn">
                        <span>🔔</span>
                        <span class="badge">3</span>
                    </button>
                </div>
            </header>

            {{-- Message --}}
            @include('layouts.message_admin')

            <div class="table-responsive">
                <table class="client-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            {{-- <th>Description</th> --}}
                            <th>Total Technicians</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="client-info-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($category->name) }}&background=667eea&color=fff&size=32"
                                        alt="{{ $category->name }}" class="client-avatar-small">
                                    {{ $category->name }}
                                </td>
                                {{-- <td>{{ Str::limit($category->description, 80) ?: 'No description available.' }}</td> --}}
                                <td>{{ $category->technicians->count() ?? 0 }}</td>
                                <td>{{ $category->created_at->format('M d, Y') }}</td>
                                <td class="action-cell">
                                    <a href="{{ route('category.edit', $category->id) }}" class="table-action-btn edit"
                                        title="Edit Category">
                                        <span>✏️</span>
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action-btn delete" title="Delete Category">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $categories->links() }}
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
