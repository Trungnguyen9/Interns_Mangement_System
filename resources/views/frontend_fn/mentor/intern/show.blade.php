@extends('frontend_fn.layout.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-5 align-self-center">
                <h4 class="page-title">
                    Intern Profile
                </h4>
            </div>


            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    Home
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                Intern Management
                            </li>

                            <li class="breadcrumb-item active">
                                Detail
                            </li>

                        </ol>

                    </nav>

                </div>

            </div>

        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div
                style="display:flex; align-items:center; gap:16px; margin-bottom:20px; background-color:#fff; padding:16px; border-radius:8px;">

                {{-- Back Link --}}
                {{-- Avatar --}}
                <div class="mini-avatar lg">
                    {{ strtoupper(substr($intern->full_name ?? 'NA', 0, 2)) }}
                </div>

                {{-- Intern Information --}}
                <div style="flex:1">

                    <div style="font-size:15px; font-weight:600;">
                        {{ $intern->full_name ?? 'N/A' }}
                    </div>

                    <div class="text-muted" style="font-size:13px;">
                        {{ $intern->user->email ?? 'N/A' }}
                        &middot;
                        {{ $intern->school ?? 'N/A' }}
                    </div>

                </div>

                {{-- Status --}}
                @if ($intern->status === 'Ongoing Interns')
                    <span class="badge doing">
                        {{ $intern->status }}
                    </span>
                @else
                    <span class="badge done">
                        {{ $intern->status }}
                    </span>
                @endif

            </div>
        </div>
    </div>

    <div class="row">
        <!-- Desired Technology -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <small class="text-muted">
                        Desired Technology
                    </small>

                    <h6 class="mt-2 mb-0">
                        {{ $intern->desired_technology ?? 'N/A' }}
                    </h6>

                </div>
            </div>
        </div>


        <!-- Academic Year -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <small class="text-muted">
                        Academic Year
                    </small>

                    <h6 class="mt-2 mb-0">
                        {{ $intern->academic_year ?? 'N/A' }}
                    </h6>

                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <!-- Internship Information -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        Internship Information
                    </h4>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">

                            <label>
                                Start Date:
                            </label>

                            <p>
                                {{ \Carbon\Carbon::parse($intern->start_date)->format('d/m/Y') ?? '__' }}
                            </p>

                        </div>

                        <div class="col-md-4">
                            <label>
                                End Date:
                            </label>

                            <p>
                                {{ \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') ?? '__' }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <label>
                                Internship Status:
                            </label>
                            <p>
                                @if ($intern->status == 'Ongoing Interns')
                                    <span class="badge badge-info">
                                        {{ $intern->status }}
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        {{ $intern->status }}
                                    </span>
                                @endif
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Task List --}}
    <div class="card mt-4">
        <div class="card-body">

            <h4 class="card-title">
                Task List
            </h4>

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Deadline</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($intern->tasks as $task)
                            <tr>
                                <td>
                                    {{ $task->title ?? 'N/A' }}
                                </td>

                                <td>

                                    @if ($task->status == 'Completed')
                                        <span class="badge badge-success">
                                            Completed
                                        </span>
                                    @elseif($task->status == 'Doing')
                                        <span class="badge badge-warning">
                                            Doing
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            {{ $task->status }}
                                        </span>
                                    @endif

                                </td>


                                <td>
                                    {{ $task->deadline ?? 'N/A' }}
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    No task available
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
                <div style="margin-top:10px"><a href="{{ route('frontend.mentor.tasks.show', $intern->id) }}"
                        style="font-size:12px;color:#4a6cf7;text-decoration:none">Tasks management →</a></div>
            </div>
        </div>
    </div>

    {{-- Weekly Report List --}}
    <div class="card mt-4">
        <div class="card-body">

            <h4 class="card-title">
                Weekly Reports
            </h4>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Week</th>
                            <th>Mentor Comment</th>
                            <th>Created At</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($intern->weeklyReports as $report)
                            <tr>
                                <td>
                                    {{ $report->id }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($report->week_start_date)->format('d/m/Y') }}
                                    <br>
                                    -
                                    <br>
                                    {{ \Carbon\Carbon::parse($report->week_end_date)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ Str::limit($report->mentor_comment ?? 'No comment', 80) }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    No weekly report available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div style="margin-top:10px"><a href="{{ route('frontend.mentor.reports') }}"
                        style="font-size:12px;color:#4a6cf7;text-decoration:none">Show all reports →</a></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <a href="{{ route('frontend.mentor.interns') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>
    </div>


    <footer class="footer text-center">
        All Rights Reserved by Nice admin.
    </footer>
@endsection
