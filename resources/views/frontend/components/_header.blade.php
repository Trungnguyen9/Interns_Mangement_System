<header class="header">
    <div class="header-left">
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
            <i class="ti ti-menu-2"></i>
        </button>
        <div class="breadcrumb">
            @yield('breadcrumb')
        </div>
    </div>
    <div class="header-right">
        @yield('header-actions')

        <button class="header-icon-btn" title="Thông báo" aria-label="Thông báo">
            <i class="ti ti-bell"></i>
            @if(($notifCount ?? 0) > 0)
                <span class="notif-badge">{{ $notifCount }}</span>
            @endif
        </button>

        <div class="header-user">
            <div class="avatar avatar-sm">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}</div>
            <span class="header-user-name">{{ Auth::user()->name ?? 'Người dùng' }}</span>
        </div>
    </div>
</header>
