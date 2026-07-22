@extends('frontend.mentor.layouts.mentor')

@section('title', 'Task – ' . ($intern->full_name ?? ''))
@section('breadcrumb', 'Quản lý Task')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" style="margin-bottom:16px">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- ── Breadcrumb + intern header ── --}}
    <div class="kanban-page-header">
        <a href="{{ route('frontend.mentor.tasks') }}" class="kanban-back-btn">
            <i class="fa-solid fa-arrow-left"></i> Quay lại
        </a>
        <div class="kanban-intern-chip">
            <div class="mini-avatar">{{ strtoupper(substr($intern->full_name, 0, 3)) }}</div>
            <div>
                <div class="kanban-intern-name">{{ $intern->full_name }}</div>
                <div class="kanban-intern-sub">{{ $intern->desired_technology ?? '' }} &middot; {{ $intern->school ?? '' }}
                </div>
            </div>
        </div>
        <div class="kanban-header-stats">
            <span class="khs-item"><span
                    class="khs-num sv-warning">{{ ($tasksByStatus['Review'] ?? collect())->count() }}</span><span
                    class="khs-label">Chờ review</span></span>
            <span class="khs-sep"></span>
            <span class="khs-item"><span
                    class="khs-num sv-success">{{ ($tasksByStatus['Done'] ?? collect())->count() }}</span><span
                    class="khs-label">Done</span></span>
            <span class="khs-sep"></span>
            <span class="khs-item"><span
                    class="khs-num sv-primary">{{ collect($tasksByStatus)->flatten()->count() }}</span><span
                    class="khs-label">Tổng</span></span>
        </div>
        <button type="button" class="btn btn-primary" onclick="openCreateTaskModal()" style="margin-left:auto">
            <i class="fa-solid fa-plus"></i> Giao task mới
        </button>
    </div>

    {{-- ── Kanban board ── --}}
    <div class="kanban">

        {{-- Todo --}}
        <div class="kcol">
            <div class="kcol-head">
                <span>Todo</span>
                <span class="kcol-count">{{ ($tasksByStatus['Todo'] ?? collect())->count() }}</span>
            </div>
            @foreach ($tasksByStatus['Todo'] ?? [] as $task)
                <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                    data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                    data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                    data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                    data-comment="{{ $task->mentor_comment }}">
                    <div class="kcard-title">{{ $task->title }}</div>
                    <div class="kcard-meta">
                        <span class="{{ $task->is_near_deadline ? 'deadline-warning' : '' }}">
                            <i class="fa-regular fa-calendar" style="font-size:10px"></i>
                            {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                            @if ($task->is_near_deadline)
                                <span class="near-deadline-badge">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Sắp hết hạn
                                </span>
                            @elseif ($task->is_overdue)
                                <span class="deadline-badge">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Quá hạn
                                </span>
                            @endif
                        </span>
                        <span class="badge pri-{{ strtolower($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Doing --}}
        <div class="kcol">
            <div class="kcol-head">
                <span>Doing</span>
                <span class="kcol-count">{{ ($tasksByStatus['Doing'] ?? collect())->count() }}</span>
            </div>
            @foreach ($tasksByStatus['Doing'] ?? [] as $task)
                <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                    data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                    data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                    data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                    data-comment="{{ $task->mentor_comment }}">
                    <div class="kcard-title">{{ $task->title }}</div>
                    <div class="kcard-meta">
                        <span class="{{ $task->is_near_deadline ? 'deadline-warning' : '' }}">
                            <i class="fa-regular fa-calendar" style="font-size:10px"></i>
                            {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                            @if ($task->is_near_deadline)
                                <span class="near-deadline-badge">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Sắp hết hạn
                                </span>
                            @elseif ($task->is_overdue)
                                <span class="deadline-badge">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Quá hạn
                                </span>
                            @endif
                        </span>
                        <span class="badge pri-{{ strtolower($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Review --}}
        <div class="kcol"
            style="{{ ($tasksByStatus['Review'] ?? collect())->count() > 0 ? 'border:2px solid var(--c-warning);' : '' }}">
            <div class="kcol-head">
                <span style="{{ ($tasksByStatus['Review'] ?? collect())->count() > 0 ? 'color:var(--c-warning)' : '' }}">
                    Review
                    @if (($tasksByStatus['Review'] ?? collect())->count() > 0)
                        <i class="fa-solid fa-circle-exclamation" style="font-size:12px;margin-left:4px"></i>
                    @endif
                </span>
                <span class="kcol-count">{{ ($tasksByStatus['Review'] ?? collect())->count() }}</span>
            </div>
            @foreach ($tasksByStatus['Review'] ?? [] as $task)
                <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                    data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                    data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                    data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                    data-comment="{{ $task->mentor_comment }}">
                    <div class="kcard-title">{{ $task->title }}</div>
                    <div class="kcard-meta">
                        <span class="{{ $task->is_near_deadline ? 'deadline-warning' : '' }}">
                            <i class="fa-regular fa-calendar" style="font-size:10px"></i>
                            {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                            @if ($task->is_near_deadline)
                                <span class="deadline-badge">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Sắp hết hạn
                                </span>
                            @endif
                        </span>
                        <span class="badge pri-{{ strtolower($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Done --}}
        <div class="kcol">
            <div class="kcol-head">
                <span>Done</span>
                <span class="kcol-count">{{ ($tasksByStatus['Done'] ?? collect())->count() }}</span>
            </div>
            @foreach ($tasksByStatus['Done'] ?? [] as $task)
                <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                    data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                    data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                    data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                    data-comment="{{ $task->mentor_comment }}">
                    <div class="kcard-title">{{ $task->title }}</div>
                    <div class="kcard-meta">
                        <span style="font-size:11px;color:var(--c-text-sub)">
                            <i class="fa-regular fa-calendar" style="font-size:10px"></i>
                            {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                        </span>
                        <span class="badge pri-{{ strtolower($task->priority) }}">{{ ucfirst($task->priority) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>{{-- /.kanban --}}

    {{-- 
        ── Review / edit panel ──
    --}}
    <div class="section-divider review-panel" id="reviewPanel">
        Chi tiết task: <span id="reviewTaskTitle" style="color:var(--c-text)">Chọn một task để xem</span>
    </div>

    <div class="card">
        <form method="POST" action="" data-base-action="{{ route('frontend.mentor.tasks.update', '__ID__') }}"
            id="reviewTaskForm">
            @csrf
            <input type="hidden" id="reviewTaskId" name="task_id">

            <div class="detail-grid">
                <div class="form-group">
                    <label class="form-label">Intern</label>
                    <input type="text" id="reviewTaskIntern" class="form-control" readonly
                        style="background:var(--c-bg);cursor:default">
                </div>
                <div class="form-group">
                    <label class="form-label">Trạng thái hiện tại</label>
                    <input type="text" id="reviewTaskStatus" class="form-control" readonly
                        style="background:var(--c-bg);cursor:default">
                </div>
                <div class="form-group">
                    <label class="form-label">Deadline</label>
                    <input type="date" id="reviewTaskDeadline" name="deadline" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Mức ưu tiên</label>
                    <select id="reviewTaskPriority" name="priority" class="form-control">
                        <option value="low">Thấp</option>
                        <option value="medium">Trung bình</option>
                        <option value="high">Cao</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tiêu đề</label>
                <input type="text" id="reviewTaskTitleInput" name="title" class="form-control"
                    placeholder="Tiêu đề task...">
            </div>

            <div class="form-group">
                <label class="form-label">Mô tả</label>
                <textarea id="reviewTaskDescription" name="description" rows="4" class="form-control"
                    placeholder="Mô tả chi tiết..."></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Nhận xét của mentor</label>
                <textarea id="reviewTaskComment" name="mentor_comment" rows="3" class="form-control"
                    placeholder="Nhập nhận xét... (vd: Code ổn, cần tách validation ra Form Request)"></textarea>
            </div>

            <div class="action-row">
                <button type="submit" name="action" value="save" class="btn btn-outline">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu
                </button>
                <button type="submit" name="action" value="doing" class="btn btn-outline" id="btnReturnDoing">
                    <i class="fa-solid fa-rotate-left"></i> Trả về Doing
                </button>
                <button type="submit" name="action" value="done" class="btn btn-primary" id="btnConfirmDone">
                    <i class="fa-solid fa-check"></i> Xác nhận Done
                </button>
            </div>

        </form>
    </div>

    {{-- ── Modal: Giao task mới ── --}}
    <div class="modal-overlay" id="createTaskModal">
        <div class="modal">
            <div class="modal-title">
                <span><i class="fa-solid fa-plus" style="color:var(--c-primary);margin-right:6px"></i> Giao task cho
                    {{ $intern->full_name }}</span>
                <button type="button" onclick="closeCreateTaskModal()"
                    style="background:none;border:none;cursor:pointer;font-size:18px;color:var(--c-text-sub)">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('frontend.mentor.tasks.store') }}">
                @csrf
                <input type="hidden" name="intern_id" value="{{ $intern->id }}">

                <div class="form-group">
                    <label class="form-label">Intern được giao</label>
                    <input type="text" class="form-control" value="{{ $intern->full_name }}" readonly
                        style="background:var(--c-bg);cursor:default">
                </div>
                <div class="form-group">
                    <label class="form-label">Tiêu đề <span style="color:var(--c-danger)">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Vd: Viết API authentication"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Mô tả chi tiết công việc cần làm..."></textarea>
                </div>
                <div class="form-row" style="margin-bottom:16px">
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Mức độ ưu tiên</label>
                        <select name="priority" class="form-control">
                            <option value="low">Thấp</option>
                            <option value="medium" selected>Trung bình</option>
                            <option value="high">Cao</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Deadline <span style="color:var(--c-danger)">*</span></label>
                        <input type="date" name="deadline" class="form-control" min="{{ now()->toDateString() }}"
                            required>
                        <div style="font-size:11px;color:var(--c-text-sub);margin-top:4px">
                            Không được nhỏ hơn ngày hiện tại
                        </div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px">
                    <button type="button" class="btn btn-outline" onclick="closeCreateTaskModal()">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Giao task
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* ── Kanban page header ── */
        .kanban-page-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .kanban-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--c-text-sub);
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            background: var(--c-surface);
            white-space: nowrap;
            transition: all .15s;
        }

        .kanban-back-btn:hover {
            background: var(--c-bg);
            color: var(--c-text);
        }

        .kanban-intern-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 8px 14px;
        }

        .kanban-intern-name {
            font-size: 14px;
            font-weight: 700;
        }

        .kanban-intern-sub {
            font-size: 11px;
            color: var(--c-text-sub);
        }

        /* header stats */
        .kanban-header-stats {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius-lg);
            padding: 8px 16px;
        }

        .khs-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1px;
        }

        .khs-num {
            font-size: 18px;
            font-weight: 700;
            line-height: 1;
        }

        .khs-label {
            font-size: 10px;
            color: var(--c-text-sub);
        }

        .khs-sep {
            width: 1px;
            height: 24px;
            background: var(--c-border);
        }

        /* review/done action button states */
        #btnReturnDoing,
        #btnConfirmDone {
            opacity: .4;
            pointer-events: none;
        }

        #btnReturnDoing.active-action,
        #btnConfirmDone.active-action {
            opacity: 1;
            pointer-events: auto;
        }

        /* alert danger */
        .alert-danger {
            background: var(--c-danger-l);
            border: 1px solid #fed7d7;
            color: var(--c-danger);
            padding: 10px 14px;
            border-radius: var(--radius);
            font-size: 13px;
        }
    </style>
@endpush
