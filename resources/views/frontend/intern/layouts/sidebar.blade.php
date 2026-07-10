<aside class="ims-sidebar">
    <div class="sidebar-section-label">Menu chính</div>

    <a href="{{ url('/internpage/dashboard') }}" class="sidebar-item {{ request()->routeIs('frontend.intern') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge icon"></i> Dashboard
    </a>
    <a href="{{ url('/internpage/profile') }}" class="sidebar-item {{ request()->routeIs('frontend.profile.index') ? 'active' : '' }}">
        <i class="fa-solid fa-user-circle icon"></i> Hồ sơ
    </a>
    <a href="{{ url('/internpage/tasks') }}" class="sidebar-item {{ request()->routeIs('frontend.intern.tasks') ? 'active' : '' }}">
        <i class="fa-solid fa-list-check icon"></i> Tasks
        @if ((auth()->user()->internProfile->tasks->count() ?? 0) > 0)
            <span class="badge-count">{{ auth()->user()->internProfile->tasks->count() }}</span>
        @endif
    </a>
    <a href="{{ url('/internpage/reports') }}" class="sidebar-item {{ request()->routeIs('frontend.intern.reports') ? 'active' : '' }}">
        <i class="fa-solid fa-file-lines icon"></i> Weekly Report
    </a>

</aside>
