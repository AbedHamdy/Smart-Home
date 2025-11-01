<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khedmaty - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- Common CSS --}}
    {{--
    <link rel="stylesheet" href="{{ asset('css/common.css') }}"> --}}

    <style>
        .nav-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            transition: all 0.3s ease;
        }

        .nav-icon i {
            font-size: 1.1rem;
            color: #000000;
            transition: all 0.3s ease;
        }

        .nav-item:hover .nav-icon i,
        .nav-item.active .nav-icon i {
            color: #c7c7c7;
            transform: scale(1.1);
        }

        .logo-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.1);
            margin-right: 12px;
        }

        .logo-icon i {
            transition: all 0.3s ease;
        }

        .sidebar-header:hover .logo-icon i {
            transform: rotate(0deg) scale(1.1) !important;
        }
    </style>

    {{-- Page specific CSS --}}
    @yield('styles')
</head>

<body>
    {{-- Background Elements --}}
    <div class="bg-element element-1"></div>
    <div class="bg-element element-2"></div>
    <div class="bg-element element-3"></div>

    {{-- Main Content --}}
    @yield('content')

    {{-- Common JavaScript --}}
    {{--
    <script src="{{ asset('js/common.js') }}"></script> --}}

    {{-- Page specific JavaScript --}}
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script nonce="{{ csrf_token() }}">
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;

        // إنشاء الـ overlay
        let overlay = document.querySelector('.sidebar-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            body.appendChild(overlay);
        }

        // التأكد من وجود العناصر
        if (!menuToggle || !sidebar) {
            console.error('Menu toggle or sidebar not found!');
            return;
        }

        // فتح/إغلاق السايد بار
        menuToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // للموبايل: استخدام active class
            if (window.innerWidth <= 768) {
                const isActive = sidebar.classList.contains('active');

                if (isActive) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    body.style.overflow = '';
                } else {
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                    body.style.overflow = 'hidden';
                }
            } else {
                // للديسكتوب: استخدام collapsed class
                sidebar.classList.toggle('collapsed');
            }
        });

        // إغلاق السايد بار عند الضغط على الـ overlay (موبايل فقط)
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            body.style.overflow = '';
        });

        // إغلاق السايد بار عند الضغط على أي لينك فيه (للموبايل)
        const navItems = sidebar.querySelectorAll('.nav-item');
        navItems.forEach(function (item) {
            item.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    body.style.overflow = '';
                }
            });
        });

        // تنظيف عند تغيير حجم الشاشة
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                body.style.overflow = '';
            } else {
                sidebar.classList.remove('collapsed');
            }
        });
    });
</script>
</body>

</html>
