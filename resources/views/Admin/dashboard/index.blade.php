@extends('admin.layout.app')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
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
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
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
        {{-- SECTION 2: Danh sách Task gần deadline --}}
        {{-- ============================================================== --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Task Gần Deadline</h4>
                            <span class="text-muted" style="font-size:13px;">Sắp xếp theo hạn gần nhất</span>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">TASK</th>
                                        <th class="border-top-0">INTERN</th>
                                        <th class="border-top-0">MENTOR</th>
                                        <th class="border-top-0">DEADLINE</th>
                                        <th class="border-top-0">THỜI GIAN CÒN LẠI</th>
                                        <th class="border-top-0">TRẠNG THÁI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($nearDeadlineTasksList as $task)
                                        <tr>
                                            <td class="txt-oflo">{{ $task->title }}</td>
                                            <td class="txt-oflo">
                                                {{ $task->intern->full_name ?? '-' }}</td>
                                            <td class="txt-oflo">
                                                {{ $task->intern->mentor->full_name ?? '-' }}
                                            </td>
                                            <td class="txt-oflo">
                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') ?? '-' }}
                                            </td>
                                            <td>
                                                @php
                                                    $daysLeft = $task->deadline
                                                        ? today()->diffInDays($task->deadline, false)
                                                        : null;
                                                @endphp
                                                @if (!is_null($daysLeft) && $daysLeft <= 1)
                                                    <span class="dashboard-deadline-badge badge-deadline-urgent">Còn
                                                        {{ (int) $daysLeft }} ngày</span>
                                                @else
                                                    <span class="dashboard-deadline-badge badge-deadline-soon">Còn
                                                        {{ (int) $daysLeft }}
                                                        ngày</span>
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
                                                <td colspan="6" class="empty-hint">Không có task nào gần deadline</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <a href="{{ route('admin.tasks.index') }}">
                                    Xem tất cả
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ============================================================== --}}
            {{-- END SECTION 3 --}}
            {{-- ============================================================== --}}

        </div>

        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            &copy; {{ date('Y') }} Intern Management System.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    @endsection
