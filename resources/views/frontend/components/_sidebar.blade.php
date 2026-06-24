<aside class="sidebar" id="sidebar">
    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <i class="ti ti-building-office"></i>
        </div>
        <div class="sidebar-logo-text">
            <span class="sidebar-logo-name">IMS</span>
            <span class="sidebar-logo-sub">Intern Management</span>
        </div>
    </div>

    {{-- Navigation — được inject từng role --}}
    <nav class="sidebar-nav" aria-label="Main navigation">
        @yield('sidebar-nav')
    </nav>

    {{-- Footer user + logout --}}
    <div class="sidebar-footer">
        <div class="sidebar-user-card">
            <div class="avatar avatar-sm">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ Auth::user()->name ?? 'Người dùng' }}</span>
                <span class="sidebar-user-role">{{ ucfirst(Auth::user()->role ?? 'user') }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout-btn" title="Đăng xuất">
                    <i class="ti ti-logout"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
