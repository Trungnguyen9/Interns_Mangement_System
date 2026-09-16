@extends('frontend_fn.layout.app')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Interns Management</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Interns Management</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">My Interns</h4>
                        <div class="page-sub">List of Interns You Are Mentoring ({{ $currentInterns ?? 0 }} /
                            {{ $data->max_interns }} slot)</div>
                        @if ($currentInterns >= $data->max_interns)
                            <div class="capacity-warning">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                <span>You have reached the maximum number of interns you can mentor
                                    ({{ $data->max_interns }} interns).
                                    Please contact the Admin if you need to be assigned more interns.</span>
                            </div>
                        @endif
                    </div>
                    {{-- Bộ lọc --}}
                    <div class="card-body">
                        <form method="GET" action="{{ route('frontend.mentor.interns') }}" class="row mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-md-8"
                                    placeholder="Search by name or email" value="{{ request('search') }}">
                                <select name="status" class="form-control col-md-4 ">
                                    <option value="">All Status</option>
                                    <option value="Ongoing Interns"
                                        {{ request('status') == 'Ongoing Interns' ? 'selected' : '' }}>Ongoing Interns
                                    </option>
                                    <option value="Completed Interns"
                                        {{ request('status') == 'Completed Interns' ? 'selected' : '' }}>Completed Interns
                                    </option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{--  --}}

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Intern</th>
                                    <th scope="col">Academic</th>
                                    <th scope="col">Technology</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($interns as $intern)
                                    <tr>
                                        <td>{{ $intern->full_name ?? 'N/A' }}</td>
                                        <td>{{ $intern->school ?? 'N/A' }}</td>
                                        <td>{{ $intern->desired_technology ?? 'N/A' }}</td>
                                        <td>{{ $intern->start_date ?? 'N/A' }}</td>
                                        <td>{{ $intern->end_date ?? 'N/A' }}</td>
                                        <td>
                                            @if ($intern->status === 'Ongoing Interns')
                                                <span class="badge doing">{{ $intern->status }}</span>
                                            @else
                                                <span class="badge done">{{ $intern->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('frontend.mentor.interns.show', $intern->id) }}"
                                                class="btn btn-info"><i class="fa-solid fa-eye"></i> Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            {{ $interns->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
        All Rights Reserved by Nice admin. Designed and Developed by
        <a href="https://wrappixel.com">WrapPixel</a>.
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
@endsection
