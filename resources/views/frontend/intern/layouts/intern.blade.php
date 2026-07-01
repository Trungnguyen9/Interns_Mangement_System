<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IMS') – Intern Portal</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/intern.css') }}">


    @stack('styles')
</head>

<body>
    <div class="ims-shell">

        {{-- ===== HEADER ===== --}}
        @include('frontend.intern.layouts.header')

        {{-- ===== SIDEBAR ===== --}}
        @include('frontend.intern.layouts.sidebar')

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="ims-content">
            @yield('content')
        </main>

        {{-- ===== FOOTER ===== --}}
        <footer class="ims-footer">
            <span>Intern Management System &copy; {{ date('Y') }}</span>
            <div class="footer-status">
                <div class="status-dot"></div>
                <span>{{ auth()->user()->name ?? '#' }} · Đang thực tập ·</span>
            </div>
        </footer>
    </div>

    <script src="{{ asset('frontend/js/intern.js') }}"></script>
    @stack('scripts')
</body>

</html>
