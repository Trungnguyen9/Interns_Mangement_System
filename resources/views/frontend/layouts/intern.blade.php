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
        <header class="ims-header">
            {{-- <a class="ims-logo" href="{{ route('frontend.intern.dashboard') }}">
      <div class="logo-icon"><i class="fa-solid fa-people-group"></i></div> IMS
    </a> --}}
            <div class="logo-icon"><i class="fa-solid fa-people-group"></i></div> IMS

            <div class="ims-breadcrumb">
                <i class="fa-solid fa-house" style="font-size:12px"></i>
                <i class="fa-solid fa-chevron-right" style="font-size:10px"></i>
                <span>@yield('breadcrumb', 'Dashboard')</span>
            </div>
            <div class="ims-header-right">
                <div class="ims-notif-btn">
                    <i class="fa-regular fa-bell"></i>
                    <div class="ims-notif-dot"></div>
                </div>
                <div class="ims-user-chip">
                    <div class="ims-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'NA', 0, 2)) }}</div>
                    <span class="ims-user-name">{{ auth()->user()->name ?? 'Nguyễn Văn An' }}</span>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px;color:#718096;margin-left:2px"></i>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </header>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="ims-sidebar">
            <div class="sidebar-section-label">Menu chính</div>

            <a href="#"
                class="sidebar-item {{ request()->routeIs('frontend.intern.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge icon"></i> Dashboard
            </a>
            <a href="#"
                class="sidebar-item {{ request()->routeIs('frontend.intern.profile') ? 'active' : '' }}">
                <i class="fa-solid fa-user-circle icon"></i> Hồ sơ
            </a>
            <a href="#"
                class="sidebar-item {{ request()->routeIs('frontend.intern.tasks') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check icon"></i> Tasks
                @if (($pendingTaskCount ?? 0) > 0)
                    <span class="badge-count">{{ $pendingTaskCount }}</span>
                @endif
            </a>
            <a href="#"
                class="sidebar-item {{ request()->routeIs('frontend.intern.reports') ? 'active' : '' }}">
                <i class="fa-solid fa-file-lines icon"></i> Weekly Report
            </a>

            <div class="sidebar-mentor-box">
                <div class="label">Mentor phụ trách</div>
                <div style="display:flex;align-items:center;gap:10px">
                    <div class="mentor-avatar">
                        {{ strtoupper(substr($mentor->full_name ?? 'Trần Thị Hoa', 0, 2)) }}
                    </div>
                    <div>
                        <div style="font-size:12px;font-weight:600;color:#e2e8f0">
                            {{ $mentor->full_name ?? 'Trần Thị Hoa' }}</div>
                        <div style="font-size:11px;color:#a0aec0">{{ $mentor->department ?? 'Engineering' }}</div>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="ims-content">
            @yield('content')
        </main>

        {{-- ===== FOOTER ===== --}}
        <footer class="ims-footer">
            <span>Intern Management System &copy; {{ date('Y') }}</span>
            <div class="footer-status">
                <div class="status-dot"></div>
                <span>{{ auth()->user()->name ?? 'Nguyễn Văn An' }} · Đang thực tập · id_role = 3</span>
            </div>
        </footer>

    </div>

    <script src="{{ asset('frontend/js/intern.js') }}"></script>
    @stack('scripts')
</body>

</html>
