{{--
    Cách dùng layout:
    - @extends('layouts.mentor')  →  tự có sidebar Mentor + header + footer
    - @section('title')           →  tab title
    - @section('breadcrumb')      →  breadcrumb trên header
    - @section('header-actions')  →  nút/filter thêm trên header bar
    - @section('content')         →  nội dung trang
--}}

@extends('frontend.layouts.mentor')

@section('title', 'Dashboard')

@section('breadcrumb')
    <span class="crumb-current">Dashboard</span>
@endsection

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Xin chào, {{ Auth::user()->name }} 👋</h1>
        <p class="page-subtitle">{{ now()->isoFormat('dddd, DD/MM/YYYY') }} — Đây là tổng quan hôm nay của bạn</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('mentor.tasks.create') }}" class="btn btn-primary">
            <i class="ti ti-plus"></i> Tạo task mới
        </a>
    </div>
</div>

{{-- Stat cards --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label" style="color: var(--info);">
            <i class="ti ti-users"></i> Thực tập sinh
        </div>
        <div class="stat-value">{{ $totalInterns ?? 0 }}</div>
        <div class="stat-sub">đang hướng dẫn</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" style="color: var(--warning);">
            <i class="ti ti-eye"></i> Chờ review
        </div>
        <div class="stat-value" style="color: var(--warning);">{{ $tasksInReview ?? 0 }}</div>
        <div class="stat-sub">task cần xác nhận</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" style="color: var(--danger);">
            <i class="ti ti-file-alert"></i> Báo cáo mới
        </div>
        <div class="stat-value" style="color: var(--danger);">{{ $pendingReports ?? 0 }}</div>
        <div class="stat-sub">chờ nhận xét</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" style="color: var(--success);">
            <i class="ti ti-circle-check"></i> Hoàn thành
        </div>
        <div class="stat-value" style="color: var(--success);">{{ $tasksDone ?? 0 }}</div>
        <div class="stat-sub">task tháng này</div>
    </div>
</div>

{{-- 2-column grid --}}
<div class="grid-2">

    {{-- Danh sách intern --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Thực tập sinh của tôi</span>
            <a href="{{ route('mentor.interns.index') }}" class="btn btn-outline btn-sm">Xem tất cả</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Họ tên</th>
                        <th>Trường</th>
                        <th>Kết thúc</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interns ?? [] as $intern)
                    <tr>
                        <td>
                            <div class="d-flex align-center gap-8">
                                <div class="avatar avatar-sm">{{ strtoupper(substr($intern->name, 0, 2)) }}</div>
                                <div>
                                    <div class="font-medium">{{ $intern->name }}</div>
                                    <div class="text-muted text-sm">{{ $intern->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $intern->university }}</td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $intern->status === 'active' ? 'badge-done' : 'badge-todo' }}">
                                {{ $intern->status === 'active' ? 'Đang TT' : 'Đã kết thúc' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="ti ti-users"></i>
                                <p class="empty-state-title">Chưa có thực tập sinh</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Task gần deadline --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Task gần deadline</span>
            <a href="{{ route('mentor.tasks.index') }}" class="btn btn-outline btn-sm">Xem tất cả</a>
        </div>
        @forelse($nearDeadlineTasks ?? [] as $task)
        <div class="d-flex align-center gap-12"
             style="padding: 12px 20px; border-bottom: 1px solid var(--border);">
            <div style="flex: 1; min-width: 0;">
                <div class="font-medium truncate">{{ $task->title }}</div>
                <div class="text-muted text-sm mt-4">{{ $task->intern->name ?? '' }}</div>
            </div>
            <div style="text-align: right; flex-shrink: 0;">
                <div class="text-sm text-danger font-medium">
                    {{ \Carbon\Carbon::parse($task->deadline)->diffForHumans() }}
                </div>
                <span class="badge badge-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'review' : 'done') }}" style="margin-top: 4px;">
                    {{ $task->priority === 'high' ? 'Cao' : ($task->priority === 'medium' ? 'Trung bình' : 'Thấp') }}
                </span>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="ti ti-calendar-check"></i>
            <p class="empty-state-sub">Không có task nào gần deadline</p>
        </div>
        @endforelse
    </div>

</div>

{{-- Báo cáo chờ nhận xét --}}
<div class="card mt-20">
    <div class="card-header">
        <span class="card-title">Báo cáo tuần chờ nhận xét</span>
        <a href="{{ route('mentor.reports.index') }}" class="btn btn-outline btn-sm">Xem tất cả</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Thực tập sinh</th>
                    <th>Tuần</th>
                    <th>Nộp lúc</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingReportsList ?? [] as $report)
                <tr>
                    <td>
                        <div class="d-flex align-center gap-8">
                            <div class="avatar avatar-sm">{{ strtoupper(substr($report->intern->name ?? 'U', 0, 2)) }}</div>
                            {{ $report->intern->name ?? 'N/A' }}
                        </div>
                    </td>
                    <td>{{ $report->week_label }}</td>
                    <td class="text-muted">{{ $report->created_at->format('H:i, d/m/Y') }}</td>
                    <td><span class="badge badge-review">Chờ nhận xét</span></td>
                    <td>
                        <a href="{{ route('mentor.reports.show', $report->id) }}" class="btn btn-outline btn-sm">
                            <i class="ti ti-eye"></i> Xem
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="ti ti-file-check"></i>
                            <p class="empty-state-title">Tất cả báo cáo đã được nhận xét</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
