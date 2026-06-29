@extends('admin.layout.app')

@section('content')


<div class="page-breadcrumb">

    <div class="row">

        <div class="col-5 align-self-center">

            <h4 class="page-title">
                Mentor Profile
            </h4>

        </div>


        <div class="col-7 align-self-center">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb justify-content-end">

                    <li class="breadcrumb-item">
                        Home
                    </li>

                    <li class="breadcrumb-item">
                        Mentor Management
                    </li>

                    <li class="breadcrumb-item active">
                        Detail
                    </li>

                </ol>

            </nav>

        </div>


    </div>

</div>



<div class="container-fluid">


    {{-- Account + Profile --}}
    <div class="row">


        {{-- Account --}}
        <div class="col-md-6">

            <div class="card">


                <div class="card-body">


                    <h4 class="card-title">
                        Account Information
                    </h4>


                    <hr>


                    <label>
                        Username
                    </label>

                    <p>
                        {{ $mentor->user->name ?? 'N/A' }}
                    </p>



                    <label>
                        Email
                    </label>

                    <p>
                        {{ $mentor->user->email ?? 'N/A' }}
                    </p>



                    <label>
                        Account Status
                    </label>

                    <p>


                        @if($mentor->user->status == 'active')

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





        {{-- Mentor Information --}}
        <div class="col-md-6">


            <div class="card">


                <div class="card-body">


                    <h4 class="card-title">
                        Mentor Information
                    </h4>


                    <hr>



                    <label>
                        Full Name
                    </label>

                    <p>
                        {{ $mentor->full_name ?? 'N/A' }}
                    </p>



                    <label>
                        Department
                    </label>

                    <p>
                        {{ $mentor->department ?? 'N/A' }}
                    </p>



                    <label>
                        Position
                    </label>

                    <p>
                        {{ $mentor->position ?? 'N/A' }}
                    </p>



                </div>


            </div>


        </div>


    </div>





    {{-- Intern Management --}}
    <div class="card mt-4">


        <div class="card-body">


            <h4 class="card-title">
                Managed Interns
            </h4>


            <div class="table-responsive">


                <table class="table table-hover">


                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Technology</th>

                            <th>Status</th>

                        </tr>


                    </thead>



                    <tbody>


                    @forelse($mentor->interns as $intern)


                        <tr>


                            <td>
                                {{ $intern->id }}
                            </td>



                            <td>
                                {{ $intern->full_name ?? 'N/A' }}
                            </td>



                            <td>
                                {{ $intern->user->email ?? 'N/A' }}
                            </td>



                            <td>
                                {{ $intern->desired_technology ?? 'N/A' }}
                            </td>



                            <td>


                                @if($intern->status == 'Đang thực tập')

                                    <span class="badge badge-info">
                                        {{ $intern->status }}
                                    </span>

                                @else

                                    <span class="badge badge-success">
                                        {{ $intern->status }}
                                    </span>

                                @endif


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td colspan="5" class="text-center">

                                No intern assigned

                            </td>


                        </tr>


                    @endforelse



                    </tbody>


                </table>


            </div>


        </div>


    </div>





    {{-- Task Management --}}
    <div class="card mt-4">


        <div class="card-body">


            <h4 class="card-title">
                Assigned Tasks
            </h4>


            <div class="table-responsive">


                <table class="table table-hover">


                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Task Name</th>

                            <th>Intern</th>

                            <th>Status</th>

                            <th>Deadline</th>


                        </tr>


                    </thead>



                    <tbody>


                    @forelse($mentor->tasks as $task)


                        <tr>


                            <td>
                                {{ $task->id }}
                            </td>



                            <td>
                                {{ $task->title ?? 'N/A' }}
                            </td>



                            <td>
                                {{ $task->intern->full_name ?? 'N/A' }}
                            </td>



                            <td>


                                @if($task->status == 'Completed')


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

                                No task assigned

                            </td>


                        </tr>


                    @endforelse



                    </tbody>


                </table>


            </div>


        </div>


    </div>





    <div class="mt-3">


        <a href="{{ route('admin.mentor.index') }}"
            class="btn btn-secondary">

            Back

        </a>


    </div>



</div>



<footer class="footer text-center">
    All Rights Reserved by Nice admin.
</footer>


@endsection