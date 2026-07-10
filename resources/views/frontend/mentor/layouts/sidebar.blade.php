{{-- ===== SIDEBAR ===== --}}
<aside class="ims-sidebar">
    <div class="sidebar-section-label">Menu chính</div>

    <a href="{{ route('frontend.mentor') }}"
        class="sidebar-item {{ request()->routeIs('frontend.mentor') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge icon"></i> Dashboard
    </a>
    <a href="{{ route('frontend.mentor.interns') }}"
        class="sidebar-item {{ request()->routeIs('frontend.mentor.interns') ? 'active' : '' }}">
        <i class="fa-solid fa-users icon"></i> Intern phụ trách
    </a>
    <a href="{{ route('frontend.mentor.tasks') }}"
        class="sidebar-item {{ request()->routeIs('frontend.mentor.tasks') ? 'active' : '' }}">
        <i class="fa-solid fa-list-check icon"></i> Quản lý Task
        @if (($pendingReviewCount ?? 0) > 0)
            <span class="badge-count">{{ $pendingReviewCount }}</span>
        @endif
    </a>
    <a href="{{ route('frontend.mentor.reports') }}"
        class="sidebar-item {{ request()->routeIs('frontend.mentor.reports') ? 'active' : '' }}">
        <i class="fa-solid fa-file-lines icon"></i> Báo cáo tuần
        @if (($pendingReportCount ?? 0) > 0)
            <span class="badge-count">{{ $pendingReportCount }}</span>
        @endif
    </a>

</aside>
