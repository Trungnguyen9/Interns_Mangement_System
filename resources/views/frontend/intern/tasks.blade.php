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
      <div class="stat-mini-icon" style="background:var(--c-primary-l);color:var(--c-primary)"><i class="fa-solid fa-layer-group"></i></div>
      <div><div style="font-size:11px;color:var(--c-text-sub)">Tất cả</div><div style="font-size:20px;font-weight:700;color:var(--c-primary)">{{ $taskStats['total'] ?? 12 }}</div></div>
    </div>
    <div class="stat-mini">
      <div class="stat-mini-icon" style="background:var(--c-info-l);color:var(--c-info)"><i class="fa-solid fa-spinner"></i></div>
      <div><div style="font-size:11px;color:var(--c-text-sub)">Đang làm</div><div style="font-size:20px;font-weight:700;color:var(--c-info)">{{ $taskStats['in_progress'] ?? 4 }}</div></div>
    </div>
    <div class="stat-mini">
      <div class="stat-mini-icon" style="background:var(--c-success-l);color:var(--c-success)"><i class="fa-solid fa-circle-check"></i></div>
      <div><div style="font-size:11px;color:var(--c-text-sub)">Hoàn thành</div><div style="font-size:20px;font-weight:700;color:var(--c-success)">{{ $taskStats['done'] ?? 7 }}</div></div>
    </div>
    <div class="stat-mini">
      <div class="stat-mini-icon" style="background:var(--c-danger-l);color:var(--c-danger)"><i class="fa-solid fa-circle-xmark"></i></div>
      <div><div style="font-size:11px;color:var(--c-text-sub)">Quá hạn</div><div style="font-size:20px;font-weight:700;color:var(--c-danger)">{{ $taskStats['overdue'] ?? 1 }}</div></div>
    </div>
  </div>

  {{-- Toolbar --}}
  <form method="GET" action="{{ route('frontend.intern.tasks') }}" class="toolbar" style="margin-top:20px">
    <input type="text" name="search" class="form-control" placeholder="Tìm task theo tên..." value="{{ request('search') }}">
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
          <th>#</th><th>Tên task</th><th>Mô tả</th><th>Deadline</th>
          <th>Độ ưu tiên</th><th>Trạng thái</th><th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        @forelse(($tasks ?? []) as $task)
          <tr>
            <td style="color:var(--c-text-sub);font-size:12px">#{{ str_pad($task->id, 3, '0', STR_PAD_LEFT) }}</td>
            <td>
              <div class="task-title">{{ $task->title }}</div>
              <div class="task-desc">tasks.id = {{ $task->id }} · mentor_id = {{ $task->mentor_id }} · intern_id = {{ $task->intern_id }}</div>
            </td>
            <td style="color:var(--c-text-sub);max-width:200px">{{ $task->description }}</td>
            <td class="{{ $task->is_overdue ? 'deadline-over' : ($task->is_near_deadline ? 'deadline-near' : '') }}">
              {{ $task->deadline }} {{ $task->is_overdue ? '⚠' : '' }}
            </td>
            <td><span class="badge pri-{{ $task->priority }}">{{ $task->priority_label }}</span></td>
            <td><span class="badge {{ $task->status }}">{{ $task->status_label }}</span></td>
            <td>
              <button type="button" class="btn btn-outline" style="padding:5px 10px;font-size:12px" onclick="openDetail(this)"
                      data-id="{{ $task->id }}" data-title="{{ $task->title }}" data-description="{{ $task->description }}">
                <i class="fa-solid fa-eye"></i> Xem
              </button>
            </td>
          </tr>
        @empty
          {{-- Dữ liệu mẫu khi chưa kết nối DB --}}
          <tr>
            <td style="color:var(--c-text-sub);font-size:12px">#001</td>
            <td><div class="task-title">Thiết kế ERD database</div><div class="task-desc">tasks.id = 1 · mentor_id = 2 · intern_id = 5</div></td>
            <td style="color:var(--c-text-sub);max-width:200px">Vẽ sơ đồ quan hệ Entity-Relationship cho toàn bộ IMS</td>
            <td>10/06/2025</td>
            <td><span class="badge pri-high">Cao</span></td>
            <td><span class="badge done"><i class="fa-solid fa-check" style="font-size:10px"></i> Xong</span></td>
            <td><button type="button" class="btn btn-outline" style="padding:5px 10px;font-size:12px" onclick="openDetail(this)"><i class="fa-solid fa-eye"></i> Xem</button></td>
          </tr>
          <tr>
            <td style="color:var(--c-text-sub);font-size:12px">#002</td>
            <td><div class="task-title">Viết API intern list</div><div class="task-desc">tasks.id = 2 · mentor_id = 2 · intern_id = 5</div></td>
            <td style="color:var(--c-text-sub);max-width:200px">RESTful API với Laravel Resource Controller</td>
            <td>15/06/2025</td>
            <td><span class="badge pri-high">Cao</span></td>
            <td><span class="badge inprog"><i class="fa-solid fa-spinner fa-spin" style="font-size:10px"></i> Đang làm</span></td>
            <td><button type="button" class="btn btn-outline" style="padding:5px 10px;font-size:12px" onclick="openDetail(this)"><i class="fa-solid fa-eye"></i> Xem</button></td>
          </tr>
          <tr>
            <td style="color:var(--c-text-sub);font-size:12px">#003</td>
            <td><div class="task-title">Viết unit test</div><div class="task-desc">tasks.id = 3 · mentor_id = 2 · intern_id = 5</div></td>
            <td style="color:var(--c-text-sub);max-width:200px">PHPUnit cho InternController – coverage 80%</td>
            <td class="deadline-over">08/06/2025 ⚠</td>
            <td><span class="badge pri-medium">Trung bình</span></td>
            <td><span class="badge overdue"><i class="fa-solid fa-triangle-exclamation" style="font-size:10px"></i> Quá hạn</span></td>
            <td><button type="button" class="btn btn-outline" style="padding:5px 10px;font-size:12px" onclick="openDetail(this)"><i class="fa-solid fa-eye"></i> Xem</button></td>
          </tr>
          <tr>
            <td style="color:var(--c-text-sub);font-size:12px">#004</td>
            <td><div class="task-title">Review code mentor</div><div class="task-desc">tasks.id = 4 · mentor_id = 2 · intern_id = 5</div></td>
            <td style="color:var(--c-text-sub);max-width:200px">Đọc và nhận xét đoạn code Service Layer mẫu</td>
            <td>20/06/2025</td>
            <td><span class="badge pri-low">Thấp</span></td>
            <td><span class="badge todo">Chờ</span></td>
            <td><button type="button" class="btn btn-outline" style="padding:5px 10px;font-size:12px" onclick="openDetail(this)"><i class="fa-solid fa-eye"></i> Xem</button></td>
          </tr>
          <tr>
            <td style="color:var(--c-text-sub);font-size:12px">#005</td>
            <td><div class="task-title">Làm báo cáo tuần 6</div><div class="task-desc">tasks.id = 5 · mentor_id = 2 · intern_id = 5</div></td>
            <td style="color:var(--c-text-sub);max-width:200px">Nộp weekly report tuần 6 trước ngày 13/06</td>
            <td class="deadline-near">13/06/2025</td>
            <td><span class="badge pri-medium">Trung bình</span></td>
            <td><span class="badge todo">Chờ</span></td>
            <td><button type="button" class="btn btn-outline" style="padding:5px 10px;font-size:12px" onclick="openDetail(this)"><i class="fa-solid fa-eye"></i> Xem</button></td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(isset($tasks) && method_exists($tasks, 'links'))
    <div style="margin-top:12px">{{ $tasks->links() }}</div>
  @else
    <div style="margin-top:12px;font-size:12px;color:var(--c-text-sub)">Hiển thị 5 / 12 task</div>
  @endif

  {{-- Task detail modal --}}
  <div class="modal-overlay" id="taskModal">
    <div class="modal">
      <div class="modal-title">
        Chi tiết task
        <button type="button" onclick="closeDetail()" style="background:none;border:none;cursor:pointer;font-size:18px;color:var(--c-text-sub)">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <div id="modalTaskTitle" style="font-size:16px;font-weight:700;margin-bottom:4px">Thiết kế ERD database</div>
      <div style="font-size:13px;color:var(--c-text-sub);margin-bottom:16px">tasks.id = 1 · Được giao: 01/06/2025 · Deadline: 10/06/2025</div>
      <div style="display:flex;gap:8px;margin-bottom:16px"><span class="badge pri-high">Cao</span><span class="badge done">Hoàn thành</span></div>
      <div class="form-group">
        <div class="form-label">Mô tả</div>
        <div id="modalTaskDesc" style="font-size:13px;color:var(--c-text-sub);background:var(--c-bg);padding:10px;border-radius:var(--radius)">
          Vẽ sơ đồ Entity-Relationship cho hệ thống IMS, bao gồm: users, mentor_profiles, intern_profiles, tasks, weekly_reports.
        </div>
      </div>
      <form method="POST" action="{{ url('/intern/tasks/update-progress') }}">
        @csrf
        <div class="form-group">
          <div class="form-label">Cập nhật tiến độ</div>
          <textarea name="mentor_comment_note" class="form-control" rows="3" placeholder="Nhập ghi chú tiến độ...">Đã hoàn thành ERD với 5 bảng chính, có quan hệ 1-1 và 1-N.</textarea>
        </div>
        <div style="display:flex;align-items:center;gap:8px;background:var(--c-success-l);padding:12px;border-radius:var(--radius);font-size:13px;color:#276749;margin-bottom:16px">
          <i class="fa-solid fa-comment-dots"></i>
          <span><b>Mentor nhận xét:</b> "ERD rõ ràng, thêm index cho foreign key nhé."</span>
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end">
          <button type="button" class="btn btn-outline" onclick="closeDetail()">Đóng</button>
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Lưu tiến độ</button>
        </div>
      </form>
    </div>
  </div>
@endsection
