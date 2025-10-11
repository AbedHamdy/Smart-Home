<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">🏠</div>
        <h2 class="logo-text">Smart Home</h2>
    </div>

    <nav class="sidebar-nav">
        @if (auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin_dashboard') }}"
                class="nav-item {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.client') }}"
                class="nav-item {{ request()->routeIs('admin.client') ? 'active' : '' }}">
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

            <a href="{{ route('category.index') }}"
                class="nav-item {{ request()->routeIs('category*') ? 'active' : '' }}">
                <span class="nav-icon">🏷️</span>
                <span>Categories</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">💰</span>
                <span>Payments</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">⭐</span>
                <span>Reviews</span>
            </a>
            <a href="#" class="nav-item">
                <span class="nav-icon">⚙️</span>
                <span>Settings</span>
            </a>
        @endif

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

            <a href="#" class="nav-item">
                <span class="nav-icon">🔔</span>
                <span>Notifications</span>
            </a>

            <a href="{{ route("client_profile") }}"
                class="nav-item {{ request()->routeIs('client_profile') ? 'active' : '' }}">
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
