@extends('layouts.app')
@section('title', 'Add New Category')

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
            transition: all 0.3s ease;
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
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group textarea {
            min-height: 100px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
            pointer-events: none;
        }

        .input-with-icon input {
            padding-left: 38px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 32px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
            padding: 12px 32px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cancel:hover {
            background: #c82333;
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .text-danger {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .text-muted {
            color: #6c757d;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .required {
            color: #e53e3e;
            margin-left: 3px;
        }

        /* Grid Layout for Form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .form-grid-full {
            grid-column: 1 / -1;
        }

        /* Price Input Styling */
        .price-input-wrapper {
            position: relative;
        }

        .currency-prefix {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-weight: 600;
            font-size: 16px;
            pointer-events: none;
        }

        .price-input-wrapper input {
            padding-left: 32px;
        }

        .price-suffix {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 13px;
            font-weight: 500;
            pointer-events: none;
        }

        .price-input-wrapper input {
            padding-right: 50px;
        }

        /* Info Box */
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
        }

        .info-box-icon {
            font-size: 20px;
            margin-right: 10px;
        }

        .info-box-text {
            color: #1565c0;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Make form more responsive */
        @media (max-width: 768px) {
            .form-section {
                padding: 20px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-submit,
            .btn-cancel {
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
                    <h1 class="page-title">Add New Category</h1>
                </div>
                <div class="topbar-right">
                    {{-- <div class="search-box">
                        <input type="text" placeholder="Search...">
                        <span class="search-icon">🔍</span>
                    </div> --}}
                    @include('layouts.notification')
                    <div class="user-menu">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=2563eb&color=fff" alt="Admin">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            @include('layouts.message_admin')

            <div class="form-section">
                <!-- Info Box -->
                <div class="info-box">
                    <span class="info-box-icon">💡</span>
                    <span class="info-box-text">
                        Create a new service category with a base price. This price will be used as the starting rate for services in this category.
                    </span>
                </div>

                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                        <!-- Category Name -->
                        <div class="form-group">
                            <label for="name">
                                Category Name
                                <span class="required">*</span>
                            </label>
                            <div class="input-with-icon">
                                <span class="input-icon">📂</span>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="e.g., Plumbing, Electrical, AC Repair"
                                    required
                                >
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-muted">Enter a clear and descriptive category name</span>
                        </div>

                        <!-- Price -->
                        <div class="form-group">
                            <label for="price">
                                Base Price
                                <span class="required">*</span>
                            </label>
                            <div class="price-input-wrapper">
                                <span class="currency-prefix"></span>
                                <input
                                    type="number"
                                    id="price"
                                    name="price"
                                    value="{{ old('price') }}"
                                    placeholder="0.00"
                                    step="0.01"
                                    min="0"
                                    required
                                >
                                <span class="price-suffix">EG</span>
                            </div>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-muted">Set the starting price for this service category</span>
                        </div>

                        <!-- Description (Optional - Full Width) -->
                        {{-- <div class="form-group form-grid-full">
                            <label for="description">
                                Description
                                <span style="color: #6c757d; font-weight: 400;">(Optional)</span>
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                placeholder="Describe what services are included in this category..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <span class="text-muted">Provide additional details about this category (optional)</span>
                        </div> --}}
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('category.index') }}" class="btn-cancel">
                            ← Cancel
                        </a>
                        <button type="submit" class="btn-submit">
                            ✓ Create Category
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        // Format price input on blur
        document.getElementById('price').addEventListener('blur', function(e) {
            let value = parseFloat(e.target.value);
            if (!isNaN(value)) {
                e.target.value = value.toFixed(2);
            }
        });

        // Prevent negative values
        document.getElementById('price').addEventListener('input', function(e) {
            if (parseFloat(e.target.value) < 0) {
                e.target.value = 0;
            }
        });

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const price = parseFloat(document.getElementById('price').value);

            if (name === '') {
                e.preventDefault();
                alert('⚠️ Please enter a category name');
                document.getElementById('name').focus();
                return false;
            }

            if (isNaN(price) || price < 0) {
                e.preventDefault();
                alert('⚠️ Please enter a valid price (minimum $0.00)');
                document.getElementById('price').focus();
                return false;
            }
        });
    </script>
@endsection
