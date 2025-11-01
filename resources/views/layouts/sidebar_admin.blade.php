<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">🏠</div>
        <h2 class="logo-text">Smart Home</h2>
    </div>

    <nav class="sidebar-nav">
        {{-- Admin --}}
        @if (auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin_dashboard') }}"
                class="nav-item {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.client') }}" class="nav-item {{ request()->routeIs('admin.client') ? 'active' : '' }}">
                <span class="nav-icon">👥</span>
                <span>Clients</span>
            </a>
            <a href="{{ route('admin.technician') }}"
                class="nav-item {{ request()->routeIs('admin.technician') ? 'active' : '' }}">
                <span class="nav-icon">🔧</span>
                <span>Technicians</span>
            </a>
            <a href="{{ route('admin_technician_requests.index') }}"
                class="nav-item {{ request()->routeIs('admin_technician_requests.*') ? 'active' : '' }}">
                <span class="nav-icon">🧑</span>
                <span>Technician Join Requests</span>
            </a>

            <a href="{{ route('category.index') }}" class="nav-item {{ request()->routeIs('category*') ? 'active' : '' }}">
                <span class="nav-icon">🏷️</span>
                <span>Categories</span>
            </a>
            <a href="{{ route("admin_service_request.index") }}" class="nav-item {{ request()->routeIs('admin_service_request.*') ? 'active' : '' }}">
                <span class="nav-icon">🧾</span>
                <span>Requests</span>
            </a>
            {{-- <a href="#" class="nav-item">
                <span class="nav-icon">⭐</span>
                <span>Reviews</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">⚙️</span>
                <span>Settings</span>
            </a> --}}
        @endif

        {{-- Client --}}
        @if (auth()->check() && auth()->user()->role === 'client')

            <a href="{{ route('client_dashboard') }}"
                class="nav-item {{ request()->routeIs('client_dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route("client.service_requests.create") }}"
                class="nav-item {{ request()->routeIs('client.service_requests.create') ? 'active' : '' }}">
                <span class="nav-icon">🛠️</span>
                <span>Request a Service</span>
            </a>

            <a href="{{ route("client.service_request.index") }}"
                class="nav-item {{ request()->routeIs('client.service_request.*') ? 'active' : '' }}">
                <span class="nav-icon">📋</span>
                <span>My Requests</span>
            </a>

            {{-- <li class="nav-item dropdown">
                <a class="nav-link" href="#" data-bs-toggle="dropdown">
                    <span class="nav-icon">🔔</span>
                    <span>Notifications</span>
                    <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <li>
                            <a class="dropdown-item" href="{{ $notification->data['url'] }}"
                                onclick="markAsRead('{{ $notification->id }}')">
                                <strong>{{ $notification->data['title'] }}</strong><br>
                                {{ $notification->data['message'] }}
                            </a>
                        </li>
                    @empty
                        <li><span class="dropdown-item">No new notifications</span></li>
                    @endforelse
                </ul>
            </li> --}}

            <a href="{{ route("client_profile.index") }}"
                class="nav-item {{ request()->routeIs('client_profile.*') ? 'active' : '' }}">
                <span class="nav-icon">👤</span>
                <span>Profile</span>
            </a>

        @endif

        {{-- Technician --}}
        @if (auth()->check() && auth()->user()->role === 'technician')
            <a href="{{ route('technician_dashboard') }}"
                class="nav-item {{ request()->routeIs('technician_dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route("technician_requests.index") }}"
                class="nav-item {{ request()->routeIs('technician_requests.*') ? 'active' : '' }}">
                <span class="nav-icon">🧾</span>
                <span>Requests</span>
            </a>
            <a href="{{ route("technician_request.myRequests") }}"
                class="nav-item {{ request()->routeIs('technician_request.myRequests') ? 'active' : '' }}">
                <span class="nav-icon">📋</span>
                <span>My Requests</span>
            </a>
            <!-- Ratings / Feedback -->
            <a href="{{ route("technician_rating.index") }}"
                class="nav-item {{ request()->routeIs('technician_rating.index') ? 'active' : '' }}">
                <span class="nav-icon">⭐</span>
                <span>Ratings</span>
            </a>
            <a href="{{ route("technician_profile.index") }}"
                class="nav-item {{ request()->routeIs('technician_profile.*') ? 'active' : '' }}">
                <span class="nav-icon">👤</span>
                <span>Profile</span>
            </a>
        @endif

    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <span class="nav-icon">🚪</span>
                <span class="logout-text">Logout</span>
            </button>
        </form>
    </div>
</aside>
