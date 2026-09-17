@extends('frontend_fn.layout.app')

@section('content')

    {{-- ============================================================== --}}
    {{-- Bread crumb --}}
    {{-- ============================================================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Profile</h4>
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">

                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ route('frontend.profile.index') }}">
                                    Profile
                                </a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Profile
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

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form id="profile-edit-form" method="POST">
            @csrf

            <input type="hidden"
                name="user_id"
                value="{{ $intern->user_id }}">


            {{-- ============================================================== --}}
            {{-- SECTION 1: Header + Action --}}
            {{-- ============================================================== --}}
            <div class="row">

                <div class="col-12">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <h4 class="card-title mb-1">
                                        Edit Personal Information
                                    </h4>

                                    <small class="text-muted">
                                       Update account information and internship information
                                    </small>
                                </div>


                                <div>

                                    <button type="button"
                                        class="btn btn-outline-secondary mr-2"
                                        onclick="window.history.back()">

                                        <i class="fa fa-times mr-1"></i>
                                        Cancel

                                    </button>


                                    <button type="submit"
                                        class="btn btn-primary">

                                        <i class="fa fa-save mr-1"></i>
                                        Save Changes

                                    </button>

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

                            <small class="text-muted">
                                Login information and account privileges
                            </small>

                            <hr>


                            <div class="row">

                                {{-- Username --}}
                                <div class="col-md-6 mb-4">

                                    <label for="name"
                                        class="text-muted d-block mb-1">

                                        USERNAME

                                    </label>

                                    <input type="text"
                                        id="name"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $intern->user->name) }}"
                                        placeholder="Username">

                                </div>


                                {{-- Email --}}
                                <div class="col-md-6 mb-4">

                                    <label class="text-muted d-block mb-1">
                                        EMAIL
                                    </label>

                                    <input type="text"
                                        class="form-control"
                                        value="{{ $intern->user->email ?? '#@intern.ims.vn' }}"
                                        readonly>

                                </div>


                                {{-- Account Status --}}
                                <div class="col-md-6 mb-3">

                                    <small class="text-muted d-block mb-2">
                                        ACCOUNT STATUS
                                    </small>

                                    @if (($intern->user->status ?? 'active') === 'active')

                                        <span class="badge badge-success">
                                            Active
                                        </span>

                                    @else

                                        <span class="badge badge-danger">
                                            {{ ucfirst($intern->user->status ?? 'inactive') }}
                                        </span>

                                    @endif

                                </div>


                                {{-- Role --}}
                                <div class="col-md-6 mb-3">

                                    <small class="text-muted d-block mb-2">
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

                            <small class="text-muted">
                                Update personal information and internship progress
                            </small>

                            <hr>


                            <div class="row">

                                {{-- Full Name --}}
                                <div class="col-md-6 mb-4">

                                    <label for="full_name"
                                        class="text-muted d-block mb-1">

                                        FULL NAME

                                    </label>

                                    <input type="text"
                                        id="full_name"
                                        name="full_name"
                                        class="form-control"
                                        value="{{ old('full_name', $intern->full_name) }}"
                                        placeholder="Full Name">

                                </div>


                                {{-- School --}}
                                <div class="col-md-6 mb-4">

                                    <label for="school"
                                        class="text-muted d-block mb-1">

                                        UNIVERSITY

                                    </label>

                                    <input type="text"
                                        id="school"
                                        name="school"
                                        class="form-control"
                                        value="{{ old('school', $intern->school) }}"
                                        placeholder="University">

                                </div>


                                {{-- Academic Year --}}
                                <div class="col-md-6 mb-4">

                                    <label for="academic_year"
                                        class="text-muted d-block mb-1">

                                        ACADEMIC YEAR

                                    </label>

                                    <input type="text"
                                        id="academic_year"
                                        name="academic_year"
                                        class="form-control"
                                        value="{{ old('academic_year', $intern->academic_year) }}"
                                        placeholder="Academic Year">

                                </div>


                                {{-- Desired Technology --}}
                                <div class="col-md-6 mb-4">

                                    <label for="desired_technology"
                                        class="text-muted d-block mb-1">

                                        DESIRED TECHNOLOGY

                                    </label>

                                    <input type="text"
                                        id="desired_technology"
                                        name="desired_technology"
                                        class="form-control"
                                        value="{{ old('desired_technology', $intern->desired_technology) }}"
                                        placeholder="Desired Technology">

                                </div>


                                {{-- Start Date --}}
                                <div class="col-md-6 mb-4">

                                    <label for="start_date"
                                        class="text-muted d-block mb-1">

                                        START DATE

                                    </label>

                                    <input type="date"
                                        id="start_date"
                                        name="start_date"
                                        class="form-control"
                                        value="{{ old(
                                            'start_date',
                                            $intern->start_date
                                                ? \Carbon\Carbon::parse($intern->start_date)->format('Y-m-d')
                                                : ''
                                        ) }}">

                                </div>


                                {{-- End Date --}}
                                <div class="col-md-6 mb-4">

                                    <label for="end_date"
                                        class="text-muted d-block mb-1">

                                        END DATE

                                    </label>

                                    <input type="date"
                                        id="end_date"
                                        name="end_date"
                                        class="form-control"
                                        value="{{ old(
                                            'end_date',
                                            $intern->end_date
                                                ? \Carbon\Carbon::parse($intern->end_date)->format('Y-m-d')
                                                : ''
                                        ) }}">

                                </div>


                                {{-- Internship Status --}}
                                <div class="col-md-6">

                                    <small class="text-muted d-block mb-2">
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

        </form>

    </div>
    {{-- ============================================================== --}}
    {{-- End Container fluid --}}
    {{-- ============================================================== --}}


    {{-- ============================================================== --}}
    {{-- Footer --}}
    {{-- ============================================================== --}}
    <footer class="footer text-center">
        &copy; {{ date('Y') }} Intern Management System.
    </footer>

@endsection