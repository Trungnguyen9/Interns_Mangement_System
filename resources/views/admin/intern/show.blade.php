@extends('admin.layout.app')

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



    <div class="container-fluid">


        <div class="row">


            <!-- Account Information -->
            <div class="col-md-6">

                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title">
                            Account Information
                        </h4>


                        <hr>


                        <div class="form-group">

                            <label>
                                Username:
                            </label>

                            <p class="form-control-static">
                                {{ $intern->user->name ?? 'N/A' }}
                            </p>

                        </div>



                        <div class="form-group">

                            <label>
                                Email:
                            </label>

                            <p class="form-control-static">
                                {{ $intern->user->email ?? 'N/A' }}
                            </p>

                        </div>



                        <div class="form-group">

                            <label>
                                Account Status:
                            </label>

                            <p>

                                @if ($intern->user->status == 'active')
                                    <span class="badge badge-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        Inactive
                                    </span>
                                @endif

                            </p>

                        </div>


                    </div>

                </div>

            </div>




            <!-- Intern Information -->
            <div class="col-md-6">

                <div class="card">

                    <div class="card-body">


                        <h4 class="card-title">
                            Intern Information
                        </h4>


                        <hr>



                        <div class="form-group">

                            <label>
                                Full Name:
                            </label>

                            <p>
                                {{ $intern->full_name ?? 'N/A' }}
                            </p>

                        </div>



                        <div class="form-group">

                            <label>
                                School:
                            </label>

                            <p>
                                {{ $intern->school ?? 'N/A' }}
                            </p>

                        </div>



                        <div class="form-group">

                            <label>
                                Academic Year:
                            </label>

                            <p>
                                {{ $intern->academic_year ?? 'N/A' }}
                            </p>

                        </div>



                        <div class="form-group">

                            <label>
                                Desired Technology:
                            </label>

                            <p>
                                {{ $intern->desired_technology ?? 'N/A' }}
                            </p>

                        </div>


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
                                    {{ $intern->start_date }}
                                </p>

                            </div>



                            <div class="col-md-4">

                                <label>
                                    End Date:
                                </label>

                                <p>
                                    {{ $intern->end_date }}
                                </p>

                            </div>



                            <div class="col-md-4">

                                <label>
                                    Internship Status:
                                </label>

                                <p>

                                    @if ($intern->status == 'Đang thực tập')
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
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>


                        <tbody>

                            @forelse($intern->tasks as $task)
                                <tr>

                                    <td>
                                        {{ $task->id }}
                                    </td>


                                    <td>
                                        {{ $task->title ?? 'N/A' }}
                                    </td>


                                    <td>
                                        {{ $task->description ?? 'N/A' }}
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
                                <th>Completed Tasks</th>
                                <th>Difficulties</th>
                                <th>Next Plan</th>
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
                                        {{ $report->week_start_date }}
                                        <br>
                                        -
                                        <br>
                                        {{ $report->week_end_date }}
                                    </td>


                                    <td>
                                        {{ Str::limit($report->completed_tasks, 80) }}
                                    </td>


                                    <td>
                                        {{ Str::limit($report->difficulties, 80) }}
                                    </td>


                                    <td>
                                        {{ Str::limit($report->next_plan, 80) }}
                                    </td>


                                    <td>
                                        {{ Str::limit($report->mentor_comment ?? 'No comment', 80) }}
                                    </td>


                                    <td>
                                        {{ $report->created_at->format('d/m/Y') }}
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


                </div>


            </div>

        </div>

        <!-- Mentor Information -->

        <div class="row">

            <div class="col-md-12">


                <div class="card">


                    <div class="card-body">


                        <h4 class="card-title">
                            Mentor Information
                        </h4>


                        <hr>



                        @if ($intern->mentor)
                            <div class="row">


                                <div class="col-md-6">

                                    <label>
                                        Mentor Name:
                                    </label>


                                    <p>
                                        {{ $intern->mentor->user->name ?? 'N/A' }}
                                    </p>


                                </div>



                                <div class="col-md-6">

                                    <label>
                                        Mentor Email:
                                    </label>


                                    <p>
                                        {{ $intern->mentor->user->email ?? 'N/A' }}
                                    </p>


                                </div>


                            </div>
                        @else
                            <p>
                                No mentor assigned
                            </p>
                        @endif


                    </div>


                </div>


            </div>


        </div>




        <div class="row">

            <div class="col-12">


                <a href="{{ route('admin.intern.edit', $intern->id) }}" class="btn btn-primary">

                    <i class="fa-solid fa-edit"></i>
                    Edit

                </a>



                <a href="{{ route('admin.intern.index') }}" class="btn btn-secondary">

                    Back

                </a>


            </div>


        </div>



    </div>



    <footer class="footer text-center">
        All Rights Reserved by Nice admin.
    </footer>
@endsection
