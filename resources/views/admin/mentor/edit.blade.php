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
                <h4 class="page-title">Edit Mentor</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Mentor</li>
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
                            <input type="hidden" name="user_id" value="{{ $mentor->user_id }}">
                            <div class="form-group">
                                <label class="col-md-12">User Name <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="User Name"
                                        class="form-control form-control-line" value="{{ $mentor->user->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Full Name</label>
                                <div class="col-md-12">
                                    <input type="text" name="full_name" placeholder="Full Name"
                                        class="form-control form-control-line" value="{{ $mentor->full_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Email <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="email" name="email" placeholder="Email"
                                        class="form-control form-control-line" value="{{ $mentor->user->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Department</label>
                                <div class="col-md-12">
                                    <input type="text" name="department" placeholder="Department"
                                        class="form-control form-control-line" value="{{ $mentor->department }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Position</label>
                                <div class="col-md-12">
                                    <input type="text" name="position" placeholder="Position"
                                        class="form-control form-control-line" value="{{ $mentor->position }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Max Interns <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="number" name="max_interns" placeholder="Max Interns"
                                        class="form-control form-control-line" value="{{ $mentor->max_interns }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <a href="{{ route('admin.mentor.index') }}" class="btn btn-secondary">Back</a>

                                    <button type="submit" class="btn btn-success">Edit Mentor</button>
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
