@extends('layouts.app')
@section('title', 'Add New Technician')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        .main-content {
            transition: margin-left 0.3s ease;
            width: 100%;
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            /* margin: 20px; */
            transition: all 0.3s ease;
            /* width: calc(100% - 40px); Account for margins */
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group textarea {
            min-height: 100px;
        }

        .btn-submit {
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background: #5a6fe4;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            margin-right: 10px;
        }

        .btn-cancel:hover {
            background: #c82333;
            text-decoration: none;
            color: white;
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        .file-upload-wrapper {
            position: relative;
            width: 100%;
            height: 120px;
            border: 2px dashed #ddd;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f8f9fa;
            transition: border-color 0.3s ease;
        }

        .file-upload-wrapper:hover {
            border-color: #667eea;
        }

        .file-upload-input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

        .file-upload-text {
            text-align: center;
            color: #6c757d;
        }

        .upload-icon {
            font-size: 24px;
            display: block;
            margin-bottom: 8px;
        }

        .upload-text {
            font-size: 14px;
        }

        .text-muted {
            color: #6c757d;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Make form more responsive */
        @media (max-width: 768px) {
            .form-section {
                margin: 10px;
                padding: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .file-upload-wrapper {
                height: 100px;
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
                    <h1 class="page-title">Add New Technician</h1>
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="form-section">
                <form action="{{ route('technician.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="experience_years">Years of Experience</label>
                        <input type="number" id="experience_years" name="experience_years" min="0" value="{{ old('experience_years') }}" required>
                        @error('experience_years')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cv">CV Upload (PDF format)</label>
                        <div class="file-upload-wrapper">
                            <input type="file" id="cv" name="cv_file" accept=".pdf" class="file-upload-input" required>
                            <div class="file-upload-text">
                                <span class="upload-icon">📎</span>
                                <span class="upload-text">Choose a file or drag it here</span>
                            </div>
                        </div>
                        <small class="text-muted">Maximum file size: 5MB</small>
                        @error('cv')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.technician') }}" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-submit">Create Technician</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        // Toggle Sidebar
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // File Upload Enhancement
        const fileInput = document.getElementById('cv');
        const fileUploadText = document.querySelector('.upload-text');
        const fileUploadWrapper = document.querySelector('.file-upload-wrapper');

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (file.type === 'application/pdf') {
                    fileUploadText.textContent = file.name;
                    fileUploadWrapper.style.borderColor = '#28a745';
                } else {
                    fileUploadText.textContent = 'Please select a PDF file';
                    fileUploadWrapper.style.borderColor = '#dc3545';
                    this.value = '';
                }
            } else {
                fileUploadText.textContent = 'Choose a file or drag it here';
                fileUploadWrapper.style.borderColor = '#ddd';
            }
        });

        // Drag and drop support
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileUploadWrapper.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            fileUploadWrapper.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            fileUploadWrapper.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            fileUploadWrapper.style.borderColor = '#667eea';
        }

        function unhighlight(e) {
            fileUploadWrapper.style.borderColor = '#ddd';
        }

        fileUploadWrapper.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const file = dt.files[0];

            if (file && file.type === 'application/pdf') {
                fileInput.files = dt.files;
                fileUploadText.textContent = file.name;
                fileUploadWrapper.style.borderColor = '#28a745';
            } else {
                fileUploadText.textContent = 'Please select a PDF file';
                fileUploadWrapper.style.borderColor = '#dc3545';
            }
        }
    </script>
@endsection
