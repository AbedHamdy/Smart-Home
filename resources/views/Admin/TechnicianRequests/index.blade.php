@extends('layouts.app')
@section('title', 'Technician Requests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">

    <style>
        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.yellow {
            background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        }

        .stat-card.red {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        /* Table Section */
        .table-section {
            margin-top: 2rem;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 1.5rem;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
        }

        .styled-table thead {
            background: linear-gradient(90deg, #2563eb, #1e40af);
            color: #fff;
        }

        .styled-table th, .styled-table td {
            padding: 0.75rem 1rem;
            text-align: left;
        }

        .styled-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s ease;
        }

        .styled-table tbody tr:hover {
            background: #f3f4f6;
        }

        .styled-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .styled-table tbody tr:nth-child(even):hover {
            background: #f3f4f6;
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

        /* Actions */
        .actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-view {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
        }

        .btn-view:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }

        .btn-approve {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
        }

        .btn-approve:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(34, 197, 94, 0.3);
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-download {
            background: linear-gradient(135deg, #9b59b6, #8e44ad);
            color: #fff;
        }

        .btn-download:hover {
            background: linear-gradient(135deg, #8e44ad, #7d3c98);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(155, 89, 182, 0.3);
        }

        .no-data {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
                align-items: flex-start;
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
                    <h1 class="page-title">Technician Requests</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search requests...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                </div>
            </header>

            @include('layouts.message_admin')

            <!-- Statistics Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-value">{{ $technicianRequests->total() }}</div>
                    <div class="stat-label">Total Requests</div>
                </div>
            </div>

            <!-- Requests Table -->
            <div class="table-section">
                <h3 class="section-title">Technician Join Requests</h3>

                <div class="table-wrapper">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Category</th>
                                <th>Skills</th>
                                <th>Experience</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $num = ($technicianRequests->currentPage() - 1) * $technicianRequests->perPage() + 1;
                            @endphp
                            @forelse($technicianRequests as $request)
                                <tr>
                                    <td>#{{ $num++ }}</td>
                                    <td>
                                        <strong>{{ $request->name }}</strong>
                                    </td>
                                    <td>
                                        <small style="color: #6b7280;">{{ $request->email }}</small>
                                    </td>
                                    <td>{{ $request->phone }}</td>
                                    <td>
                                        <span style="background: #e0e7ff; color: #4338ca; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem;">
                                            {{ $request->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small style="color: #6b7280;">
                                            {{ Str::limit($request->skills, 25) }}
                                        </small>
                                    </td>
                                    <td>{{ $request->experience }} years</td>
                                    <td>
                                        <span class="status-badge status-{{ strtolower($request->status) }}">
                                            {{ ucfirst(strtolower($request->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small style="color: #6b7280;">
                                            {{ $request->created_at->format('M d, Y') }}
                                        </small>
                                    </td>
                                    <td class="actions">
                                        <a href="{{ route("admin_technician_requests.show" , $request->id) }}"
                                           class="btn btn-view"
                                           title="View Details">
                                            👁️ View
                                        </a>

                                        @if($request->cv_file)
                                            <a href="{{ asset( $request->cv_file) }}"
                                               target="_blank"
                                               class="btn btn-download"
                                               title="Download CV">
                                                📄 CV
                                            </a>
                                        @endif

                                        @if(strtolower($request->status) === 'pending')
                                            <div class="action-buttons">
                                                <form action="{{ route('admin_technician_requests.approve', $request->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to approve this technician?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-approve">
                                                        ✓ Approve
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin_technician_requests.reject', $request->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to reject this request?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-reject">
                                                        ✕ Reject
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="no-data">
                                        No technician requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($technicianRequests->hasPages())
                    <div style="margin-top: 1.5rem;">
                        {{ $technicianRequests->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
@endsection

{{-- @section('scripts')
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
@endsection --}}
