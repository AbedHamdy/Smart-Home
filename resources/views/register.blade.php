<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Registration - SmartFix</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7e22ce 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 40px 20px;
        }

        /* Animated background elements */
        .bg-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            animation: float 20s infinite ease-in-out;
        }

        .element-1 {
            width: 400px;
            height: 400px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .element-2 {
            width: 300px;
            height: 300px;
            bottom: -100px;
            right: -100px;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0) scale(1);
            }

            50% {
                transform: translateY(-40px) translateX(40px) scale(1.1);
            }
        }

        .registration-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 40px 45px;
            border-radius: 24px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 650px;
            position: relative;
            z-index: 10;
            animation: slideIn 0.6s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(5, 150, 105, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(5, 150, 105, 0.4);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 40px rgba(5, 150, 105, 0.6);
            }
        }

        h1 {
            color: #1e293b;
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .subtitle {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group.full-width {
            grid-column: 1 / -1;
        }

        .input-group label {
            display: block;
            margin-bottom: 10px;
            color: #334155;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .required {
            color: #ef4444;
            margin-left: 3px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #94a3b8;
            transition: color 0.3s;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 14px 20px 14px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8fafc;
            color: #1e293b;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 20px center;
            padding-right: 45px;
        }

        textarea {
            padding: 14px 20px;
            min-height: 100px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #059669;
            background: white;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        input:focus+.input-icon {
            color: #059669;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 20px;
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .file-input-label:hover {
            border-color: #059669;
            background: #f0fdf4;
            color: #059669;
        }

        input[type="file"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .file-name {
            margin-top: 8px;
            font-size: 13px;
            color: #059669;
            font-weight: 500;
        }

        .info-text {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 6px;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 25px;
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
            letter-spacing: 0.5px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(5, 150, 105, 0.4);
        }

        .submit-btn:active {
            transform: translateY(-1px);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #059669;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .registration-container {
                padding: 30px 25px;
            }
        }
        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #ff5722; /* لون جميل لتصميمك */
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 عناصر في الصف */
            gap: 10px;
        }
    </style>
</head>

<body>
    <div class="bg-element element-1"></div>
    <div class="bg-element element-2"></div>

    <div class="registration-container">
        <div class="header">
            <div class="header-icon">🔧</div>
            <h1>Technician Application</h1>
            <p class="subtitle">Fill in your details to join our team</p>
        </div>

        {{-- {{ route('technician.apply') }} --}}
        <form action="{{ route("apply") }}" method="POST" enctype="multipart/form-data" id="techForm">
            @csrf

            <div class="form-row">
                <div class="input-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="name" placeholder="Enter your full name" required>
                        <span class="input-icon">👤</span>
                    </div>
                </div>

                <div class="input-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="email" name="email" id="email" placeholder="your@email.com" required>
                        <span class="input-icon">✉️</span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="input-group">
                    <label for="phone">Years of Experience <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="tel" name="phone" id="phone" placeholder="+20 123 456 7890" required>
                        <span class="input-icon">📱</span>
                    </div>
                </div>

                <div class="input-group">
                    <label for="experience_years">Years of Experience <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="number" name="experience_years" id="experience_years" placeholder="Enter your years of experience" min="0" max="80" step="1" required>
                        <span class="input-icon">💼</span>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="input-group">
                    <label for="category_id">Category <span class="required">*</span></label>
                    <div class="input-wrapper grid grid-cols-4 gap-3 mt-2">
                        {{-- @php
                            $categories = [
                                1 => 'Electrical',
                                2 => 'Plumbing',
                                3 => 'HVAC',
                                4 => 'Smart Home Systems',
                                5 => 'General Maintenance',
                            ];
                        @endphp --}}

                        {{-- @if($categories) --}}
                        @foreach ($categories as $id => $name)
                            <label class="checkbox-item flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="category_id" value="{{ $id }}"
                                    class="category-checkbox" required>
                                <span>{{ $name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="input-group">
                <label for="skills">Skills & Expertise</label>
                <textarea name="skills" id="skills"
                    placeholder="List your technical skills and areas of expertise (e.g., electrical wiring, HVAC installation, smart home automation...)"></textarea>
                <p class="info-text">Separate skills with commas or line breaks</p>
            </div>

            <div class="input-group">
                <label for="experience">Work Experience</label>
                <textarea name="experience" id="experience"
                    placeholder="Describe your relevant work experience, previous projects, and certifications..."></textarea>
                <p class="info-text">Include years of experience and notable projects</p>
            </div>

            <div class="input-group">
                <label for="cv_file">Upload CV / Certificate</label>
                <div class="file-input-wrapper">
                    <label for="cv_file" class="file-input-label">
                        <span>📎</span>
                        <span>Choose file (PDF, DOC, DOCX)</span>
                    </label>
                    <input type="file" name="cv_file" id="cv_file" accept=".pdf,.doc,.docx">
                    <div id="fileName" class="file-name" style="display: none;"></div>
                </div>
                <p class="info-text">Max file size: 5MB</p>
            </div>

            <div class="input-group">
                <label for="notes">Additional Notes</label>
                <textarea name="notes" id="notes" placeholder="Any additional information you'd like to share..."></textarea>
            </div>

            <button type="submit" class="submit-btn">SUBMIT APPLICATION</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">← Back to Login</a>
        </div>
    </div>

    <script>
        // File upload handler
        const fileInput = document.getElementById('cv_file');
        const fileName = document.getElementById('fileName');

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                fileName.textContent = '✓ ' + this.files[0].name;
                fileName.style.display = 'block';
            } else {
                fileName.style.display = 'none';
            }
        });

        // Add icons focus effect
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                const icon = this.nextElementSibling;
                if (icon && icon.classList.contains('input-icon')) {
                    icon.style.transform = 'translateY(-50%) scale(1.1)';
                }
            });

            input.addEventListener('blur', function() {
                const icon = this.nextElementSibling;
                if (icon && icon.classList.contains('input-icon')) {
                    icon.style.transform = 'translateY(-50%) scale(1)';
                }
            });
        });

        document.querySelectorAll('.category-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    document.querySelectorAll('.category-checkbox').forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                }
            });
        });

    </script>
</body>

</html>
