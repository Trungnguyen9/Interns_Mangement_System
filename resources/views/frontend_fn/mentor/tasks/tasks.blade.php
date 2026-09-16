@extends('frontend_fn.layout.app')

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Tasks Management</h4>
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                Tasks Management
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">

        {{-- Grid intern cards --}}
        <div class="intern-task-grid">
            @forelse ($interns ?? [] as $intern)
                @php
                    $total = $intern->tasks->count();
                    $done = $intern->tasks->where('status', 'Done')->count();
                    $review = $intern->tasks->where('status', 'Review')->count();
                    $doing = $intern->tasks->where('status', 'Doing')->count();
                    $todo = $intern->tasks->where('status', 'Todo')->count();
                    $overdue = $intern->overdue_tasks_count;

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
                        @if ($intern->status === 'Ongoing Interns')
                            <span class="badge doing">{{ $intern->status }}</span>
                        @else
                            <span class="badge done">{{ $intern->status }}</span>
                        @endif
                    </div>
                    @if ($overdue > 0)
                        <div class="itc-danger">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            There are {{ $overdue }} overdue tasks
                        </div>
                    @endif

                    {{-- Progress bar --}}
                    <div class="itc-progress-wrap">
                        <div class="itc-progress-track">
                            <div class="itc-progress-fill" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="itc-progress-label">
                            <span>{{ $done }} / {{ $total }} completed tasks</span>
                            <span style="color:var(--c-primary);font-weight:600">{{ $percent }}%</span>
                        </div>
                    </div>

                    {{-- Stats mini row --}}
                    <div class="itc-stats">
                        <div class="itc-stat">
                            <span class="itc-stat-num" style="color:#718096">{{ $todo }}</span>
                            <span class="itc-stat-label">Todo</span>
                        </div>
                        <div class="itc-stat">
                            <span class="itc-stat-num" style="color:#3182ce">{{ $doing }}</span>
                            <span class="itc-stat-label">Doing</span>
                        </div>
                        <div class="itc-stat itc-stat-highlight">
                            <span class="itc-stat-num" style="color:#d69e2e">{{ $review }}</span>
                            <span class="itc-stat-label">Review</span>
                            @if ($review > 0)
                                <span class="itc-review-dot"></span>
                            @endif
                        </div>
                        <div class="itc-stat">
                            <span class="itc-stat-num" style="color:#38a169">{{ $done }}</span>
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
                            Show tasks <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--c-text-sub)">
                    <i class="fa-solid fa-users" style="font-size:32px;margin-bottom:12px;display:block"></i>
                    You have no interns assigned.
                </div>
            @endforelse
        </div>
    </div>
    </div>


    <!-- ============================================================== -->
    <!-- Footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
        All Rights Reserved by Nice admin. Designed and Developed by
        <a href="https://wrappixel.com">WrapPixel</a>.
    </footer>
@endsection
