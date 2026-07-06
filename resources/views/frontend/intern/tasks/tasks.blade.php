@extends('frontend.intern.layouts.intern')

@section('title', 'Tasks')
@section('breadcrumb', 'Tasks')

@section('content')
    <div style="margin-bottom:20px">
        <div class="page-title">Danh sách Tasks</div>
        <div class="page-sub">Công việc được mentor giao</div>
    </div>

    {{-- Mini stats --}}
    <div class="grid-4">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:var(--c-primary-l);color:var(--c-primary)"><i
                    class="fa-solid fa-layer-group"></i></div>
            <div>
                <div style="font-size:11px;color:var(--c-text-sub)">Tất cả</div>
                <div style="font-size:20px;font-weight:700;color:var(--c-primary)">
                    {{ auth()->user()->internProfile->pending_tasks_count }}</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:var(--c-info-l);color:var(--c-info)"><i
                    class="fa-solid fa-spinner"></i></div>
            <div>
                <div style="font-size:11px;color:var(--c-text-sub)">Đang làm</div>
                <div style="font-size:20px;font-weight:700;color:var(--c-info)">
                    {{ $tasks->where('status', 'Doing')->count() }}</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:var(--c-success-l);color:var(--c-success)"><i
                    class="fa-solid fa-circle-check"></i></div>
            <div>
                <div style="font-size:11px;color:var(--c-text-sub)">Hoàn thành</div>
                <div style="font-size:20px;font-weight:700;color:var(--c-success)">
                    {{ $tasks->where('status', 'Done')->count() }}</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:var(--c-danger-l);color:var(--c-danger)"><i
                    class="fa-solid fa-circle-xmark"></i></div>
            <div>
                <div style="font-size:11px;color:var(--c-text-sub)">Quá hạn</div>
                <div style="font-size:20px;font-weight:700;color:var(--c-danger)">
                    {{ auth()->user()->internProfile->overdue_tasks_count }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <form method="get" action="{{ route('frontend.intern.tasks') }}" class="toolbar" style="margin-top:20px">
        @csrf
        <input type="text" name="search" class="form-control" placeholder="Tìm task theo tên..."
            value="{{ request('search') }}">
        <select name="status" class="form-control" style="width:auto">
            <option value="">Tất cả trạng thái</option>
            <option value="Todo" @selected(request('status') === 'Todo')>Chờ thực hiện</option>
            <option value="Doing" @selected(request('status') === 'Doing')>Đang làm</option>
            <option value="Done" @selected(request('status') === 'Done')>Hoàn thành</option>
            <option value="Overdue" @selected(request('status') === 'Overdue')>Quá hạn</option>
        </select>
        <select name="priority" class="form-control" style="width:auto">
            <option value="">Tất cả độ ưu tiên</option>
            <option value="high" @selected(request('priority') === 'high')>Cao</option>
            <option value="medium" @selected(request('priority') === 'medium')>Trung bình</option>
            <option value="low" @selected(request('priority') === 'low')>Thấp</option>
        </select>
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    {{-- Table --}}
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Stt</th>
                    <th>Tên task</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Deadline</th>
                    <th>Độ ưu tiên</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $item)
                    <tr>
                        <td style="color:var(--c-text-sub);font-size:12px">
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            <div class="task-title">{{ $item->title }}</div>
                        </td>
                        <td style="max-width:200px">{{ $item->description }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td
                            class="{{ $item->is_overdue ? 'deadline-over' : '' }}
                                    {{ $item->is_near_deadline ? 'deadline-near' : '' }}">
                            {{ $item->deadline }} {{ $item->is_overdue ? '⚠' : '' }}
                        </td>
                        <td><span class="badge pri-{{ $item->priority }}">{{ $item->priority }}</span></td>
                        <td><span id="status-badge-{{ $item->id }}"
                                class="badge {{ $item->status }}">{{ $item->status }}</span></td>
                        <td>
                            <button class="btn btn-outline" onclick="showTaskDetail({{ $item->id }})">
                                <i class="fa-solid fa-eye"></i>
                                Xem
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $tasks->links('vendor.pagination.ims') }}</div>


    {{-- Task detail modal --}}
    <div id="task-detail-modal" class="modal-overlay hidden">
        <div class="modal-box">
            <button class="modal-close" onclick="closeTaskDetail()">×</button>
            <div id="task-detail-content">
                {{-- Blade partial sẽ được JS chèn vào đây --}}
            </div>
        </div>
    </div>
@endsection
