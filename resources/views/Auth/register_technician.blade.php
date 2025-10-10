@extends('layouts.app')
@section('title', 'Technician Registration')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/technician.css') }}">
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

        .file-input-wrapper {
            width: 100%;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .file-input-label:hover {
            border-color: #007bff;
            background-color: #f9f9f9;
        }

        .file-input-label .input-icon {
            font-size: 18px;
            color: #555;
        }

        .file-input-wrapper input[type="file"] {
            display: none;
        }

        .file-name {
            margin-top: 8px;
            font-size: 14px;
            color: #444;
            font-weight: 500;
            word-wrap: break-word;
            display: none;
        }

        .info-text {
            font-size: 13px;
            color: #777;
            margin-top: 5px;
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
            <div class="header-icon">🔧</div>
            <h1>Technician Application</h1>
            <p class="subtitle">Fill in your details to join our team</p>
        </div>

        {{-- {{ route('technician.apply') }} --}}
        <form action="{{ route('apply') }}" method="POST" enctype="multipart/form-data" id="techForm">
            @csrf

            <div class="form-row">
                <div class="input-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" placeholder="Enter your full name"
                            value="{{ old('name') }}" required>
                        <span class="input-icon">👤</span>
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" placeholder="your@email.com"
                            value="{{ old('email') }}" required>
                        <span class="input-icon">✉️</span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="phone">Phone <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="tel" name="phone" id="phone" placeholder="+20 123 456 7890"
                            value="{{ old('phone') }}" required>
                        <span class="input-icon">📱</span>
                    </div>
                </div>
                <div class="input-group">
                    <label for="experience_years">Years of Experience <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="number" name="experience_years" id="experience_years"
                            placeholder="Enter your years of experience" value="{{ old('experience_years') }}" required>
                        <span class="input-icon">💼</span>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="input-group">
                    <label for="category_id">Category <span class="required">*</span></label>
                    <div class="input-wrapper grid grid-cols-4 gap-3 mt-2">
                        @foreach ($categories as $category)
                            <label class="checkbox-item flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="category_id" value="{{ $category->id }}"
                                    class="category-checkbox" {{ old('category_id') == $category->id ? 'checked' : '' }}>
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="input-group">
                <label for="skills">Skills & Expertise</label>
                <textarea name="skills" id="skills" placeholder="List your technical skills and areas of expertise...">{{ old('skills') }}</textarea>
                <p class="info-text">Separate skills with commas or line breaks</p>
            </div>

            <div class="input-group">
                <label for="experience">Work Experience</label>
                <textarea name="experience" id="experience" placeholder="Describe your relevant work experience...">{{ old('experience') }}</textarea>
                <p class="info-text">Include years of experience and notable projects</p>
            </div>

            <div class="input-group">
                <label for="cv_file">Upload CV / Certificate <span class="required">*</span></label>
                <div class="input-wrapper file-input-wrapper">
                    <label for="cv_file" class="file-input-label">
                        <span class="input-icon">📎</span>
                        <span class="file-text">Choose file (PDF, DOC, DOCX)</span>
                    </label>
                    <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx">
                    <div id="fileName" class="file-name" style="display: none;"></div>
                </div>
                <p class="info-text">Max file size: 5MB</p>
            </div>


            <div class="input-group">
                <label for="notes">Additional Notes</label>
                <textarea name="notes" id="notes" placeholder="Any additional information you'd like to share...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="submit-btn">SUBMIT APPLICATION</button>
        </form>


        <div class="back-link">
            <a href="{{ route('login') }}">← Back to Login</a>
        </div>
    </div>

@section('scripts')
    <script src="{{ asset('js/technician.js') }}"></script>
@endsection
@endsection
