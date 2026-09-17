@extends('frontend_fn.layout.app')

@section('content')
    {{-- ============================================================== --}}
    {{-- Bread crumb --}}
    {{-- ============================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-5 align-self-center">
                <h4 class="page-title">Personal Profile</h4>
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                Profile
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    {{-- ============================================================== --}}
    {{-- End Bread crumb --}}
    {{-- ============================================================== --}}


    {{-- ============================================================== --}}
    {{-- Container fluid --}}
    {{-- ============================================================== --}}
    <div class="container-fluid">

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- ============================================================== --}}
        {{-- SECTION 1: Thông tin tổng quan --}}
        {{-- ============================================================== --}}
        <div class="row">

            <div class="col-12">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <a href="{{ route('frontend.intern.profile.edit', $intern->id) }}"
                                class="btn btn-outline-primary">

                                <i class="fa fa-edit"></i>
                                Edit Profile
                            </a>

                        </div>


                        <div class="d-flex align-items-center">

                            {{-- Avatar --}}
                            <div class="mr-4"
                                style="
                                    width:80px;
                                    height:80px;
                                    border-radius:50%;
                                    background:#7460ee;
                                    color:white;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-size:28px;
                                    font-weight:bold;
                                    flex-shrink:0;
                                ">

                                {{ strtoupper(substr($intern->full_name ?? '#', 0, 1)) }}

                            </div>


                            {{-- Basic info --}}
                            <div>

                                <h3 class="mb-2">
                                    {{ $intern->full_name ?? '#' }}
                                </h3>

                                <div class="text-muted mb-2">

                                    <i class="fa fa-envelope mr-1"></i>

                                    {{ $intern->user->email ?? '#@intern.ims.vn' }}

                                    <span class="mx-2">•</span>

                                    <i class="fa fa-graduation-cap mr-1"></i>

                                    {{ $intern->school ?? '#' }}

                                </div>

                                <span class="badge badge-success">
                                    {{ $intern->status ?? '#' }}
                                </span>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>


        {{-- ============================================================== --}}
        {{-- SECTION 2: Thông tin tài khoản --}}
        {{-- ============================================================== --}}
        <div class="row mt-4">

            <div class="col-12">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="card-title">
                            Account Information
                        </h4>

                        <hr>

                        <div class="row">

                            {{-- Username --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                    USERNAME
                                </small>

                                <strong>
                                    {{ $intern->user->name ?? '#' }}
                                </strong>

                            </div>


                            {{-- Email --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                    EMAIL
                                </small>

                                <strong>
                                    {{ $intern->user->email ?? '#@intern.ims.vn' }}
                                </strong>

                            </div>


                            {{-- Account Status --}}
                            <div class="col-md-6 mb-3">

                                <small class="text-muted d-block mb-1">
                                    ACCOUNT STATUS
                                </small>

                                @if (($user->status ?? 'active') === 'active')
                                    <span class="badge badge-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                @endif

                            </div>


                            {{-- Role --}}
                            <div class="col-md-6 mb-3">

                                <small class="text-muted d-block mb-1">
                                    ROLE
                                </small>

                                <strong class="text-info">
                                    Intern
                                </strong>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>


        {{-- ============================================================== --}}
        {{-- SECTION 3: Thông tin thực tập --}}
        {{-- ============================================================== --}}
        <div class="row mt-4">

            <div class="col-12">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="card-title">
                            Internship Information
                        </h4>

                        <hr>

                        <div class="row">

                            {{-- Full Name --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                    FULL NAME
                                </small>

                                <strong>
                                    {{ $intern->full_name ?? '#' }}
                                </strong>

                            </div>


                            {{-- School --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                    UNIVERSITY
                                </small>

                                <strong>
                                    {{ $intern->school ?? '#' }}
                                </strong>

                            </div>


                            {{-- Academic Year --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                    ACADEMIC YEAR
                                </small>

                                <strong>
                                    {{ $intern->academic_year ?? '#' }}
                                </strong>

                            </div>


                            {{-- Technology --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                    DESIRED TECHNOLOGY
                                </small>

                                <strong>
                                    {{ $intern->desired_technology ?? '#' }}
                                </strong>

                            </div>


                            {{-- Start Date --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                    START DATE
                                </small>

                                <strong>
                                    {{ $intern->start_date ? \Carbon\Carbon::parse($intern->start_date)->format('d/m/Y') : '#' }}
                                </strong>

                            </div>


                            {{-- End Date --}}
                            <div class="col-md-6 mb-4">

                                <small class="text-muted d-block mb-1">
                                   END DATE
                                </small>

                                <strong>
                                    {{ $intern->end_date ? \Carbon\Carbon::parse($intern->end_date)->format('d/m/Y') : '#' }}
                                </strong>

                            </div>


                            {{-- Internship Status --}}
                            <div class="col-md-6">

                                <small class="text-muted d-block mb-1">
                                    INTERNSHIP STATUS
                                </small>

                                <span class="badge badge-success">
                                    {{ $intern->status ?? '#' }}
                                </span>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>


        {{-- ============================================================== --}}
        {{-- SECTION 4: Mentor phụ trách --}}
        {{-- ============================================================== --}}
        <div class="row mt-4">

            <div class="col-12">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="card-title mb-4">
                            Assigned Mentor
                        </h4>


                        <div class="d-flex align-items-center">

                            {{-- Mentor Avatar --}}
                            <div class="mr-3"
                                style="
                                    width:55px;
                                    height:55px;
                                    border-radius:50%;
                                    background:#e8f5e9;
                                    color:#28a745;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    font-size:18px;
                                    font-weight:bold;
                                    flex-shrink:0;
                                ">

                                {{ strtoupper(substr($intern->mentor->full_name ?? '#', 0, 2)) }}

                            </div>


                            {{-- Mentor Information --}}
                            <div>

                                <h5 class="mb-1">
                                    {{ $intern->mentor->full_name ?? 'Chưa có Mentor' }}
                                </h5>

                                <div class="text-muted mb-1">

                                    {{ $intern->mentor->department ?? '#' }}

                                    <span class="mx-1">•</span>

                                    {{ $intern->mentor->position ?? '#' }}

                                </div>

                                <div class="text-info">

                                    <i class="fa fa-envelope mr-1"></i>

                                    {{ $intern->mentor->user->email ?? '#@company.vn' }}

                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>


    </div>
    {{-- ============================================================== --}}
    {{-- End Container fluid --}}
    {{-- ============================================================== --}}


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
