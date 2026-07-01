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
                <div style="font-size:20px;font-weight:700;color:var(--c-primary)">{{ auth()->user()->internProfile->pending_tasks_count }}</div>
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
                <div style="font-size:20px;font-weight:700;color:var(--c-danger)">{{ auth()->user()->internProfile->overdue_tasks_count }}</div>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <form method="GET" action="#" class="toolbar" style="margin-top:20px">
        <input type="text" name="search" class="form-control" placeholder="Tìm task theo tên..."
            value="{{ request('search') }}">
        <select name="status" class="form-control" style="width:auto">
            <option value="">Tất cả trạng thái</option>
            <option value="todo" @selected(request('status') === 'todo')>Chờ thực hiện</option>
            <option value="inprog" @selected(request('status') === 'inprog')>Đang làm</option>
            <option value="done" @selected(request('status') === 'done')>Hoàn thành</option>
            <option value="overdue" @selected(request('status') === 'overdue')>Quá hạn</option>
        </select>
        <select name="priority" class="form-control" style="width:auto">
            <option value="">Tất cả độ ưu tiên</option>
            <option value="high" @selected(request('priority') === 'high')>Cao</option>
            <option value="medium" @selected(request('priority') === 'medium')>Trung bình</option>
            <option value="low" @selected(request('priority') === 'low')>Thấp</option>
        </select>
    </form>

    {{-- Table --}}
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Stt</th>
                    <th>Tên task</th>
                    <th>Mô tả</th>
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
    {{-- <div class="modal-overlay" id="taskModal">
        <div class="modal">
            <div class="modal-title">
                Chi tiết task
                <button type="button" onclick="closeDetail()"
                    style="background:none;border:none;cursor:pointer;font-size:18px;color:var(--c-text-sub)">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="modalTaskTitle" style="font-size:16px;font-weight:700;margin-bottom:4px">Thiết kế ERD database</div>
            <div style="font-size:13px;color:var(--c-text-sub);margin-bottom:16px">tasks.id = 1 · Được giao: 01/06/2025 ·
                Deadline: 10/06/2025</div>
            <div style="display:flex;gap:8px;margin-bottom:16px"><span class="badge pri-high">Cao</span><span
                    class="badge done">Hoàn thành</span></div>
            <div class="form-group">
                <div class="form-label">Mô tả</div>
                <div id="modalTaskDesc"
                    style="font-size:13px;color:var(--c-text-sub);background:var(--c-bg);padding:10px;border-radius:var(--radius)">
                    Vẽ sơ đồ Entity-Relationship cho hệ thống IMS, bao gồm: users, mentor_profiles, intern_profiles, tasks,
                    weekly_reports.
                </div>
            </div>
            <form method="POST">
                @csrf
                <input type="hidden" name="task_id" id="modalTaskId">
                <div class="form-group">
                    <div class="form-label">Cập nhật tiến độ</div>
                    <textarea name="mentor_comment_note" class="form-control" rows="3" placeholder="Nhập ghi chú tiến độ...">Đã hoàn thành ERD với 5 bảng chính, có quan hệ 1-1 và 1-N.</textarea>
                </div>
                <div
                    style="display:flex;align-items:center;gap:8px;background:var(--c-success-l);padding:12px;border-radius:var(--radius);font-size:13px;color:#276749;margin-bottom:16px">
                    <i class="fa-solid fa-comment-dots"></i>
                    <span><b>Mentor nhận xét:</b> "ERD rõ ràng, thêm index cho foreign key nhé."</span>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end">
                    <button type="button" class="btn btn-outline" onclick="closeDetail()">Đóng</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu tiến
                        độ</button>
                </div>
            </form>
        </div>
    </div> --}}
@endsection
