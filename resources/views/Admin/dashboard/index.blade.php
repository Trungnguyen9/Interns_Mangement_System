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
        {{-- SECTION 1: Intern / Mentor / Task tổng quan --}}
        {{-- ============================================================== --}}
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-blue"><i class="ti-id-badge"></i></div>
                        <div>
                            <div class="stat-label">Tổng số Intern</div>
                            <p class="stat-value">{{ $totalInterns }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-teal"><i class="ti-time"></i></div>
                        <div>
                            <div class="stat-label">Đang thực tập</div>
                            <p class="stat-value">{{ $ongoingInterns }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-purple"><i class="ti-crown"></i></div>
                        <div>
                            <div class="stat-label">Tổng số Mentor</div>
                            <p class="stat-value">{{ $totalMentors }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-indigo"><i class="ti-clipboard"></i></div>
                        <div>
                            <div class="stat-label">Tổng số Task</div>
                            <p class="stat-value">{{ $totalTasks }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ============================================================== --}}
        {{-- END SECTION 1 --}}
        {{-- ============================================================== --}}


        {{-- ============================================================== --}}
        {{-- SECTION 2: Task chờ review / hoàn thành / Report chưa review / gần deadline --}}
        {{-- ============================================================== --}}
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-orange"><i class="ti-eye"></i></div>
                        <div>
                            <div class="stat-label">Task chờ review</div>
                            <p class="stat-value">{{ $pendingReviewTasks }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-green"><i class="ti-check"></i></div>
                        <div>
                            <div class="stat-label">Task đã hoàn thành</div>
                            <p class="stat-value">{{ $completedTasks }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-pink"><i class="ti-file"></i></div>
                        <div>
                            <div class="stat-label">Báo cáo tuần chưa review</div>
                            <p class="stat-value">{{ $pendingReports }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <div class="stat-icon bg-red"><i class="ti-alarm-clock"></i></div>
                        <div>
                            <div class="stat-label">Task gần deadline</div>
                            <p class="stat-value">{{ $nearDeadlineTasksCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ============================================================== --}}
        {{-- END SECTION 2 --}}
        {{-- ============================================================== --}}


        {{-- ============================================================== --}}
        {{-- SECTION 3: Danh sách Task gần deadline --}}
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
                                                        ? now()->diffInDays($task->deadline, false)
                                                        : null;
                                                @endphp
                                                @if (!is_null($daysLeft) && $daysLeft <= 1)
                                                    <span class="label-rounded badge-deadline-urgent">Còn
                                                        {{ max($daysLeft, 0) }} ngày</span>
                                                @else
                                                    <span class="label-rounded badge-deadline-soon">Còn {{ $daysLeft }}
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
                                                <td colspan="5" class="empty-hint">Không có task nào gần deadline</td>
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

    @push('styles')
        <style>
            .stat-card .card-body {
                display: flex;
                align-items: center;
                padding: 20px;
            }

            .stat-icon {
                width: 54px;
                height: 54px;
                min-width: 54px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                color: #fff;
                margin-right: 15px;
            }

            .stat-label {
                color: #90a4ae;
                font-size: 13px;
                margin-bottom: 2px;
                text-transform: uppercase;
                letter-spacing: .3px;
            }

            .stat-value {
                font-size: 26px;
                font-weight: 500;
                margin: 0;
                color: #37474f;
            }

            .bg-blue {
                background-color: #1e88e5;
            }

            .bg-teal {
                background-color: #26c6da;
            }

            .bg-purple {
                background-color: #7460ee;
            }

            .bg-indigo {
                background-color: #5c6bc0;
            }

            .bg-orange {
                background-color: #ffb22b;
            }

            .bg-green {
                background-color: #2dce89;
            }

            .bg-red {
                background-color: #ef5350;
            }

            .bg-pink {
                background-color: #ec407a;
            }

            .label-rounded {
                border-radius: 30px;
                padding: 4px 12px;
                font-size: 12px;
                font-weight: 500;
                display: inline-block;
            }

            .badge-deadline-urgent {
                background-color: #fdecea;
                color: #ef5350;
            }

            .badge-deadline-soon {
                background-color: #fff8e1;
                color: #f9a825;
            }

            .empty-hint {
                color: #b0bec5;
                text-align: center;
                padding: 30px 0;
            }
        </style>
    @endpush
