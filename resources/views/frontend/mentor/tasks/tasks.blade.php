@extends('frontend.mentor.layouts.mentor')

@section('title', 'Quản lý Task')
@section('breadcrumb', 'Quản lý Task')

@section('content')

    <div class="page-header">
        <div>
            <div class="page-title">Quản lý Task</div>
            <div class="page-sub">Chọn intern để xem và quản lý task theo từng người</div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom:16px">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Grid intern cards --}}
    <div class="intern-task-grid">
        @forelse ($interns ?? [] as $intern)
            @php
                $total = $intern->tasks->count();
                $done = $intern->tasks->where('status', 'Done')->count();
                $review = $intern->tasks->where('status', 'Review')->count();
                $doing = $intern->tasks->where('status', 'Doing')->count();
                $todo = $intern->tasks->where('status', 'Todo')->count();
                $overdue = $intern->tasks->where('is_near_deadline', true)->count();

                $percent = $total > 0 ? round(($done / $total) * 100) : 0;
            @endphp
            <div class="intern-task-card">

                {{-- Header --}}
                <div class="itc-header">
                    <div class="mini-avatar lg">{{ strtoupper(substr($intern->full_name, 0, 3)) }}</div>
                    <div class="itc-info">
                        <div class="itc-name">{{ $intern->full_name }}</div>
                        <div class="itc-sub">{{ $intern->desired_technology ?? '—' }}</div>
                    </div>
                    @if ($intern->status === 'Đang thực tập')
                        <span class="badge doing">{{ $intern->status }}</span>
                    @else
                        <span class="badge done">{{ $intern->status }}</span>
                    @endif
                </div>
                @if ($overdue > 0) 
                    <div class="itc-alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Có {{ $overdue }} task quá hạn
                    </div>
                @endif

                {{-- Progress bar --}}
                <div class="itc-progress-wrap">
                    <div class="itc-progress-track">
                        <div class="itc-progress-fill" style="width: {{ $percent }}%"></div>
                    </div>
                    <div class="itc-progress-label">
                        <span>{{ $done }} / {{ $total }} task hoàn thành</span>
                        <span style="color:var(--c-primary);font-weight:600">{{ $percent }}%</span>
                    </div>
                </div>

                {{-- Stats mini row --}}
                <div class="itc-stats">
                    <div class="itc-stat">
                        <span class="itc-stat-num" style="color:var(--c-text-sub)">{{ $todo }}</span>
                        <span class="itc-stat-label">Todo</span>
                    </div>
                    <div class="itc-stat">
                        <span class="itc-stat-num" style="color:var(--c-info)">{{ $doing }}</span>
                        <span class="itc-stat-label">Doing</span>
                    </div>
                    <div class="itc-stat itc-stat-highlight">
                        <span class="itc-stat-num" style="color:var(--c-warning)">{{ $review }}</span>
                        <span class="itc-stat-label">Review</span>
                        @if ($review > 0)
                            <span class="itc-review-dot"></span>
                        @endif
                    </div>
                    <div class="itc-stat">
                        <span class="itc-stat-num" style="color:var(--c-success)">{{ $done }}</span>
                        <span class="itc-stat-label">Done</span>
                    </div>
                </div>

                {{-- Footer action --}}
                <div class="itc-footer">
                    <span class="itc-period">
                        <i class="fa-regular fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($intern->start_date)->format('d/m/Y') }}
                        –
                        {{ \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') }}
                    </span>
                    <a href="{{ route('frontend.mentor.tasks.show', $intern->id) }}" class="btn btn-primary itc-btn">
                        Xem task <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--c-text-sub)">
                <i class="fa-solid fa-users" style="font-size:32px;margin-bottom:12px;display:block"></i>
                Bạn chưa được gán intern nào.
            </div>
        @endforelse
    </div>

@endsection

@push('styles')
    <style>
        /* ── Intern task grid ── */
        .intern-task-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 16px;
        }

        /* ── Card ── */
        .intern-task-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 18px 20px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 14px;
            transition: box-shadow .15s, border-color .15s;
        }

        .intern-task-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, .09);
            border-color: var(--c-primary);
        }

        /* ── Header ── */
        .itc-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .itc-info {
            flex: 1;
            min-width: 0;
        }

        .itc-name {
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .itc-sub {
            font-size: 12px;
            color: var(--c-text-sub);
            margin-top: 2px;
        }

        /* ── Progress ── */
        .itc-progress-wrap {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .itc-progress-track {
            height: 7px;
            background: var(--c-bg);
            border-radius: 4px;
            overflow: hidden;
        }

        .itc-progress-fill {
            height: 100%;
            border-radius: 4px;
            background: var(--c-primary);
            transition: width .4s ease;
        }

        .itc-progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--c-text-sub);
        }

        /* ── Stats ── */
        .itc-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            background: var(--c-bg);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--c-border);
        }

        .itc-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 4px;
            position: relative;
            border-right: 1px solid var(--c-border);
        }

        .itc-stat:last-child {
            border-right: none;
        }

        .itc-stat-num {
            font-size: 18px;
            font-weight: 700;
            line-height: 1;
        }

        .itc-stat-label {
            font-size: 10px;
            color: var(--c-text-sub);
            margin-top: 3px;
        }

        /* Chấm đỏ cảnh báo có task chờ review */
        .itc-review-dot {
            position: absolute;
            top: 6px;
            right: 10px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--c-warning);
        }

        /* ── Footer ── */
        .itc-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 4px;
            border-top: 1px solid var(--c-border);
        }

        .itc-period {
            font-size: 11px;
            color: var(--c-text-sub);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .itc-btn {
            padding: 6px 14px;
            font-size: 12px;
        }

        .itc-alert {
            display: flex;
            align-items: center;
            gap: 8px;

            padding: 8px 10px;

            border-radius: 8px;

            background: #fff4e5;
            color: #b45309;

            border: 1px solid #fed7aa;

            font-size: 12px;
            font-weight: 600;
        }
    </style>
@endpush
