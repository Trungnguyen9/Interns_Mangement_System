<div class="modal-title">
    <b>Chi tiết task</b>
</div>

<div id="modalTaskTitle" style="font-size:16px;font-weight:700;margin-bottom:4px">
    {{ $task->title }}
</div>

<div style="font-size:13px;color:var(--c-text-sub);margin-bottom:16px">
    Deadline: {{ $task->deadline }}
</div>

<div style="display:flex;gap:8px;margin-bottom:16px">
    <span class="badge pri-{{ $task->priority }}">{{ $task->priority }}</span>
    <span class="badge {{ $task->status }}" id="modal-status-badge">{{ $task->status }}</span>
</div>

<div class="form-group">
    <div class="form-label">Mô tả</div>
    <div style="font-size:13px;color:var(--c-text-sub);background:var(--c-bg);padding:10px;border-radius:var(--radius)">
        {{ $task->description }}
    </div>
</div>

<div
    style="display:flex;align-items:center;gap:8px;background:var(--c-success-l);padding:12px;border-radius:var(--radius);font-size:13px;color:#276749;margin-bottom:16px">
    <i class="fa-solid fa-comment-dots"></i>
    <span><b>Mentor nhận xét:</b> {{ $task->mentor_comment ?? 'Chưa có nhận xét.' }}</span>
</div>

@if ($task->status === 'Done')
    {{-- Task đã chốt: intern chỉ xem, không có form sửa --}}
    <div style="font-size:13px;color:var(--c-text-sub);padding:10px;background:var(--c-bg);border-radius:var(--radius)">
        <i class="fa-solid fa-lock"></i>
        Task đã hoàn thành. Chỉ mentor mới có quyền chỉnh sửa thêm.
    </div>
    <div style="display:flex;justify-content:flex-end;margin-top:16px">
        <button type="button" class="btn btn-outline" onclick="closeTaskDetail()">Đóng</button>
    </div>
@else
    <form id="task-update-form" method="POST" action="{{ route('frontend.intern.tasks.update', $task->id) }}">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->id }}">

        <div class="form-group">
            <div class="form-label">Cập nhật trạng thái</div>
            <select name="status" class="form-control">
                <option value="Todo" @selected($task->status === 'Todo')>Chờ thực hiện</option>
                <option value="Doing" @selected($task->status === 'Doing')>Đang làm</option>
                <option value="Review" @selected($task->status === 'Review')>Chờ review</option>
            </select>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end">
            <button type="button" class="btn btn-outline" onclick="closeTaskDetail()">Đóng</button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Lưu tiến độ
            </button>
        </div>
    </form>
@endif
