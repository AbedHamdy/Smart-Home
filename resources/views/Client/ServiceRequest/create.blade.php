@extends("layouts.app")
@section('title', 'New Service Request')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --warning-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --info-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
            --radius-xl: 24px;
            --radius-lg: 20px;
            --radius-md: 16px;
            --radius-sm: 12px;
        }

        /* Page Header */
        .page-header-form {
            background: var(--primary-gradient);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .page-header-form::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        .header-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .header-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .header-title {
            color: white;
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .header-subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Form Container */
        .form-container-modern {
            background: white;
            border-radius: var(--radius-xl);
            padding: 3rem;
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }

        .form-section {
            margin-bottom: 2.5rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid #f3f4f6;
        }

        .section-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            box-shadow: var(--shadow-sm);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1f2937;
            margin: 0;
            letter-spacing: -0.02em;
        }

        /* Form Groups */
        .form-group-modern {
            margin-bottom: 2rem;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-label-modern {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .label-icon {
            font-size: 1.25rem;
        }

        .required-star {
            color: #ef4444;
            font-size: 1.2rem;
        }

        .label-hint {
            display: block;
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: 500;
            margin-top: 0.25rem;
        }

        /* Input Styles */
        .form-input-modern,
        .form-select-modern,
        .form-textarea-modern {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: var(--radius-md);
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
            background: white;
        }

        .form-input-modern:focus,
        .form-select-modern:focus,
        .form-textarea-modern:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-input-modern:hover,
        .form-select-modern:hover,
        .form-textarea-modern:hover {
            border-color: #c7d2fe;
        }

        .form-textarea-modern {
            resize: vertical;
            min-height: 150px;
            line-height: 1.6;
        }

        .form-input-modern.error,
        .form-select-modern.error,
        .form-textarea-modern.error {
            border-color: #ef4444;
            background: #fef2f2;
        }

        /* File Input */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
        }

        .file-input-modern {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 2rem;
            border: 3px dashed #d1d5db;
            border-radius: var(--radius-md);
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-label:hover {
            border-color: #667eea;
            background: #eff6ff;
        }

        .file-input-icon {
            font-size: 3rem;
        }

        .file-input-text {
            text-align: center;
        }

        .file-input-text strong {
            display: block;
            font-size: 1.1rem;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .file-input-text small {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .file-preview {
            margin-top: 1rem;
            padding: 1rem;
            background: #f3f4f6;
            border-radius: var(--radius-sm);
            display: none;
            align-items: center;
            gap: 1rem;
        }

        .file-preview.show {
            display: flex;
        }

        .file-preview-icon {
            font-size: 2rem;
        }

        .file-preview-info {
            flex: 1;
        }

        .file-preview-name {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .file-preview-size {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .file-remove-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .file-remove-btn:hover {
            background: #dc2626;
            transform: scale(1.05);
        }

        /* Location Info Card */
        .location-card {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 3px solid #3b82f6;
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-top: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .location-card.loading {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-color: #f59e0b;
        }

        .location-card.error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-color: #ef4444;
        }

        .location-card.success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            border-color: #10b981;
        }

        .location-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .location-icon-big {
            font-size: 4rem;
            animation: pulse-location 2s ease-in-out infinite;
        }

        @keyframes pulse-location {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .location-info-text {
            flex: 1;
        }

        .location-status-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .location-coords-text {
            font-size: 0.95rem;
            color: #4b5563;
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        .location-badge {
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 800;
            box-shadow: var(--shadow-sm);
            animation: fadeIn 0.5s ease;
        }

        .location-badge.loading {
            background: #fbbf24;
            color: #78350f;
        }

        .location-badge.success {
            background: #10b981;
            color: white;
        }

        .location-badge.error {
            background: #ef4444;
            color: white;
        }

        .location-hint {
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(255,255,255,0.7);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #4b5563;
        }

        .location-hint-icon {
            font-size: 1.5rem;
        }

        /* Error Messages */
        .error-message-modern {
            color: #ef4444;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 0.5rem;
            display: none;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message-modern.show {
            display: flex;
        }

        .error-icon {
            font-size: 1.25rem;
        }

        /* Form Actions */
        .form-actions-modern {
            display: flex;
            gap: 1.5rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 3px solid #f3f4f6;
        }

        .btn-modern {
            padding: 1.25rem 2.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-size: 1.1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .btn-primary-modern {
            background: var(--primary-gradient);
            color: white;
            flex: 1;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-primary-modern:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
        }

        .btn-primary-modern:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary-modern {
            background: white;
            color: #4b5563;
            border: 2px solid #e5e7eb;
            padding: 1.25rem 2rem;
        }

        .btn-secondary-modern:hover {
            background: #f9fafb;
            border-color: #d1d5db;
            transform: translateY(-2px);
        }

        /* Select Custom Arrow */
        .form-select-modern {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 3rem;
        }

        /* Category Option */
        .category-option-icon {
            font-size: 1.25rem;
            margin-right: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header-form {
                padding: 2rem 1.5rem;
            }

            .header-title {
                font-size: 2rem;
            }

            .form-container-modern {
                padding: 2rem 1.5rem;
            }

            .form-actions-modern {
                flex-direction: column;
            }

            .btn-primary-modern,
            .btn-secondary-modern {
                width: 100%;
            }

            .location-content {
                flex-direction: column;
                text-align: center;
            }

            .section-header {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Smooth transitions for sidebar */
        .main-content {
            transition: margin-left 0.3s ease, width 0.3s ease;
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
                    <h1 class="page-title">New Service Request</h1>
                </div>
                <div class="topbar-right">
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=2563eb&color=fff"
                            alt="Client">
                        <span class="user-name">{{ $user->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <!-- Page Header -->
            <div class="page-header-form">
                <div class="header-content">
                    <div class="header-icon">📋</div>
                    <h1 class="header-title">Create Service Request</h1>
                    <p class="header-subtitle">Fill in the details below to submit your service request</p>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container-modern">
                <form action="{{ route("client.service_request.store") }}" method="POST" id="serviceRequestForm"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Service Details Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">🛠️</div>
                            <h2 class="section-title">Service Details</h2>
                        </div>

                        <!-- Category -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <span class="label-icon">📂</span>
                                Service Category
                                <span class="required-star">*</span>
                            </label>
                            <select name="category_id" id="category_id"
                                class="form-select-modern @error('category_id') error @enderror" required>
                                <option value="">Select a category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} — Preview: {{ number_format($category->price, 2) }} EGP
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="error-message-modern show">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <span class="label-icon">✏️</span>
                                Request Title
                                <span class="required-star">*</span>
                                <span class="label-hint">Give your request a clear, descriptive title</span>
                            </label>
                            <input type="text" name="title" id="title"
                                class="form-input-modern @error('title') error @enderror"
                                placeholder="e.g., Smart Lock Installation"
                                value="{{ old('title') }}" required>
                            @error('title')
                                <span class="error-message-modern show">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <span class="label-icon">📝</span>
                                Description
                                <span class="required-star">*</span>
                                <span class="label-hint">Provide detailed information about the problem</span>
                            </label>
                            <textarea name="description" id="description"
                                class="form-textarea-modern @error('description') error @enderror"
                                placeholder="Describe the issue in detail. Include any relevant information that will help the technician understand the problem..."
                                required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="error-message-modern show">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <span class="label-icon">📸</span>
                                Upload Image
                                <span class="label-hint">Optional - Attach a picture of the issue if available</span>
                            </label>
                            <div class="file-input-wrapper">
                                <input type="file" name="image" id="image"
                                    class="file-input-modern @error('image') error @enderror"
                                    accept="image/*">
                                <label for="image" class="file-input-label" id="fileLabel">
                                    <div class="file-input-icon">📁</div>
                                    <div class="file-input-text">
                                        <strong>Click to upload image</strong>
                                        <small>or drag and drop (PNG, JPG, JPEG - Max 5MB)</small>
                                    </div>
                                </label>
                            </div>
                            <div class="file-preview" id="filePreview">
                                <div class="file-preview-icon">🖼️</div>
                                <div class="file-preview-info">
                                    <div class="file-preview-name" id="fileName"></div>
                                    <div class="file-preview-size" id="fileSize"></div>
                                </div>
                                <button type="button" class="file-remove-btn" id="removeFile">Remove</button>
                            </div>
                            @error('image')
                                <span class="error-message-modern show">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <!-- Location Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">📍</div>
                            <h2 class="section-title">Location Information</h2>
                        </div>

                        <!-- Address -->
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <span class="label-icon">🏠</span>
                                Service Address
                                <span class="required-star">*</span>
                                <span class="label-hint">Enter your complete address with any distinguishing features</span>
                            </label>
                            <input type="text" name="address" id="address"
                                class="form-input-modern @error('address') error @enderror"
                                placeholder="Street name, building number, apartment, floor, landmarks..."
                                value="{{ old('address') }}" required>
                            @error('address')
                                <span class="error-message-modern show">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <!-- Location Detection -->
                        <div class="location-card loading" id="locationCard">
                            <div class="location-content">
                                <div class="location-icon-big" id="locationIconBig">📡</div>
                                <div class="location-info-text">
                                    <div class="location-status-text" id="locationStatus">
                                        Detecting your location...
                                    </div>
                                    <div class="location-coords-text" id="locationCoords">
                                        Please allow location access
                                    </div>
                                </div>
                                <div class="location-badge loading" id="locationBadge">
                                    <span class="spinner"></span> Detecting
                                </div>
                            </div>
                            <div class="location-hint">
                                <span class="location-hint-icon">💡</span>
                                <span>Please make sure you are at the location that needs repair to ensure accurate service delivery.</span>
                            </div>
                        </div>

                        <!-- Hidden Location Fields -->
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions-modern">
                        <a href="{{ route('client_dashboard') }}" class="btn-modern btn-secondary-modern">
                            <span>←</span> Cancel
                        </a>
                        <button type="submit" class="btn-modern btn-primary-modern" id="submitBtn" disabled>
                            <span>📤</span>
                            <span id="submitBtnText">Submit Request</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File Upload Handler
            const fileInput = document.getElementById('image');
            const fileLabel = document.getElementById('fileLabel');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const removeFileBtn = document.getElementById('removeFile');

            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    filePreview.classList.add('show');
                    fileLabel.style.display = 'none';
                }
            });

            removeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.classList.remove('show');
                fileLabel.style.display = 'flex';
            });

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            // Get User Location
            function getUserLocation() {
                const locationCard = document.getElementById('locationCard');
                const locationStatus = document.getElementById('locationStatus');
                const locationCoords = document.getElementById('locationCoords');
                const locationBadge = document.getElementById('locationBadge');
                const locationIconBig = document.getElementById('locationIconBig');
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
                            locationCard.className = 'location-card success';
                            locationIconBig.textContent = '✅';
                            locationStatus.textContent = 'Location detected successfully!';
                            locationCoords.textContent = `Lat: ${latitude.toFixed(6)}, Lng: ${longitude.toFixed(6)}`;
                            locationBadge.innerHTML = '✓ Detected';
                            locationBadge.className = 'location-badge success';

                            // Enable submit button
                            submitBtn.disabled = false;

                            console.log('Location:', latitude, longitude);
                        },
                        function(error) {
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

                            locationCard.className = 'location-card error';
                            locationIconBig.textContent = '❌';
                            locationStatus.textContent = errorMessage;
                            locationCoords.textContent = 'Please enable location services and refresh';
                            locationBadge.innerHTML = '✗ Failed';
                            locationBadge.className = 'location-badge error';

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
                    locationCard.className = 'location-card error';
                    locationIconBig.textContent = '❌';
                    locationStatus.textContent = 'Geolocation not supported';
                    locationCoords.textContent = 'Your browser does not support location services';
                    locationBadge.innerHTML = '✗ Error';
                    locationBadge.className = 'location-badge error';
                    submitBtn.disabled = true;
                }
            }

            // Call on page load
            getUserLocation();

            // Form validation
            const serviceRequestForm = document.getElementById('serviceRequestForm');
            serviceRequestForm.addEventListener('submit', function(e) {
                const latitude = document.getElementById('latitude').value;
                const longitude = document.getElementById('longitude').value;

                if (!latitude || !longitude) {
                    e.preventDefault();
                    alert('⚠️ Location not detected! Please allow location access and try again.');
                    return false;
                }

                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                const submitBtnText = document.getElementById('submitBtnText');
                submitBtn.disabled = true;
                submitBtnText.innerHTML = '<span class="spinner"></span> Submitting...';
            });

            // Notification handler
            window.markAsRead = function(notificationId) {
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                }).then(() => {
                    location.reload();
                });
            };

            // Input animations
            const inputs = document.querySelectorAll('.form-input-modern, .form-select-modern, .form-textarea-modern');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.01)';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
