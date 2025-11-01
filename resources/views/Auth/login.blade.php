@extends('layouts.app')
@section('title', 'Login')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .bg-icon i {
            font-size: 24px;
            color: rgba(59, 130, 246, 0.5);
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            position: relative;
            overflow: hidden;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.2) 100%);
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .logo-icon:hover::after {
            transform: translateY(0);
        }

        .logo-icon i {
            font-size: 36px;
            color: white;
            transform: rotate(-45deg);
            transition: transform 0.3s ease;
        }

        .logo-icon:hover i {
            transform: rotate(0);
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-icon {
            color: #3b82f6;
            transition: transform 0.3s ease;
        }

        .input-wrapper:focus-within .input-icon {
            transform: scale(1.1);
        }

        .input-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-wrapper input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .input-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #666;
        }

        .forgot-password-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 6px;
        }

        .forgot-password {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #0056b3;
        }

        .required {
            color: red;
        }
    </style>
@endsection

@section('content')

    <div class="bg-icon icon-1"><i class="fas fa-tools"></i></div>
    <div class="bg-icon icon-2"><i class="fas fa-lightbulb"></i></div>
    <div class="bg-icon icon-3"><i class="fas fa-wrench"></i></div>
    <div class="bg-icon icon-4"><i class="fas fa-mobile-alt"></i></div>
    <div class="bg-icon icon-5"><i class="fas fa-user-cog"></i></div>
    <div class="bg-icon icon-6"><i class="fas fa-shield-alt"></i></div>

    <div class="login-container">
        {{-- Message --}}
        @if (session('error'))
            <div class="form-message error">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="form-message success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="form-message error">
                <ul class="mb-0 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-tools fa-2x" style="transform: rotate(-45deg);"></i>
            </div>
            <h2>Khedmaty</h2>
            <p class="subtitle">Maintenance Management System</p>
        </div>

        <form id="loginForm" action="{{ route('check_login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    {{-- <span class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </span> --}}
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    {{-- <span class="input-icon">
                        <i class="fas fa-lock"></i>
                    </span> --}}
                </div>
                <div class="forgot-password-wrapper">
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
            </div>


            <button type="submit" class="login-btn">LOGIN</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="{{ route('register_client') }}">Sign Up</a>
        </div>

        <div class="tech-register">
            <p class="tech-register-text">Are you a technician?</p>
            <a href="{{ route('register_technician') }}" class="tech-register-btn">
                <span><i class="fas fa-user-cog"></i></span>
                <span>Register as Technician</span>
            </a>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
@endsection
