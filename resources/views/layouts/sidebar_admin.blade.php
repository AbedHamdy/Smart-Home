<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">🏠</div>
        <h2 class="logo-text">Smart Home</h2>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin_dashboard') }}" class="nav-item {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.client') }}" class="nav-item {{ request()->routeIs('admin.client') ? 'active' : '' }}">
            <span class="nav-icon">👥</span>
            <span>Clients</span>
        </a>
        <a href="{{ route("admin.technician") }}" class="nav-item {{ request()->routeIs('admin.technician') ? 'active' : '' }}">
            <span class="nav-icon">🔧</span>
            <span>Technicians</span>
        </a>
        <a href="{{ route("admin_technician_requests.index") }}" class="nav-item">
            <span class="nav-icon">🧑</span>
            <span>Technician Join Requests</span>
        </a>
        <a href="{{ route("category.index") }}" class="nav-item {{ request()->routeIs('category*') ? 'active' : '' }}">
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
