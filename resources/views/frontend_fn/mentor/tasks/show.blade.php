@extends('frontend_fn.layout.app')

@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Task Management</h4>
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('frontend.mentor.tasks') }}">
                                    Tasks
                                </a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $intern->full_name }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- Container fluid -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- ============================================================== -->
        <!-- Intern information -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">

                        <div class="kanban-page-header mb-0">

                            {{-- Back --}}
                            <a href="{{ route('frontend.mentor.tasks') }}" class="kanban-back-btn">

                                <i class="fa-solid fa-arrow-left"></i>
                                Back
                            </a>


                            {{-- Intern --}}
                            <div class="kanban-intern-chip">

                                <div class="mini-avatar">
                                    {{ strtoupper(substr($intern->full_name, 0, 3)) }}
                                </div>

                                <div>
                                    <div class="kanban-intern-name">
                                        {{ $intern->full_name }}
                                    </div>

                                    <div class="kanban-intern-sub">
                                        {{ $intern->desired_technology ?? '' }}
                                        &middot;
                                        {{ $intern->school ?? '' }}
                                    </div>
                                </div>

                            </div>


                            {{-- Stats --}}
                            <div class="kanban-header-stats">

                                <span class="khs-item">
                                    <span class="khs-num sv-warning">
                                        {{ ($tasksByStatus['Review'] ?? collect())->count() }}
                                    </span>

                                    <span class="khs-label">
                                        Pending Review
                                    </span>
                                </span>

                                <span class="khs-sep"></span>

                                <span class="khs-item">
                                    <span class="khs-num sv-success">
                                        {{ ($tasksByStatus['Done'] ?? collect())->count() }}
                                    </span>

                                    <span class="khs-label">
                                        Done
                                    </span>
                                </span>

                                <span class="khs-sep"></span>

                                <span class="khs-item">
                                    <span class="khs-num sv-primary">
                                        {{ collect($tasksByStatus)->flatten()->count() }}
                                    </span>

                                    <span class="khs-label">
                                        Total
                                    </span>
                                </span>

                            </div>


                            {{-- Create task --}}
                            <button type="button" class="btn btn-primary ml-auto" onclick="openCreateTaskModal()">
                                <i class="fa-solid fa-plus"></i>
                                New Task
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>


        <!-- ============================================================== -->
        <!-- Kanban board -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Task Board</h4>

                        <div class="kanban">

                            {{-- TODO --}}
                            <div class="kcol">

                                <div class="kcol-head">
                                    <span>Todo</span>

                                    <span class="kcol-count">
                                        {{ ($tasksByStatus['Todo'] ?? collect())->count() }}
                                    </span>
                                </div>

                                @foreach ($tasksByStatus['Todo'] ?? [] as $task)
                                    <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                                        data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                                        data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                                        data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                                        data-comment="{{ $task->mentor_comment }}">

                                        <div class="kcard-title">
                                            {{ $task->title }}
                                        </div>

                                        <div class="kcard-meta">

                                            <span class="{{ $task->is_near_deadline ? 'deadline-warning' : '' }}">

                                                <i class="fa-regular fa-calendar" style="font-size:10px"></i>

                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                                                @if ($task->is_near_deadline)
                                                    <span class="near-deadline-badge">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                        Near deadline
                                                    </span>
                                                @elseif ($task->is_overdue)
                                                    <span class="deadline-badge-2">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                        Overdue
                                                    </span>
                                                @endif

                                            </span>

                                            <span class="badge pri-{{ strtolower($task->priority) }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>

                                        </div>

                                    </div>
                                @endforeach

                            </div>


                            {{-- DOING --}}
                            <div class="kcol">

                                <div class="kcol-head">
                                    <span>Doing</span>

                                    <span class="kcol-count">
                                        {{ ($tasksByStatus['Doing'] ?? collect())->count() }}
                                    </span>
                                </div>

                                @foreach ($tasksByStatus['Doing'] ?? [] as $task)
                                    <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                                        data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                                        data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                                        data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                                        data-comment="{{ $task->mentor_comment }}">

                                        <div class="kcard-title">
                                            {{ $task->title }}
                                        </div>

                                        <div class="kcard-meta">

                                            <span class="{{ $task->is_near_deadline ? 'deadline-warning' : '' }}">

                                                <i class="fa-regular fa-calendar" style="font-size:10px"></i>

                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                                                @if ($task->is_near_deadline)
                                                    <span class="near-deadline-badge">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                        Near deadline
                                                    </span>
                                                @elseif ($task->is_overdue)
                                                    <span class="deadline-badge-2">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                        Overdue
                                                    </span>
                                                @endif

                                            </span>

                                            <span class="badge pri-{{ strtolower($task->priority) }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>

                                        </div>

                                    </div>
                                @endforeach

                            </div>


                            {{-- REVIEW --}}
                            <div class="kcol"
                                style="{{ ($tasksByStatus['Review'] ?? collect())->count() > 0 ? 'border:2px solid var(--c-warning);' : '' }}">

                                <div class="kcol-head">

                                    <span
                                        style="{{ ($tasksByStatus['Review'] ?? collect())->count() > 0 ? 'color:var(--c-warning)' : '' }}">

                                        Review

                                        @if (($tasksByStatus['Review'] ?? collect())->count() > 0)
                                            <i class="fa-solid fa-circle-exclamation"
                                                style="font-size:12px;margin-left:4px"></i>
                                        @endif

                                    </span>

                                    <span class="kcol-count">
                                        {{ ($tasksByStatus['Review'] ?? collect())->count() }}
                                    </span>

                                </div>

                                @foreach ($tasksByStatus['Review'] ?? [] as $task)
                                    <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                                        data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                                        data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                                        data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                                        data-comment="{{ $task->mentor_comment }}">

                                        <div class="kcard-title">
                                            {{ $task->title }}
                                        </div>

                                        <div class="kcard-meta">

                                            <span class="{{ $task->is_near_deadline ? 'deadline-warning' : '' }}">

                                                <i class="fa-regular fa-calendar" style="font-size:10px"></i>

                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                                                @if ($task->is_near_deadline)
                                                    <span class="deadline-badge-2">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                        Near deadline
                                                    </span>
                                                @endif

                                            </span>

                                            <span class="badge pri-{{ strtolower($task->priority) }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>

                                        </div>

                                    </div>
                                @endforeach

                            </div>


                            {{-- DONE --}}
                            <div class="kcol">

                                <div class="kcol-head">
                                    <span>Done</span>

                                    <span class="kcol-count">
                                        {{ ($tasksByStatus['Done'] ?? collect())->count() }}
                                    </span>
                                </div>

                                @foreach ($tasksByStatus['Done'] ?? [] as $task)
                                    <div class="kcard" onclick="selectTask(this)" data-id="{{ $task->id }}"
                                        data-title="{{ $task->title }}" data-description="{{ $task->description }}"
                                        data-intern="{{ $intern->full_name }}" data-deadline="{{ $task->deadline }}"
                                        data-priority="{{ $task->priority }}" data-status="{{ $task->status }}"
                                        data-comment="{{ $task->mentor_comment }}">

                                        <div class="kcard-title">
                                            {{ $task->title }}
                                        </div>

                                        <div class="kcard-meta">

                                            <span style="font-size:11px;color:var(--c-text-sub)">

                                                <i class="fa-regular fa-calendar" style="font-size:10px"></i>

                                                {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}

                                            </span>

                                            <span class="badge pri-{{ strtolower($task->priority) }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Task Detail -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">

                <div class="section-divider review-panel" id="reviewPanel">
                    Task Detail:
                    <span id="reviewTaskTitle" style="color:var(--c-text)">
                        Select a Task to View
                    </span>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action=""
                            data-base-action="{{ route('frontend.mentor.tasks.update', '__ID__') }}" id="reviewTaskForm">
                            @csrf
                            <input type="hidden" id="reviewTaskId" name="task_id">

                            <div class="detail-grid">
                                <div class="form-group">
                                    <label class="form-label">Intern</label>
                                    <input type="text" id="reviewTaskIntern" class="form-control" readonly
                                        style="background:var(--c-bg);cursor:default">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Current Status</label>
                                    <input type="text" id="reviewTaskStatus" class="form-control" readonly
                                        style="background:var(--c-bg);cursor:default">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deadline</label>
                                    <input type="date" id="reviewTaskDeadline" name="deadline" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Priority</label>
                                    <select id="reviewTaskPriority" name="priority" class="form-control">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" id="reviewTaskTitleInput" name="title" class="form-control"
                                    placeholder="Task title...">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea id="reviewTaskDescription" name="description" rows="4" class="form-control"
                                    placeholder="Detailed description..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Mentor's Feedback</label>
                                <textarea id="reviewTaskComment" name="mentor_comment" rows="3" class="form-control"
                                    placeholder="Enter feedback... (e.g.: Code is good, need to extract validation into Form Request)"></textarea>
                            </div>

                            <div class="action-row">
                                <button type="submit" name="action" value="save" class="btn btn-outline">
                                    <i class="fa-solid fa-floppy-disk"></i> Save
                                </button>
                                <button type="submit" name="action" value="doing" class="btn btn-outline"
                                    id="btnReturnDoing">
                                    <i class="fa-solid fa-rotate-left"></i> Return to Doing
                                </button>
                                <button type="submit" name="action" value="done" class="btn btn-primary"
                                    id="btnConfirmDone">
                                    <i class="fa-solid fa-check"></i> Confirm Done
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
    {{-- End container-fluid --}}

    {{-- ── Modal: Giao task mới ── --}}
    <div class="modal-overlay" id="createTaskModal">
        <div class="task-modal">
            <div class="modal-title">
                <span><i class="fa-solid fa-plus" style="color:var(--c-primary);margin-right:6px"></i> Assign task to
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
                    <label class="form-label">Assigned Intern</label>
                    <input type="text" class="form-control" value="{{ $intern->full_name }}" readonly
                        style="background:var(--c-bg);cursor:default">
                </div>
                <div class="form-group">
                    <label class="form-label">Title <span style="color:var(--c-danger)">*</span></label>
                    <input type="text" name="title" class="form-control"
                        placeholder="E.g.: Write API authentication" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Describe the work in detail..."></textarea>
                </div>
                <div class="form-row" style="margin-bottom:16px">
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Priority Level</label>
                        <select name="priority" class="form-control">
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium</option>
                            <option value="high">High</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Deadline <span style="color:var(--c-danger)">*</span></label>
                        <input type="date" name="deadline" class="form-control" min="{{ now()->toDateString() }}"
                            required>
                        <div style="font-size:11px;color:var(--c-text-sub);margin-top:4px">
                            Cannot be earlier than the current date
                        </div>
                    </div>
                </div>
                <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px">
                    <button type="button" class="btn btn-outline" onclick="closeCreateTaskModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Assign Task
                    </button>
                </div>
            </form>
        </div>
    </div>



    <footer class="footer text-center">
        All Rights Reserved by Nice admin. Designed and Developed by
        <a href="https://wrappixel.com">WrapPixel</a>.
    </footer>
@endsection
