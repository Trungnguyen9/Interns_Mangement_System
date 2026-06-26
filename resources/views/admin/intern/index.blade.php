@extends('admin.layout.app')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
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
                        <h4 class="card-title">Interns</h4>
                        {{-- <h6 class="card-subtitle">Admin: 1; Mentor: 2; Intern: 3</h6> --}}
                        <a href="{{ route('admin.intern.create') }}" class="btn btn-success">Add New</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mentor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $intern)
                                    @if ($intern->role->id == '3')
                                        <tr>
                                            <th scope="row">{{ $intern->id }}</th>
                                            <td>{{ $intern->internProfile->full_name ?? 'N/A' }}</td>
                                            <td>{{ $intern->email }}</td>
                                            <td>{{ $intern->mentorProfile->full_name ?? 'N/A' }}</td>
                                            <td>{{ $intern->status }}</td>
                                            <td>
                                                <a href="{{ route('admin.intern.edit', $intern->id) }}"
                                                    class="btn btn-primary"><i class="fa-solid fa-edit"></i> Edit</a>
                                                <form action="{{ route('admin.intern.destroy', $intern->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa-solid fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.intern.show', $intern->id) }}"
                                                    class="btn btn-info"><i class="fa-solid fa-eye"></i> Details</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
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
