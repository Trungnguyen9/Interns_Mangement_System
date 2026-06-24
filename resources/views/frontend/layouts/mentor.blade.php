{{--
    Layout dành riêng cho role Mentor.
    Chỉ làm 2 việc:
      1. Extend app.blade.php (layout gốc)
      2. Điền @section('sidebar-nav') với menu của Mentor
    Mọi page Mentor chỉ cần: @extends('layouts.mentor')
--}}

@extends('layouts.app')

@section('sidebar-nav')

    <div class="nav-group">
        <div class="nav-group-label">Tổng quan</div>
        <ul class="nav-list">
            <li>
                <a href="{{ route('mentor.dashboard') }}"
                   class="{{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
                    <i class="ti ti-layout-dashboard"></i>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>

    <div class="nav-group">
        <div class="nav-group-label">Quản lý</div>
        <ul class="nav-list">
            <li>
                <a href="{{ route('mentor.interns.index') }}"
                   class="{{ request()->routeIs('mentor.interns.*') ? 'active' : '' }}">
                    <i class="ti ti-users"></i>
                    Thực tập sinh
                </a>
            </li>
            <li>
                <a href="{{ route('mentor.tasks.index') }}"
                   class="{{ request()->routeIs('mentor.tasks.*') ? 'active' : '' }}">
                    <i class="ti ti-checklist"></i>
                    Task giao việc
                </a>
            </li>
            <li>
                <a href="{{ route('mentor.reports.index') }}"
                   class="{{ request()->routeIs('mentor.reports.*') ? 'active' : '' }}">
                    <i class="ti ti-file-text"></i>
                    Báo cáo tuần
                    @if(($pendingReports ?? 0) > 0)
                        <span class="nav-badge">{{ $pendingReports }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>

    <div class="nav-group">
        <div class="nav-group-label">Đánh giá</div>
        <ul class="nav-list">
            <li>
                <a href="{{ route('mentor.evaluations.index') }}"
                   class="{{ request()->routeIs('mentor.evaluations.*') ? 'active' : '' }}">
                    <i class="ti ti-star"></i>
                    Đánh giá kết quả
                </a>
            </li>
        </ul>
    </div>

@endsection
