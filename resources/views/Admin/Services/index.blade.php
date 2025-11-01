@extends('layouts.app')
@section('title', 'All Service Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .services-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }

        .page-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            background: white;
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-btn:hover {
            border-color: #033fc0;
            color: #033fc0;
            background: #f8fafc;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 20px;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-box.blue {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #3b82f6;
        }

        .stat-box.green {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #10b981;
        }

        .stat-box.orange {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            border-color: #f59e0b;
        }

        .stat-box.purple {
            background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%);
            border-color: #a855f7;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-wrapper {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: linear-gradient(135deg, #033fc0 0%, #1441bd 100%);
        }

        .data-table thead th {
            padding: 16px 20px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .data-table tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.01);
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody td {
            padding: 16px 20px;
            font-size: 14px;
            color: #475569;
            vertical-align: middle;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-cell img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }

        .user-role {
            font-size: 12px;
            color: #94a3b8;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.assigned {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-badge.in_progress {
            background: #fce7f3;
            color: #9f1239;
        }

        .status-badge.waiting_for_approval {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .status-badge.approved_for_repair {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.issue_reported {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-badge.rescheduled {
            background: #e0f2fe;
            color: #075985;
        }

        .status-badge.completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.canceled {
            background: #fecaca;
            color: #7f1d1d;
        }

        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-view {
            background: linear-gradient(135deg, #101011 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 3px 10px rgba(59, 130, 246, 0.3);
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-edit {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(16, 185, 129, 0.3);
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(239, 68, 68, 0.3);
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .actions-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .fee-badge {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 1px solid #fbbf24;
        }

        .pagination-wrapper {
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 18px;
            color: #64748b;
            font-weight: 600;
        }

        .search-filter-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #033fc0;
            box-shadow: 0 0 0 3px rgba(3, 63, 192, 0.1);
        }

        .filter-select {
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .filter-select:focus {
            outline: none;
            border-color: #033fc0;
            box-shadow: 0 0 0 3px rgba(3, 63, 192, 0.1);
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            .data-table {
                min-width: 800px;
            }

            .actions-cell {
                flex-direction: column;
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
                    <h1 class="page-title">Service Requests Management</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff"
                            alt="Admin">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="services-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h2>
                        <span>📋</span>
                        All Service Requests
                    </h2>
                    <div class="header-actions">
                        <button class="filter-btn" onclick="window.location.reload()">
                            🔄 Refresh
                        </button>
                        <button class="filter-btn" onclick="exportData()">
                            📥 Export
                        </button>
                    </div>
                </div>

                <!-- Stats Bar -->
                <div class="stats-bar">
                    <div class="stat-box blue">
                        <div class="stat-number">{{ $orders->total() }}</div>
                        <div class="stat-label">Total Requests</div>
                    </div>
                    <div class="stat-box green">
                        <div class="stat-number">{{ $orders->where('status', 'completed')->count() }}</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-box orange">
                        <div class="stat-number">{{ $orders->where('status', 'in_progress')->count() }}</div>
                        <div class="stat-label">In Progress</div>
                    </div>
                    <div class="stat-box purple">
                        <div class="stat-number">{{ $orders->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                </div>

                <!-- Search & Filter Bar -->
                <div class="search-filter-bar">
                    {{-- <input type="text" class="search-input" id="searchInput" placeholder="🔍 Search by client name, title, or ID..."> --}}
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">⏳ Pending</option>
                        <option value="assigned">👤 Assigned</option>
                        <option value="in_progress">🔄 In Progress</option>
                        <option value="waiting_for_approval">⏰ Waiting Approval</option>
                        <option value="approved_for_repair">✅ Approved</option>
                        <option value="issue_reported">⚠️ Issue Reported</option>
                        <option value="rescheduled">📅 Rescheduled</option>
                        <option value="completed">✅ Completed</option>
                        <option value="canceled">❌ Canceled</option>
                    </select>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        @foreach($orders->pluck('category')->unique()->filter() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Table -->
                <div class="table-wrapper">
                    @if($orders->count() > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>
                                        <strong style="color: #033fc0;">
                                            ID
                                        </strong>
                                    </th>
                                    <th>
                                        <strong style="color: #033fc0;">
                                            Client
                                        </strong>
                                    </th>
                                    <th>
                                        <strong style="color: #033fc0;">
                                            Title
                                        </strong>
                                    </th>
                                    <th>
                                        <strong style="color: #033fc0;">
                                            Technician
                                        </strong>
                                    </th>
                                    <th>
                                        <strong style="color: #033fc0;">
                                            Category
                                        </strong>
                                    </th>
                                    <th>
                                        <strong style="color: #033fc0;">
                                            Fee
                                        </strong>
                                    </th>
                                    <th>
                                        <strong style="color: #033fc0;">
                                            Status
                                        </strong>
                                    </th>
                                    {{-- <th>
                                        <strong style="color: #033fc0;">
                                            Created
                                        </strong>
                                    </th> --}}
                                    <th>
                                        <strong style="color: #033fc0;">
                                            Actions
                                        </strong>
                                    </th>
                                </tr>
                            </thead>
                            @php
                                $num = 1;
                            @endphp
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong style="color: #033fc0;">#{{ $num++ }}</strong>
                                        </td>
                                        <td>
                                            <div class="user-cell">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($order->client->user->name ?? 'Unknown') }}&background=2563eb&color=fff"
                                                    alt="Client">
                                                <div class="user-info">
                                                    <span class="user-name">{{ $order->client->user->name ?? 'N/A' }}</span>
                                                    <span class="user-role">Client</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ Str::limit($order->title, 30) }}</strong>
                                        </td>
                                        <td>
                                            @if($order->technician)
                                                <div class="user-cell">
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($order->technician->user->name) }}&background=10b981&color=fff"
                                                        alt="Technician">
                                                    <div class="user-info">
                                                        <span class="user-name">{{ $order->technician->user->name }}</span>
                                                        <span class="user-role">⭐ {{ number_format($order->technician->rating ?? 0, 1) }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span style="color: #94a3b8; font-style: italic;">Not Assigned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $order->category->name ?? 'N/A' }}</strong>
                                        </td>
                                        <td>
                                            @if($order->inspection_fee)
                                                <span class="fee-badge">
                                                    💰 {{ number_format($order->inspection_fee, 0) }} EGP
                                                </span>
                                            @else
                                                <span style="color: #94a3b8;">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge {{ str_replace(' ', '_', strtolower($order->status)) }}">
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
                                                        ⏰ Waiting Approval
                                                        @break
                                                    @case('approved_for_repair')
                                                        ✅ Approved
                                                        @break
                                                    @case('issue_reported')
                                                        ⚠️ Issue Reported
                                                        @break
                                                    @case('rescheduled')
                                                        📅 Rescheduled
                                                        @break
                                                    @case('completed')
                                                        ✅ Completed
                                                        @break
                                                    @case('canceled')
                                                        ❌ Canceled
                                                        @break
                                                    @default
                                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                @endswitch
                                            </span>
                                        </td>
                                        {{-- <td>
                                            <div style="font-size: 13px;">
                                                {{ $order->created_at->format('M d, Y') }}<br>
                                                <small style="color: #94a3b8;">{{ $order->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="actions-cell text-center">
                                                <a href="{{ route('admin_service_request.show', $order->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 d-inline-flex align-items-center gap-1 shadow-sm">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">📭</div>
                            <div class="empty-state-text">No service requests found</div>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $orders->links() }}
                </div>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function() {
            const status = this.value.toLowerCase();
            const rows = document.querySelectorAll('.data-table tbody tr');

            rows.forEach(row => {
                if (!status) {
                    row.style.display = '';
                } else {
                    const statusBadge = row.querySelector('.status-badge');
                    const rowStatus = statusBadge.className.split(' ').pop();
                    row.style.display = rowStatus === status ? '' : 'none';
                }
            });
        });

        // Export function
        function exportData() {
            alert('Export functionality will be implemented here!');
        }

        // Notification mark as read
        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            }).then(() => {
                location.reload();
            });
        }
    </script>
@endsection
