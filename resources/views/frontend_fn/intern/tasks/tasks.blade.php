@extends('frontend_fn.layout.app')
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
                <h4 class="page-title">Tasks List</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tasks List</li>
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
        {{-- SECTION 1: Tổng quan --}}
        {{-- ============================================================== --}}
        <div class="row">
            @foreach ($stats as $stat)
                <div class="col-md-6 col-lg mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-2">
                                        {{ $stat['title'] }}
                                    </h6>
                                    <h2 class="font-weight-bold mb-0">
                                        {{ $stat['value'] }}
                                    </h2>
                                </div>
                                <div class="text-{{ $stat['color'] }}">
                                    <i class="{{ $stat['icon'] }} display-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- Bộ lọc --}}
                    <div class="card-body">
                        <form method="GET" action="{{ route('frontend.intern.tasks') }}" class="row mb-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="search" class="form-control col-md-8"
                                    placeholder="Search by name or email" value="{{ request('search') }}">
                                <select name="status" class="form-control col-md-2 ">
                                    <option value="">All Status</option>
                                    <option value="Todo" @selected(request('status') === 'Todo')>Pending</option>
                                    <option value="Doing" @selected(request('status') === 'Doing')>Doing</option>
                                    <option value="Review" @selected(request('status') === 'Review')>Review</option>
                                    <option value="Done" @selected(request('status') === 'Done')>Done</option>
                                    <option value="Overdue" @selected(request('status') === 'Overdue')>Overdue</option>
                                </select>
                                <select name="priority" class="form-control col-md-2 ">
                                    <option value="">All Priorities</option>
                                    <option value="high" @selected(request('priority') === 'high')>High</option>
                                    <option value="medium" @selected(request('priority') === 'medium')>Medium</option>
                                    <option value="low" @selected(request('priority') === 'low')>Low</option>
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
                                    <th scope="col">No.</th>
                                    <th scope="col">Task Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Priority</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td
                                            class="{{ $item->is_overdue ? 'deadline-over' : '' }}
                                                {{ $item->is_near_deadline ? 'deadline-near' : '' }}">
                                            {{ $item->deadline }} {{ $item->is_overdue ? '⚠' : '' }}
                                        </td>
                                        <td><span class="badge pri-{{ $item->priority }}">{{ $item->priority }}</span>
                                        </td>
                                        <td><span id="status-badge-{{ $item->id }}"
                                                class="badge {{ $item->status }}">{{ $item->status }}</span></td>
                                        <td>
                                            <button class="btn btn-outline" onclick="showTaskDetail({{ $item->id }})">
                                                <i class="fa-solid fa-eye"></i>
                                                Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            {{ $tasks->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Task detail modal --}}
    <div id="task-detail-modal" class="modal-overlay2 hidden">
        <div class="modal-box">
            <button class="modal-close" onclick="closeTaskDetail()">×</button>
            <div id="task-detail-content">
                {{-- Blade partial sẽ được JS chèn vào đây --}}
            </div>
        </div>
    </div>
@endsection
