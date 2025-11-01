@extends('layouts.app')
@section('title', 'Client Registration')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/technician.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .bg-icon i {
            font-size: 24px;
            color: rgba(59, 130, 246, 0.5);
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header-icon {
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

        .header-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent 0%, rgba(255,255,255,0.2) 100%);
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .header-icon:hover::after {
            transform: translateY(0);
        }

        .header-icon i {
            font-size: 36px;
            color: white;
            transition: transform 0.3s ease;
        }

        .header-icon:hover i {
            transform: scale(1.1);
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
            width: 100%;
        }

        .input-wrapper textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            resize: vertical;
            min-height: 100px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-wrapper textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }

        .info-text {
            font-size: 13px;
            color: #777;
            margin-top: 5px;
        }

        .required {
            color: red;
        }
    </style>
@endsection

@section('content')

    <div class="bg-icon icon-1"><i class="fas fa-home"></i></div>
    <div class="bg-icon icon-2"><i class="fas fa-lightbulb"></i></div>
    <div class="bg-icon icon-3"><i class="fas fa-tools"></i></div>
    <div class="bg-icon icon-4"><i class="fas fa-mobile-alt"></i></div>
    <div class="bg-icon icon-5"><i class="fas fa-user"></i></div>
    <div class="bg-icon icon-6"><i class="fas fa-shield-alt"></i></div>

    <div class="registration-container">
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

        <div class="header">
            <div class="header-icon">
                <i class="fas fa-user-plus fa-2x"></i>
            </div>
            <h1>Client Registration</h1>
            <p class="subtitle">Create your account to get started</p>
        </div>

        {{-- {{ route('client.register') }} --}}
        <form action="{{ route('registration_client') }}" method="POST" id="clientForm">
            @csrf

            <div class="form-row">
                <div class="input-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" placeholder="Enter your full name"
                            value="{{ old('name') }}" required>
                        <span class="input-icon">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" placeholder="your@email.com"
                            value="{{ old('email') }}" required>
                        <span class="input-icon">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="phone">Phone <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="tel" name="phone" id="phone" placeholder="+20 123 456 7890"
                            value="{{ old('phone') }}" required>
                        <span class="input-icon">
                            <i class="fas fa-phone"></i>
                        </span>
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password" placeholder="Enter password" required
                            minlength="8">
                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="input-group">
                <label for="address">Address <span class="required">*</span></label>
                <div class="input-wrapper">
                    <textarea name="address" id="address" rows="3" placeholder="Enter your full address..." required>{{ old('address') }}</textarea>
                </div>
                <p class="info-text">Provide detailed address for better service location</p>
            </div>


            <div class="input-group">
                <label class="checkbox-item flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>I agree to the <a href="#" class="text-blue-600">Terms and Conditions</a> <span
                            class="required">*</span></span>
                </label>
            </div>

            <button type="submit" class="submit-btn">CREATE ACCOUNT</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">← Already have an account? Login</a>
        </div>
    </div>

@section('scripts')
    <script>
        // File name display
        const fileInput = document.getElementById('cv_file');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const fileName = document.getElementById('fileName');
                if (this.files && this.files[0]) {
                    fileName.textContent = this.files[0].name;
                    fileName.style.display = 'block';
                } else {
                    fileName.style.display = 'none';
                }
            });
        }

        // Get current location
        const getLocationBtn = document.getElementById('getLocationBtn');
        if (getLocationBtn) {
            getLocationBtn.addEventListener('click', function() {
                if (navigator.geolocation) {
                    getLocationBtn.textContent = '⏳ Getting location...';
                    getLocationBtn.disabled = true;

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            document.getElementById('latitude').value = position.coords.latitude.toFixed(8);
                            document.getElementById('longitude').value = position.coords.longitude.toFixed(8);
                            getLocationBtn.textContent = '✅ Location Retrieved';
                            setTimeout(() => {
                                getLocationBtn.textContent = '📍 Get My Current Location';
                                getLocationBtn.disabled = false;
                            }, 2000);
                        },
                        function(error) {
                            alert('Unable to get location: ' + error.message);
                            getLocationBtn.textContent = '📍 Get My Current Location';
                            getLocationBtn.disabled = false;
                        }
                    );
                } else {
                    alert('Geolocation is not supported by your browser');
                }
            });
        }

        // Password confirmation validation
        const form = document.getElementById('clientForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmation = document.getElementById('password_confirmation').value;

                if (password !== confirmation) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    return false;
                }
            });
        }
    </script>
@endsection
@endsection
