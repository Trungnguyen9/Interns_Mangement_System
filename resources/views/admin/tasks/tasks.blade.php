@extends('admin.layout.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Quản lý Task</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/adminpage') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Task</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        {{-- ============================================================== --}}
        {{-- Thẻ tổng quan --}}
        {{-- ============================================================== --}}
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 ">Tổng task</h5>
                        <h2 class="font-light m-b-0">{{ $stats['total'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 ">Đang làm</h5>
                        <h2 class="font-light m-b-0">{{ $stats['doing'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 ">Chờ review</h5>
                        <h2 class="font-light m-b-0">{{ $stats['review'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 text-danger">Quá hạn</h5>
                        <h2 class="font-light m-b-0 text-danger">{{ $stats['overdue'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================== --}}
        {{-- Bộ lọc --}}
        {{-- ============================================================== --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.tasks.index') }}">
                            <div class="row align-items-end">
                                <div class="col-md-6 col-sm-12 form-group">
                                    <label class="font-14 text-muted">Tìm kiếm</label>
                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                                        placeholder="Tên task, intern, mentor...">
                                </div>
                                <div class="col-md-2 col-sm-4 form-group">
                                    <label class="font-14 text-muted">Mentor</label>
                                    <select name="mentor_id" class="form-control">
                                        <option value="">Tất cả</option>
                                        @foreach ($mentors as $mentor)
                                            <option value="{{ $mentor->id }}" @selected(request('mentor_id') == $mentor->id)>
                                                {{ $mentor->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-4 form-group">
                                    <label class="font-14 text-muted">Intern</label>
                                    <select name="intern_id" class="form-control">
                                        <option value="">Tất cả</option>
                                        @foreach ($interns as $intern)
                                            <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>
                                                {{ $intern->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-4 form-group">
                                    <label class="font-14 text-muted">Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="todo" @selected(request('status') == 'todo')>Todo</option>
                                        <option value="doing" @selected(request('status') == 'doing')>Doing</option>
                                        <option value="review" @selected(request('status') == 'review')>Review</option>
                                        <option value="done" @selected(request('status') == 'done')>Done</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row align-items-end">
                                <div class="col-md-3 col-sm-6 form-group m-b-0">
                                    <label class="font-14 text-muted">Deadline từ</label>
                                    <input type="date" name="deadline_from" value="{{ request('deadline_from') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-3 col-sm-6 form-group m-b-0">
                                    <label class="font-14 text-muted">Đến ngày</label>
                                    <input type="date" name="deadline_to" value="{{ request('deadline_to') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 form-group m-b-0">
                                    <div class="d-flex justify-content-end" style="gap: 8px;">
                                        <button type="submit" class="btn btn-info waves-effect waves-light">
                                            <i class="fas fa-filter"></i> Lọc
                                        </button>
                                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-sync-alt"></i> Đặt lại
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================== --}}
        {{-- Bảng danh sách task --}}
        {{-- ============================================================== --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách task</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="border-top-0">TASK</th>
                                    <th class="border-top-0">INTERN</th>
                                    <th class="border-top-0">MENTOR</th>
                                    <th class="border-top-0">HẠN CHÓT</th>
                                    <th class="border-top-0">TRẠNG THÁI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                    @php
                                        $statusMap = [
                                            'Todo' => ['Todo', 'default'],
                                            'Doing' => ['Doing', 'info'],
                                            'Review' => ['Review', 'warning'],
                                            'Done' => ['Done', 'success'],
                                        ];
                                        [$statusLabel, $statusColor] = $statusMap[$task->status] ?? ['—', 'default'];
                                    @endphp
                                    <tr class="{{ $task->is_overdue ? 'table-danger' : '' }}" style="cursor:pointer">
                                        <td class="txt-oflo">{{ $task->title }}</td>
                                        <td class="txt-oflo">{{ $task->intern->user->name ?? '—' }}</td>
                                        <td class="txt-oflo">{{ $task->intern->mentor->user->name ?? '—' }}</td>
                                        <td class="txt-oflo">
                                            {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') ?? '—' }}
                                            @if ($task->is_overdue)
                                                <span class="label label-danger label-rounded">Quá hạn</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="label label-{{ $statusColor }} label-rounded">{{ $task->status ?? '—' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted p-4">Không có task nào phù hợp.
                                        </td>
                                    </tr>
                                @endforelse
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
@endsection
