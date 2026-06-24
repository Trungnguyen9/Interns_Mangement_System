{{--
    Layout dành riêng cho role Intern.
    Chỉ làm 2 việc:
      1. Extend app.blade.php (layout gốc)
      2. Điền @section('sidebar-nav') với menu của Intern
    Mọi page Intern chỉ cần: @extends('layouts.intern')
--}}

@extends('layouts.app')

@section('sidebar-nav')

    <div class="nav-group">
        <div class="nav-group-label">Tổng quan</div>
        <ul class="nav-list">
            <li>
                <a href="{{ route('intern.dashboard') }}"
                   class="{{ request()->routeIs('intern.dashboard') ? 'active' : '' }}">
                    <i class="ti ti-layout-dashboard"></i>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>

    <div class="nav-group">
        <div class="nav-group-label">Công việc</div>
        <ul class="nav-list">
            <li>
                <a href="{{ route('intern.tasks.index') }}"
                   class="{{ request()->routeIs('intern.tasks.*') ? 'active' : '' }}">
                    <i class="ti ti-checklist"></i>
                    Task của tôi
                    @if(($pendingTasks ?? 0) > 0)
                        <span class="nav-badge">{{ $pendingTasks }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('intern.reports.index') }}"
                   class="{{ request()->routeIs('intern.reports.*') ? 'active' : '' }}">
                    <i class="ti ti-file-text"></i>
                    Báo cáo tuần
                </a>
            </li>
            <li>
                <a href="{{ route('intern.reports.create') }}"
                   class="{{ request()->routeIs('intern.reports.create') ? 'active' : '' }}">
                    <i class="ti ti-plus"></i>
                    Nộp báo cáo mới
                </a>
            </li>
        </ul>
    </div>

    <div class="nav-group">
        <div class="nav-group-label">Thông tin</div>
        <ul class="nav-list">
            <li>
                <a href="{{ route('intern.mentor') }}"
                   class="{{ request()->routeIs('intern.mentor') ? 'active' : '' }}">
                    <i class="ti ti-user-circle"></i>
                    Mentor của tôi
                </a>
            </li>
            <li>
                <a href="{{ route('intern.profile') }}"
                   class="{{ request()->routeIs('intern.profile') ? 'active' : '' }}">
                    <i class="ti ti-id-badge"></i>
                    Hồ sơ thực tập
                </a>
            </li>
        </ul>
    </div>

@endsection
