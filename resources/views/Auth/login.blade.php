@extends('layouts.app')
@section('title', 'Login')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .input-group {
            margin-bottom: 20px;
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
            padding: 10px 40px 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
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

    <div class="bg-icon icon-1">🏠</div>
    <div class="bg-icon icon-2">💡</div>
    <div class="bg-icon icon-3">🔧</div>
    <div class="bg-icon icon-4">📱</div>
    <div class="bg-icon icon-5">🌡️</div>
    <div class="bg-icon icon-6">🔒</div>

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
            <div class="logo-icon">🏠</div>
            <h2>Smart Home</h2>
            <p class="subtitle">Maintenance Management System</p>
        </div>

        <form id="loginForm" action="{{ route('check_login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="email">Email Address <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    <span class="input-icon"></span>
                </div>
            </div>

            <div class="input-group">
                <label for="password">Password <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    <span class="input-icon"></span>
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
                <span>🔧</span>
                <span>Register as Technician</span>
            </a>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('js/common.js') }}"></script>
@endsection
@endsection
