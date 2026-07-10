<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IMS') – Mentor Portal</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/intern.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/mentor.css') }}">

    @stack('styles')
</head>
 
<body>
    <div class="ims-shell">

        {{-- ===== HEADER ===== --}}
        @include('frontend.mentor.layouts.header')

        {{-- ===== SIDEBAR ===== --}}
        @include('frontend.mentor.layouts.sidebar')

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="ims-content">
            @yield('content')
        </main>

        {{-- ===== FOOTER ===== --}}
        <footer class="ims-footer">
            <span>Intern Management System &copy; {{ date('Y') }}</span>
            <div class="footer-status">
                <div class="status-dot"></div>
                <span>{{ auth()->user()->name ?? 'Trần Thị Hoa' }} · Mentor · {{ $mentorDept ?? 'Engineering' }}</span>
            </div>
        </footer>

    </div>

    <script src="{{ asset('frontend/js/intern.js') }}"></script>
    <script src="{{ asset('frontend/js/mentor.js') }}"></script>
    @stack('scripts')
</body>

</html>
