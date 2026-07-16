@extends('frontend.mentor.layouts.mentor')

@section('title', 'Dashboard Mentor')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div style="margin-bottom:20px">
        <div class="page-title">Dashboard Mentor</div>
        <div class="page-sub">Chào {{ auth()->user()->name ?? 'Trần Thị Hoa' }} &nbsp;·&nbsp; Tổng quan intern bạn phụ trách
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="grid-5" style="margin-bottom:20px">
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
        {{-- Interns roster --}}
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="fa-solid fa-users"></i> Intern phụ trách</div>
                <a href="{{ route('frontend.mentor.interns') }}"
                    style="font-size:12px;color:var(--c-primary);text-decoration:none">Xem tất cả →</a>
            </div>
            @forelse($internsList as $intern)
                <div class="intern-row">
                    <div class="mini-avatar">{{ strtoupper(substr($intern->full_name, 0, 3)) }}</div>
                    <div class="intern-row-name">{{ $intern->full_name }}<div class="intern-row-sub">
                            {{ $intern->desired_technology }}</div>
                    </div>
                    <span class="badge active-st">{{ $intern->status }}</span>
                </div>
            @empty
                <div class="intern-row">
                    <h4>chưa được gán thực tập sinh.</h4>
                </div>
            @endforelse
        </div>

        {{-- Near deadline tasks --}}
        <div class="card">
            <div class="card-head">
                <div class="card-title"><i class="fa-solid fa-clock"></i> Task gần deadline</div>
                <a href="{{ route('frontend.mentor.tasks') }}"
                    style="font-size:12px;color:var(--c-primary);text-decoration:none">Xem tất cả →</a>
            </div>
            @forelse($nearDeadlineTasks as $task)
                <div class="intern-row">
                    <div class="mini-avatar">{{ strtoupper(substr($task->intern->full_name, 0, 3)) }}</div>
                    <div class="intern-row-name">{{ $task->intern->full_name }}</div>
                    <span style="flex:1">{{ $task->title }} &middot; <span
                            style="color:var(--c-text-sub)">{{ $task->intern_name }}</span></span>
                    <span class="badge pri-{{ $task->priority }}">{{ $task->priority_label }}</span>
                </div>
            @empty
                <div class="intern-row"><span style="flex:1">
                        <h4>Không có tasks gần hạn nộp.</h4>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Reports pending review --}}
    <div class="section-divider" style="margin-top:24px">Báo cáo chờ review</div>
    <div class="card">
        @forelse($pendingReportsList as $report)
            <div class="intern-row">
                <div class="mini-avatar">{{ strtoupper(substr($report->intern->full_name, 0, 3)) }}</div>
                <div class="intern-row-name">{{ $report->intern->full_name }}</div>
                <span style="flex:1">{{ $report->week_start_date . ' - ' . $report->week_end_date }}</span>
                <span class="badge review">{{ $report->status }}</span>
            </div>
        @empty
            <div class="intern-row">
                <h4>Không có báo cáo cần review</h4>
            </div>
        @endforelse
        <a href="{{ route('frontend.mentor.reports') }}"
            style="font-size:12px;color:var(--c-primary);text-decoration:none">Xem tất cả →</a>
    </div>
@endsection
