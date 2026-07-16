@extends('frontend.mentor.layouts.mentor')

@section('title', 'Chi tiết Intern')
@section('breadcrumb', 'Chi tiết Intern')

@section('content')
    <div style="margin-bottom:20px">
        <a href="{{ route('frontend.mentor.interns') }}" style="font-size:12px;color:var(--c-text-sub);text-decoration:none">
            <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
        </a>
        <div class="page-title" style="margin-top:8px">Chi tiết Intern</div>
    </div>

    {{-- Intern summary card --}}
    <div class="card" style="display:flex;align-items:center;gap:16px;margin-bottom:20px">
        <div class="mini-avatar lg">{{ strtoupper(substr($intern->full_name, 0, 3)) }}</div>
        <div style="flex:1">
            <div style="font-size:15px;font-weight:600">{{ $intern->full_name }}</div>
            <div style="font-size:13px;color:var(--c-text-sub)">{{ $intern->user->email ?? 'N/A' }} &middot;
                {{ $intern->school ?? 'N/A' }}</div>
        </div>
        @if ($intern->status === 'Đang thực tập')
            <span class="badge doing">{{ $intern->status }}</span>
        @else
            <span class="badge done">{{ $intern->status }}</span>
        @endif
    </div>

    {{-- Info grid --}}
    <div class="detail-grid">
        <div class="detail-field">
            <div class="detail-label">Công nghệ mong muốn</div>
            <div class="detail-val">{{ $intern->desired_technology ?? '__' }}</div>
        </div>
        <div class="detail-field">
            <div class="detail-label">Năm học</div>
            <div class="detail-val">{{ $intern->academic_year ?? '__' }}</div>
        </div>
        <div class="detail-field">
            <div class="detail-label">Ngày bắt đầu</div>
            <div class="detail-val">{{ \Carbon\Carbon::parse($intern->start_date)->format('d/m/Y') ?? '__' }}</div>
        </div>
        <div class="detail-field">
            <div class="detail-label">Ngày kết thúc</div>
            <div class="detail-val">{{ \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') ?? '__' }}</div>
        </div>
    </div>

    {{-- Tasks --}}
    <div class="section-divider">Danh sách Task đã giao</div>
    <div class="card" style="margin-bottom:20px">
        @forelse(($tasks ?? []) as $task)
            <div class="intern-row">
                <span style="flex:1">{{ $task->title }}</span>
                <span class="{{ $task->is_near_deadline ? 'deadline-warning' : '' }}">
                    <i class="fa-regular fa-calendar" style="font-size:10px"></i>
                    {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                    @if ($task->is_near_deadline)
                        <span class="deadline-badge">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            Sắp hết hạn
                        </span>
                    @endif
                </span>
                <span class="badge {{ $task->status }}">{{ $task->status }}</span>
            </div>
        @empty
            {{-- Dữ liệu mẫu --}}
            <div class="intern-row"><span style="flex:1">Thiết kế ERD database</span><span
                    style="font-size:11px;color:var(--c-text-sub);margin-right:8px">10/06/2025</span><span
                    class="badge done">Done</span></div>
            <div class="intern-row"><span style="flex:1">Viết API intern list</span><span
                    style="font-size:11px;color:var(--c-text-sub);margin-right:8px">15/06/2025</span><span
                    class="badge review">Review</span></div>
            <div class="intern-row"><span style="flex:1">Viết unit test</span><span
                    style="font-size:11px;color:var(--c-text-sub);margin-right:8px">08/06/2025</span><span
                    class="badge doing">Doing</span></div>
        @endforelse
        <div style="margin-top:10px"><a href="{{ route('frontend.mentor.tasks.show', $intern->id) }}"
                style="font-size:12px;color:var(--c-primary);text-decoration:none">Quản lý tasks →</a></div>
        <div>{{ $tasks->links('vendor.pagination.ims') }}</div>
    </div>

    {{-- Weekly reports --}}
    <div class="section-divider">Báo cáo tuần gần đây</div>
    <div class="card">
        @forelse(($weeklyReports ?? []) as $report)
            <div class="intern-row">
                <span style="flex:1">Tuần {{ $report->week_start_date }} -
                    {{ $report->week_end_date }}</span>
                @if ($report->mentor_comment !== null)
                    <span class="badge Done">Đã nhận xét</span>
                @else
                    <span class="badge Overdue">Chờ nhận xét</span>
                @endif
            </div>
        @empty
            {{-- Dữ liệu mẫu --}}
            <div class="intern-row"><span style="flex:1">Tuần 5 &middot; 02/06 - 06/06</span><span
                    class="badge submitted">Chờ duyệt</span></div>
            <div class="intern-row"><span style="flex:1">Tuần 4 &middot; 26/05 - 30/05</span><span class="badge reviewed">Đã
                    duyệt</span></div>
        @endforelse
        <div style="margin-top:10px"><a href="#"
                style="font-size:12px;color:var(--c-primary);text-decoration:none">Xem tất cả báo cáo →</a></div>
        <div>{{ $weeklyReports->links('vendor.pagination.ims') }}</div>

    </div>
@endsection
