@extends('frontend_fn.layout.app')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- ============================================================== -->
    <!-- Bread crumb -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Dashboard
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb -->
    <!-- ============================================================== -->


    <div class="container-fluid">

        {{-- ============================================================== --}}
        {{-- SECTION 1: Tổng quan --}}
        {{-- ============================================================== --}}
        <div class="row">

            @foreach ($stats as $stat)
                <div class="col-md-6 col-lg-3 mb-4">

                    <div class="card shadow-sm h-100">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <h6 class="text-muted mb-2">
                                        {{ $stat['title'] }}
                                    </h6>

                                    <h2 class="font-weight-bold mb-0">
                                        {{ $stat['value'] }}
                                    </h2>
                                </div>

                                <div class="text-{{ $stat['color'] }}">
                                    <i class="{{ $stat['icon'] }} display-4"></i>
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            @endforeach

        </div>


        {{-- ============================================================== --}}
        {{-- SECTION 2: Tiến độ thực tập + Task gần deadline --}}
        {{-- ============================================================== --}}
        <div class="row">

            {{-- Internship Progress --}}
            <div class="col-12 col-lg-4">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">
                                Internship Progress
                            </h4>

                            <span class="text-muted" style="font-size:13px;">
                                Week {{ (int) $progress['current_week'] }}
                                /
                                {{ (int) $progress['total_weeks'] }}
                            </span>
                        </div>


                        <div class="progress mt-4 mb-2">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progress['percent'] }}%"
                                aria-valuenow="{{ $progress['percent'] }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>


                        <div class="d-flex justify-content-between mb-4">

                            <small class="text-muted">
                                {{ $progress['percent'] ?? 0 }}% completed
                            </small>

                            <small class="text-primary font-weight-bold">
                                {{ (int) $progress['weeks_left'] }} weeks left
                            </small>

                        </div>


                        <div class="row">

                            <div class="col-6 mb-3">
                                <small class="text-muted d-block">
                                    START DATE
                                </small>

                                <strong>
                                    {{ \Carbon\Carbon::parse($intern->start_date)->format('d/m/Y') }}
                                </strong>
                            </div>


                            <div class="col-6 mb-3">
                                <small class="text-muted d-block">
                                    END DATE
                                </small>

                                <strong>
                                    {{ \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') }}
                                </strong>
                            </div>


                            <div class="col-6">
                                <small class="text-muted d-block">
                                    TECHNOLOGY
                                </small>

                                <strong>
                                    {{ $intern->desired_technology }}
                                </strong>
                            </div>


                            <div class="col-6">
                                <small class="text-muted d-block">
                                    STATUS
                                </small>

                                <span class="badge badge-success">
                                    {{ $intern->status }}
                                </span>
                            </div>

                        </div>

                    </div>
                </div>

            </div>


            {{-- Tasks Nearing Deadline --}}
            <div class="col-12 col-lg-8">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center">

                            <h4 class="card-title mb-0">
                                Tasks Nearing Deadline
                            </h4>

                            <span class="text-muted" style="font-size:13px;">
                                Sort by Nearest Deadline
                            </span>

                        </div>


                        <div class="table-responsive mt-2">

                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th class="border-top-0">TASK</th>
                                        <th class="border-top-0">DEADLINE</th>
                                        <th class="border-top-0">TIME LEFT</th>
                                        <th class="border-top-0">STATUS</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    @forelse ($taskNearDeadline as $task)
                                        <tr>

                                            <td class="txt-oflo">
                                                {{ $task->title }}
                                            </td>


                                            <td class="txt-oflo">
                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                                            </td>


                                            <td>

                                                @php
                                                    $daysLeft = $task->deadline
                                                        ? today()->diffInDays($task->deadline, false)
                                                        : null;
                                                @endphp


                                                @if (!is_null($daysLeft) && $daysLeft <= 1)
                                                    <span class="dashboard-deadline-badge badge-deadline-urgent">
                                                        {{ (int) $daysLeft }} Days left
                                                    </span>
                                                @else
                                                    <span class="dashboard-deadline-badge badge-deadline-soon">
                                                        {{ (int) $daysLeft }} Days left
                                                    </span>
                                                @endif

                                            </td>


                                            <td>

                                                @switch($task->status)
                                                    @case('Pending')
                                                        <span class="badge badge-warning">
                                                            Pending
                                                        </span>
                                                    @break

                                                    @case('Doing')
                                                        <span class="badge badge-info">
                                                            Doing
                                                        </span>
                                                    @break

                                                    @case('Review')
                                                        <span class="badge badge-primary">
                                                            Review
                                                        </span>
                                                    @break

                                                    @case('Done')
                                                        <span class="badge badge-success">
                                                            Done
                                                        </span>
                                                    @break

                                                    @default
                                                        <span class="badge badge-secondary">
                                                            {{ $task->status }}
                                                        </span>
                                                @endswitch

                                            </td>

                                        </tr>

                                        @empty

                                            <tr>
                                                <td colspan="4" class="empty-hint">
                                                    No tasks near deadline
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>


                                <a href="{{ route('frontend.intern.tasks') }}">
                                    Show All
                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            </div>


            {{-- ============================================================== --}}
            {{-- SECTION 3: Báo cáo tuần mới nhất --}}
            {{-- ============================================================== --}}
            <div class="row">

                <div class="col-12">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <h4 class="card-title mb-0">
                                    Latest Weekly Report
                                </h4>

                            </div>


                            <div class="table-responsive mt-2">

                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th class="border-top-0">TIME</th>
                                            <th class="border-top-0">COMPLETED TASKS</th>
                                            <th class="border-top-0">STATUS</th>
                                        </tr>
                                    </thead>


                                    <tbody>

                                        @if ($reportNew)
                                            <tr>

                                                <td class="txt-oflo">
                                                    {{ $reportNew->week_range }}
                                                </td>


                                                <td class="txt-oflo">
                                                    {{ $reportNew->completed_tasks }}
                                                </td>


                                                <td>

                                                    @if ($reportNew->status === 'reviewed')
                                                        <span class="badge badge-success">
                                                            Reviewed
                                                        </span>
                                                    @elseif ($reportNew->status === 'pending')
                                                        <span class="badge badge-warning">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">
                                                            {{ $reportNew->status }}
                                                        </span>
                                                    @endif

                                                </td>

                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="3" class="empty-hint">
                                                    No weekly reports
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>

                                </table>


                                <a href="{{ route('frontend.intern.reports') }}">
                                    Show All
                                </a>

                            </div>

                        </div>
                    </div>

                </div>

            </div>


            {{-- ============================================================== --}}
            {{-- SECTION 4: Nhận xét mới nhất từ Mentor --}}
            {{-- ============================================================== --}}
            <div class="row">

                <div class="col-12">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <h4 class="card-title mb-0">
                                    Latest Mentor Comment
                                </h4>

                            </div>


                            <div class="table-responsive mt-2">

                                <table class="table table-hover">

                                    <thead>
                                        <tr>
                                            <th class="border-top-0">MENTOR NAME</th>
                                            <th class="border-top-0">COMMENT</th>
                                            <th class="border-top-0">TIME</th>
                                        </tr>
                                    </thead>


                                    <tbody>

                                        @if ($commentNew)
                                            <tr>

                                                <td class="txt-oflo">
                                                    {{ $commentNew->intern->mentor->user->name ?? 'Mentor' }}
                                                </td>


                                                <td class="txt-oflo">
                                                    {{ $commentNew->mentor_comment }}
                                                </td>


                                                <td class="txt-oflo">
                                                    {{ $commentNew->updated_at->diffForHumans() }}
                                                </td>

                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="3" class="empty-hint">
                                                    No mentor comments
                                                </td>
                                            </tr>
                                        @endif

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            &copy; {{ date('Y') }} Intern Management System.
        </footer>
    @endsection
