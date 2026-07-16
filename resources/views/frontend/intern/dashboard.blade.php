@extends('frontend.intern.layouts.intern')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div style="margin-bottom:20px">
        <div class="page-title">Dashboard</div>
        <div class="page-sub">Chào buổi sáng, {{ auth()->user()->name ?? '___' }} 👋
            &nbsp;·&nbsp; {{ now()->locale('vi')->isoFormat('dddd, DD/MM/YYYY') }}
        </div>
    </div>

    {{-- ===================== 4 stat cards ===================== --}}
    {{-- 1. Tổng số task  2. Đang làm  3. Đang chờ review  4. Đã hoàn thành --}}
    <div class="grid-4" style="margin-bottom:20px">
        @foreach ($stats as $stat)
            <div class="stat-card">
                <div class="stat-icon {{ $stat['color'] }}"><i class="{{ $stat['icon'] }}"></i></div>
                <div class="stat-label">{{ $stat['label'] }}</div>
                <div class="stat-val sv-primary">{{ $stat['value'] }}</div>
                <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">{{ $stat['sub'] }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid-2">
        {{-- Internship progress --}}
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="fa-solid fa-chart-line"></i> Tiến độ thực tập</div>
                <span style="font-size:12px;color:var(--c-text-sub)">Tuần {{ (int) $progress['current_week'] }} /
                    {{ (int) $progress['total_weeks'] }}</span>
            </div>
            <div class="progress-track">
                <div class="progress-fill" style="width:{{ $progress['percent'] }}%"></div>
            </div>
            <div
                style="display:flex;justify-content:space-between;font-size:12px;color:var(--c-text-sub);margin-bottom:16px">
                <span>{{ $progress['percent'] ?? 50 }}% hoàn thành</span>
                <span style="color:var(--c-primary);font-weight:600">{{ (int) $progress['weeks_left'] }} tuần còn
                    lại</span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:12px">
                <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
                    <div style="color:var(--c-text-sub);margin-bottom:2px">Bắt đầu</div>
                    <div style="font-weight:600">{{ \Carbon\Carbon::parse($intern->start_date)->format('d/m/Y') }}</div>
                </div>
                <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
                    <div style="color:var(--c-text-sub);margin-bottom:2px">Kết thúc</div>
                    <div style="font-weight:600">{{ \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') }}</div>
                </div>
                <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
                    <div style="color:var(--c-text-sub);margin-bottom:2px">Công nghệ</div>
                    <div style="font-weight:600">{{ $intern->desired_technology }}</div>
                </div>
                <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
                    <div style="color:var(--c-text-sub);margin-bottom:2px">Trạng thái</div>
                    <div style="font-weight:600;color:var(--c-success)">{{ $intern->status }}</div>
                </div>
            </div>
        </div>

        {{-- ===================== 5. Task gần deadline ===================== --}}
        <div class="card">
            <div class="card-head">
                <div class="card-title">
                    <i class="fa-solid fa-clock"></i> Task gần deadline
                </div>

                <a href="{{ route('frontend.intern.tasks') }}"
                    style="font-size:12px;color:var(--c-primary);text-decoration:none">
                    Xem tất cả →
                </a>
            </div>

            @forelse($taskNearDeadline as $task)
                <div class="task-row">
                    <div class="task-dot {{ $task->status === 'Done' ? 'dot-active' : 'dot-off' }}"></div>

                    <span style="flex:1;font-weight:500">
                        {{ $task->title }}
                    </span>

                    <span
                        class="{{ $task->is_overdue ? 'deadline-over' : ($task->is_near_deadline ? 'deadline-near' : '') }}"
                        style="font-size:12px;margin-right:10px;white-space:nowrap">

                        {{ $task->is_overdue ? 'Quá hạn' : 'Còn ' . $task->days_left . ' ngày' }}
                    </span>

                    <span class="badge {{ $task->status }}">
                        {{ $task->status_label }}
                    </span>
                </div>
            @empty
                <div class="task-row">
                    <h4>Không có task sắp hết hạn</h4>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ===================== 6. Báo cáo tuần gần nhất ===================== --}}
    <div class="section-divider" style="margin-top:24px">
        Báo cáo tuần mới nhất
    </div>

    <div class="card">
        @if ($reportNew)
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                <div style="font-size:14px;font-weight:600">
                    Tuần {{ $reportNew->week_range }}
                </div>

                <span class="badge {{ $reportNew->status }}">
                    {{ $reportNew->status }}
                </span>
            </div>

            <div style="font-size:13px;color:var(--c-text-sub)">
                {{ $reportNew->completed_tasks }}
            </div>

            <div style="margin-top:12px">
                <a href="{{ route('frontend.intern.reports') }}"
                    style="font-size:13px;color:var(--c-primary);text-decoration:none">
                    Xem tất cả báo cáo →
                </a>
            </div>
        @else
            <div class="task-row">
                <h4>Chưa có báo cáo tuần nào</h4>
            </div>
        @endif
    </div>

    {{-- ===================== 7. Nhận xét mới nhất từ mentor ===================== --}}
    <div class="section-divider" style="margin-top:24px">
        Nhận xét mới nhất từ mentor
    </div>

    <div class="card">
        @if ($commentNew)
            <div style="display:flex;align-items:flex-start;gap:12px">
                <div class="mentor-avatar">
                    {{ strtoupper(substr($commentNew->intern->mentor->user->name ?? '', 0, 3)) }}
                </div>

                <div style="flex:1">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px">
                        <span style="font-size:13.5px;font-weight:600">
                            {{ $commentNew->mentor->user->name ?? 'Mentor' }}
                        </span>

                        <span style="font-size:11.5px;color:var(--c-text-sub)">
                            {{ $commentNew->updated_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="mentor-comment" style="margin-top:0">
                        <i class="fa-solid fa-comment-dots"></i>

                        <div>
                            {{ $commentNew->mentor_comment }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="task-row">
                <h4>Chưa có nhận xét từ mentor</h4>
            </div>
        @endif
    </div>
@endsection
