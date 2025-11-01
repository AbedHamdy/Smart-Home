@extends("layouts.app")
@section('title', 'My Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .profile-section {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-header {
            background: linear-gradient(135deg, #050f96 0%, #2aaaff 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 238, 255, 0.329);
        }

        .profile-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .profile-header-info h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
            font-weight: 700;
        }

        .profile-role-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .profile-stats {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: left;
        }

        .stat-label {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 600;
        }

        .profile-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .info-card h3 {
            margin: 0 0 25px 0;
            font-size: 20px;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-card h3::before {
            content: '';
            width: 4px;
            height: 24px;
            background: #051eff;
            border-radius: 2px;
        }

        .info-row {
            display: flex;
            align-items: flex-start;
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 45px;
            height: 45px;
            background: #d1fae5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .info-details {
            flex: 1;
        }

        .info-label {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .info-value {
            font-size: 15px;
            color: #1e293b;
            font-weight: 500;
        }

        .activity-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .activity-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #f0fdf4;
            border-radius: 20px;
            color: #164ea3;
            font-size: 14px;
            font-weight: 500;
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            background: #16a34a;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-primary {
            flex: 1;
            padding: 14px 28px;
            background: #033fc0;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: #040678;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 63, 150, 0.3);
        }

        .btn-secondary {
            flex: 1;
            padding: 14px 28px;
            background: white;
            color: #1441bd;
            border: 2px solid #1441bd;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: #d1fae5;
            transform: translateY(-2px);
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 1000;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 550px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
            color: #1e293b;
            font-weight: 700;
        }

        .modal-close {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .modal-close:hover {
            background: #e2e8f0;
            color: #1e293b;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #123abd;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .btn-cancel {
            padding: 12px 24px;
            background: #f1f5f9;
            color: #64748b;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-submit {
            padding: 12px 28px;
            background: #0d339c;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #140361;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
        }

        .password-input-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #64748b;
            transition: all 0.3s;
        }

        .toggle-password:hover {
            color: #059669;
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-stats {
                justify-content: center;
            }

            .profile-content {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .modal-content {
                width: 95%;
                margin: 20px;
            }

            .modal-footer {
                flex-direction: column-reverse;
            }

            .modal-footer button {
                width: 100%;
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
                <h1 class="page-title">My Profile</h1>
            </div>
            <div class="topbar-right">
                @include('layouts.notification')
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Technician">
                    <span class="user-name">{{ $user->name }}</span>
                </div>
            </div>
        </header>

        @include('layouts.message_admin')

        <section class="profile-section">
            <!-- Profile Header -->
            <div class="profile-header">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=ffffff&color=059669&size=120"
                     alt="Profile Picture"
                     class="profile-avatar-large">

                <div class="profile-header-info">
                    <h1>{{ $user->name }}</h1>
                    <span class="profile-role-badge">🔧 Technician</span>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-label">Member Since</div>
                            <div class="stat-value">{{ $user->created_at->format('M Y') }}</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Account Status</div>
                            <div class="stat-value">✓ Active</div>
                        </div>
                        @if($technician->specialization)
                        <div class="stat-item">
                            <div class="stat-label">Specialization</div>
                            <div class="stat-value">{{ $technician->specialization }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Personal Information -->
                <div class="info-card">
                    <h3>Personal Information</h3>

                    <div class="info-row">
                        <div class="info-icon">👤</div>
                        <div class="info-details">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">✉️</div>
                        <div class="info-details">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📱</div>
                        <div class="info-details">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">{{ $user->phone ?? 'Not provided' }}</div>
                        </div>
                    </div>

                    {{-- <div class="info-row">
                        <div class="info-icon">📍</div>
                        <div class="info-details">
                            <div class="info-label">Address</div>
                            <div class="info-value">{{ $technician->address ?? 'Not provided' }}</div>
                        </div>
                    </div> --}}

                    <div class="info-row">
                        <div class="info-icon">🔧</div>
                        <div class="info-details">
                            <div class="info-label">Specialization</div>
                            <div class="info-value">{{ $technician->category->name ?? 'Not provided' }}</div>
                        </div>
                    </div>

                    {{-- <div class="info-row">
                        <div class="info-icon">💼</div>
                        <div class="info-details">
                            <div class="info-label">Experience</div>
                            <div class="info-value">{{ $technician->experience ?? 'Not provided' }}</div>
                        </div>
                    </div> --}}

                    <div class="info-row">
                        <div class="info-icon">📅</div>
                        <div class="info-details">
                            <div class="info-label">Joined Date</div>
                            <div class="info-value">{{ $user->created_at->format('d M Y - h:i A') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Activity Status -->
                <div class="activity-card">
                    <h3>Account Activity</h3>

                    <div class="info-row">
                        <div class="info-icon">⏰</div>
                        <div class="info-details">
                            <div class="info-label">Last Activity</div>
                            <div class="info-value">
                                @if($technician->last_activity)
                                    {{ \Carbon\Carbon::parse($technician->last_activity)->diffForHumans() }}
                                    <span class="activity-indicator">
                                        <span class="activity-dot"></span>
                                        Active
                                    </span>
                                @else
                                    No recent activity
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button type="button" class="btn-primary" onclick="openEditModal()">
                            ✏️ Edit Profile Information
                        </button>
                        <button type="button" class="btn-secondary" onclick="openPasswordModal()">
                            🔒 Change Password
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Edit Profile Modal -->
        <div class="modal-overlay" id="editModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>✏️ Edit Profile Information</h2>
                    <button class="modal-close" onclick="closeEditModal()">&times;</button>
                </div>
                <form action="{{ route("technician_profile.update") }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ $user->phone ?? '' }}">
                        </div>

                        {{-- <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address">{{ $technician->address ?? '' }}</textarea>
                        </div> --}}

                        {{-- <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" id="specialization" name="specialization" value="{{ $technician->specialization ?? '' }}">
                        </div> --}}

                        {{-- <div class="form-group">
                            <label for="experience">Experience</label>
                            <textarea id="experience" name="experience">{{ $technician->experience ?? '' }}</textarea>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="btn-submit">💾 Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div class="modal-overlay" id="passwordModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>🔒 Change Password</h2>
                    <button class="modal-close" onclick="closePasswordModal()">&times;</button>
                </div>
                <form action="{{ route("technician_profile.updatePassword") }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="password-input-wrapper">
                                <input type="password" id="current_password" name="current_password" required>
                                <button type="button" class="toggle-password" onclick="togglePassword('current_password')">👁️</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="password-input-wrapper">
                                <input type="password" id="new_password" name="new_password" required>
                                <button type="button" class="toggle-password" onclick="togglePassword('new_password')">👁️</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <div class="password-input-wrapper">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                                <button type="button" class="toggle-password" onclick="togglePassword('new_password_confirmation')">👁️</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-cancel" onclick="closePasswordModal()">Cancel</button>
                        <button type="submit" class="btn-submit">🔑 Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
    <script>
        // Add active state to nav items
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Edit Profile Modal Functions
        function openEditModal() {
            document.getElementById('editModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Change Password Modal Functions
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Toggle Password Visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;

            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = '🙈';
            } else {
                input.type = 'password';
                button.textContent = '👁️';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                closeEditModal();
                closePasswordModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
                closePasswordModal();
            }
        });
    </script>
@endsection
