@extends("layouts.app")
@section('title', 'My Service Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .requests-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .requests-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .requests-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            background: white;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            border-color: var(--primary-light);
            color: var(--primary-light);
        }

        .filter-btn.active {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            color: white;
            border-color: var(--primary-light);
        }

        .requests-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .requests-table thead {
            background: var(--background);
        }

        .requests-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .requests-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .requests-table tbody tr {
            transition: background 0.3s ease;
        }

        .requests-table tbody tr:hover {
            background: var(--background);
        }

        .request-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--border);
        }

        .no-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            border: 2px solid var(--border);
        }

        .request-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .request-category {
            font-size: 12px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .request-address {
            font-size: 12px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .client-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--border);
        }

        .client-details {
            display: flex;
            flex-direction: column;
        }

        .client-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 13px;
        }

        .client-label {
            font-size: 11px;
            color: var(--text-secondary);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: #FFF3E0;
            color: #E65100;
        }

        .status-assigned {
            background: #E3F2FD;
            color: #1565C0;
        }

        .status-in_progress {
            background: #F3E5F5;
            color: #6A1B9A;
        }

        .status-completed {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .status-canceled {
            background: #FFEBEE;
            color: #C62828;
        }

        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .empty-text {
            color: var(--text-secondary);
            margin-bottom: 25px;
        }

        .pagination-wrapper {
            margin-top: 25px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .requests-table {
                display: block;
                overflow-x: auto;
            }

            .filter-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .requests-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar_admin')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title">My Service Requests</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Technician">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <!-- Requests Container -->
            <div class="requests-container">
                <div class="requests-header">
                    <h2>🔧 My Assigned Jobs</h2>
                </div>

                <!-- Filter Section -->
                <div class="filter-section">
                    <span class="filter-label">Filter by Status:</span>
                    <div class="filter-buttons">
                        <button class="filter-btn {{ request('status') == '' ? 'active' : '' }}"
                                onclick="filterByStatus('')">
                            All
                        </button>
                        <button class="filter-btn {{ request('status') == 'pending' ? 'active' : '' }}"
                                onclick="filterByStatus('pending')">
                            Pending
                        </button>
                        <button class="filter-btn {{ request('status') == 'assigned' ? 'active' : '' }}"
                                onclick="filterByStatus('assigned')">
                            Assigned
                        </button>
                        <button class="filter-btn {{ request('status') == 'in_progress' ? 'active' : '' }}"
                                onclick="filterByStatus('in_progress')">
                            In Progress
                        </button>
                        <button class="filter-btn {{ request('status') == 'completed' ? 'active' : '' }}"
                                onclick="filterByStatus('completed')">
                            Completed
                        </button>
                        <button class="filter-btn {{ request('status') == 'canceled' ? 'active' : '' }}"
                                onclick="filterByStatus('canceled')">
                            Canceled
                        </button>
                    </div>
                </div>

                @if($serviceRequests->count() > 0)
                    <!-- Requests Table -->
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title & Category</th>
                                <th>Client</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($serviceRequests as $request)
                                <tr>
                                    <td>
                                        @if($request->image)
                                            <img src="{{ asset($request->image) }}"
                                                alt="Request Image"
                                                class="request-image">
                                        @else
                                            <div class="no-image">🔧</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="request-title">{{ $request->title }}</div>
                                        <div class="request-category">
                                            📂 {{ $request->category->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="client-info">
                                            <img src="https://ui-avatars.com/api/?name={{ $request->client->user->name }}&background=random&color=fff"
                                                 alt="{{ $request->client->user->name }}"
                                                 class="client-avatar">
                                            <div class="client-details">
                                                <span class="client-name">{{ $request->client->user->name }}</span>
                                                <span class="client-label">Client</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="request-address">
                                            📍 {{ Str::limit($request->address ?? 'No address', 30) }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $request->status }}">
                                            @switch($request->status)
                                                @case('pending')
                                                    ⏳ Pending
                                                    @break
                                                @case('assigned')
                                                    👤 Assigned
                                                    @break
                                                @case('in_progress')
                                                    🔄 In Progress
                                                    @break
                                                @case('completed')
                                                    ✅ Completed
                                                    @break
                                                @case('canceled')
                                                    ❌ Canceled
                                                    @break
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size: 13px; color: var(--text-secondary);">
                                            {{ $request->created_at->format('M d, Y') }}<br>
                                            <small style="font-size: 11px;">{{ $request->created_at->format('h:i A') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <a href=""
                                           class="action-btn">
                                            👁️ View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $serviceRequests->appends(['status' => request('status')])->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3 class="empty-title">No Service Requests Found</h3>
                        <p class="empty-text">
                            @if(request('status'))
                                No requests with status "{{ request('status') }}" found.
                            @else
                                You don't have any assigned service requests yet.
                            @endif
                        </p>
                    </div>
                @endif
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

        // Filter by Status
        function filterByStatus(status) {
            const url = new URL(window.location.href);
            if (status) {
                url.searchParams.set('status', status);
            } else {
                url.searchParams.delete('status');
            }
            window.location.href = url.toString();
        }
    </script>
@endsection
