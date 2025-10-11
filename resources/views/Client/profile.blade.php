@extends("layouts.app")
@section('title', 'My Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .profile-section {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .profile-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 420px;
            text-align: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .profile-info p {
            margin: 8px 0;
            color: #333;
        }

        .btn-edit {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: #2563eb;
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-edit:hover {
            background: #1e40af;
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
                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Client">
                    <span class="user-name">{{ $user->name }}</span>
                </div>
            </div>
        </header>

        <!-- Profile Card -->
        <section class="profile-section">
            <div class="profile-card">
                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Profile Picture" class="profile-avatar">

                <h2>{{ $user->name }}</h2>
                <p class="profile-role">Client</p>

                <div class="profile-info">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
                    <p><strong>Address:</strong> {{ $client->address ?? 'Not provided' }}</p>
                    <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}</p>
                </div>

                <a href="" class="btn-edit">✏️ Edit Profile</a>
            </div>
        </section>
    </main>
</div>
@endsection
