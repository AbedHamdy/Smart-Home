@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('title', 'Client Management')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endsection

@section('content')
    <div class="dashboard-wrapper">
        @include('layouts.sidebar_admin')

        <main class="main-content">
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title">Client Management</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search clients...">
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
                            <th>Client</th>
                            <th>Email</th>
                            <th>Phone</th>
                            {{-- <th>Status</th> --}}
                            <th>Total Requests</th>
                            <th>Completed Requests</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td class="client-info-cell">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($client->user->name) }}&background=4F46E5&color=fff&size=32"
                                        alt="{{ $client->user->name }}" class="client-avatar-small">
                                    {{ $client->user->name }}
                                </td>
                                <td>{{ $client->user->email }}</td>
                                <td>{{ $client->user->phone }}</td>
                                {{-- <td>
                                    @php
                                        $lastActivity = $client->last_activity ? Carbon::parse($client->last_activity) : null;
                                        $isActive = $lastActivity && $lastActivity->greaterThanOrEqualTo(now()->subMinute());
                                        $statusClass = $isActive ? 'status-active' : 'status-inactive';
                                        $statusText = $isActive ? 'Active' : 'Inactive';
                                    @endphp

                                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td> --}}

                                <td>{{ $client->requests_count ?? 0 }}</td>
                                <td>{{ $client->completed_requests_count ?? 0 }}</td>
                                <td class="action-cell">
                                    <a href="{{ route('client.show', $client->id) }}" class="table-action-btn view"
                                        title="View Details">
                                        <span>👁️</span>
                                    </a>
                                    {{-- <a href="" class="table-action-btn edit" title="Edit Client">
                                        <span>✏️</span>
                                    </a> --}}
                                    <form action="{{ route('client.destroy', $client->id) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Are you sure you want to delete this client?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="table-action-btn delete" title="Delete Client">
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
                {{ $clients->links() }}
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

        // Delete Client Function
        function deleteClient(id) {
            if (confirm('Are you sure you want to delete this client?')) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/clients/${id}`;
                form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
