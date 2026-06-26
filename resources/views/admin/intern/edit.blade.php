@extends('admin.layout.app')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Intern</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Intern</li>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $intern->user_id }}">
                            <div class="form-group">
                                <label class="col-md-12">User Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="User Name"
                                        class="form-control form-control-line" value="{{ $intern->user->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Full Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="full_name" placeholder="Full Name"
                                        class="form-control form-control-line" value="{{ $intern->full_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Email <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="email" name="email" placeholder="Email"
                                        class="form-control form-control-line" value="{{ $intern->user->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">School</label>
                                <div class="col-md-12">
                                    <input type="text" name="school" placeholder="School"
                                        class="form-control form-control-line" value="{{ $intern->school }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Academic Year</label>
                                <div class="col-md-12">
                                    <input type="text" name="academic_year" placeholder="Academic Year"
                                        class="form-control form-control-line" value="{{ $intern->academic_year }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Desired Technology</label>
                                <div class="col-md-12">
                                    <input type="text" name="desired_technology" placeholder="Desired Technology"
                                        class="form-control form-control-line" value="{{ $intern->desired_technology }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Start Date <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="date" name="start_date" placeholder="Start Date"
                                        class="form-control form-control-line" value="{{ $intern->start_date }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">End Date <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="date" name="end_date" placeholder="End Date"
                                        class="form-control form-control-line" value="{{ $intern->end_date }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Status <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <select name="status" class="form-control form-control-line">
                                        <option value="Đang thực tập" @if ($intern->status == 'Đang thực tập') selected @endif>
                                            Đang thực tập
                                        </option>


                                        <option value="Đã hoàn thành" @if ($intern->status == 'Đã hoàn thành') selected @endif>
                                            Đã hoàn thành
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Mentor</label>
                                <div class="col-md-12">
                                    <select name="mentor_id" class="form-control">


                                        <option value="">
                                            Select Mentor
                                        </option>


                                        @foreach ($mentors as $mentor)
                                            <option value="{{ $mentor->id }}"
                                                @if ($intern->mentor_id == $mentor->id) selected @endif>

                                                {{ $mentor->user->name }}

                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.intern.index') }}" class="btn btn-secondary">Back</a>

                                    <button type="submit" class="btn btn-success">Edit Intern</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
