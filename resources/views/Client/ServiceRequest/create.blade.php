@extends("layouts.app")
@section('title', 'New Service Request')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            max-width: 100%;
            margin: 0 auto;
        }

        .form-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
        }

        .form-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .form-header p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-label .required {
            color: var(--danger);
            margin-left: 4px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 4px rgba(57, 73, 171, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .location-info {
            background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
            padding: 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 10px;
        }

        .location-icon {
            font-size: 24px;
        }

        .location-text {
            flex: 1;
        }

        .location-text strong {
            display: block;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .location-text small {
            color: var(--text-secondary);
            font-size: 12px;
        }

        .location-status {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .location-status.success {
            background: var(--success);
            color: white;
        }

        .location-status.loading {
            background: var(--warning);
            color: white;
        }

        .location-status.error {
            background: var(--danger);
            color: white;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid var(--border);
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-dark) 100%);
            color: white;
            flex: 1;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 35, 126, 0.4);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: var(--background);
            color: var(--text-primary);
            padding: 14px 24px;
        }

        .btn-secondary:hover {
            background: var(--border);
        }

        .error-message {
            color: var(--danger);
            font-size: 13px;
            margin-top: 6px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .form-input.error,
        .form-select.error,
        .form-textarea.error {
            border-color: var(--danger);
        }

        .category-icon {
            font-size: 20px;
            margin-right: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar_admin')

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title">New Service Request</h1>
                </div>
                <div class="topbar-right">
                    <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div>
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff" alt="Client">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Form Container -->
            <div class="form-container">
                <div class="form-header">
                    <h2>📋 Create New Service Request</h2>
                    <p>Fill in the details below to submit your service request</p>
                </div>

                @include('layouts.message_admin')
                {{-- @if(session('success'))
                    <div class="form-message success">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="form-message error">
                        ✗ {{ session('error') }}
                    </div>
                @endif --}}

                <form action="{{ route("client.service_request.store") }}" method="POST" id="serviceRequestForm" enctype="multipart/form-data">
                    @csrf

                    <!-- Category -->
                    <div class="form-group">
                        <label class="form-label">
                            Service Category<span class="required">*</span>
                        </label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Select a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="error-message show">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div class="form-group">
                        <label class="form-label">
                            Request Title<span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-input @error('title') error @enderror"
                            placeholder="e.g., Smart Lock Installation"
                            value="{{ old('title') }}"
                            required
                        >
                        @error('title')
                            <span class="error-message show">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label class="form-label">
                            Description<span class="required">*</span>
                        </label>
                        <textarea
                            name="description"
                            id="description"
                            class="form-textarea @error('description') error @enderror"
                            placeholder="Provide detailed information about the problem..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <span class="error-message show">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label class="form-label">
                            Upload Image
                            <small class="text-muted">(Optional, attach a picture of the issue if available)</small>
                        </label>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-input @error('image') error @enderror"
                            accept="image/*"
                        >
                        @error('image')
                            <span class="error-message show">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label class="form-label">
                            Service Address<span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            name="address"
                            id="address"
                            class="form-input @error('address') error @enderror"
                            placeholder="Enter your address in detail and any distinguishing features, if applicable."
                            value="{{ old('address') }}"
                            required
                        >
                        @error('address')
                            <span class="error-message show">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Location Info -->
                    <div class="location-info">
                        <span class="location-icon">📍</span>
                        <div class="location-text">
                            <strong id="locationStatus">Detecting your location...</strong>
                            <small id="locationCoords">Please allow location access</small>
                        </div>
                        <span class="location-status loading" id="locationBadge">Pending</span>
                    </div>

                    <!-- 📌 Important Hint -->
                    <small class="text-muted" style="display:block; margin-top:5px; color:#6c757d;">
                        💡 Please make sure you are inside the apartment or at the location that needs repair.
                    </small>

                    <!-- Hidden Location Fields -->
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('client_dashboard') }}" class="btn btn-secondary">
                            ← Cancel
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                            <span>📤</span>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        // Toggle Sidebar
        // const menuToggle = document.getElementById('menuToggle');
        // const sidebar = document.querySelector('.sidebar');

        // menuToggle.addEventListener('click', () => {
        //     sidebar.classList.toggle('collapsed');
        // });

        // Add active state to nav items
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Get User Location
        function getUserLocation() {
            const locationStatus = document.getElementById('locationStatus');
            const locationCoords = document.getElementById('locationCoords');
            const locationBadge = document.getElementById('locationBadge');
            const submitBtn = document.getElementById('submitBtn');
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        // Update hidden inputs
                        latInput.value = latitude;
                        lngInput.value = longitude;

                        // Update UI
                        locationStatus.textContent = 'Location detected successfully!';
                        locationCoords.textContent = `Lat: ${latitude.toFixed(6)}, Lng: ${longitude.toFixed(6)}`;
                        locationBadge.textContent = 'Detected';
                        locationBadge.className = 'location-status success';

                        // Enable submit button
                        submitBtn.disabled = false;

                        console.log('Location:', latitude, longitude);
                    },
                    function(error) {
                        // Handle errors
                        let errorMessage = 'Unable to detect location';

                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage = 'Location access denied';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage = 'Location unavailable';
                                break;
                            case error.TIMEOUT:
                                errorMessage = 'Location request timeout';
                                break;
                        }

                        locationStatus.textContent = errorMessage;
                        locationCoords.textContent = 'Please enable location services';
                        locationBadge.textContent = 'Failed';
                        locationBadge.className = 'location-status error';

                        // Keep button disabled
                        submitBtn.disabled = true;

                        console.error('Geolocation error:', error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                locationStatus.textContent = 'Geolocation not supported';
                locationCoords.textContent = 'Your browser does not support location services';
                locationBadge.textContent = 'Error';
                locationBadge.className = 'location-status error';
                submitBtn.disabled = true;
            }
        }

        // Call on page load
        document.addEventListener('DOMContentLoaded', function() {
            getUserLocation();
        });

        // Form validation
        document.getElementById('serviceRequestForm').addEventListener('submit', function(e) {
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;

            if (!latitude || !longitude) {
                e.preventDefault();
                alert('⚠️ Location not detected! Please allow location access and try again.');
                return false;
            }
        });
    </script>
@endsection
