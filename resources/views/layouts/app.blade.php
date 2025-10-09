<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Home - @yield('title')</title>

    {{-- Common CSS --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/common.css') }}"> --}}

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
    {{-- <script src="{{ asset('js/common.js') }}"></script> --}}

    {{-- Page specific JavaScript --}}
    @yield('scripts')
</body>
</html>
