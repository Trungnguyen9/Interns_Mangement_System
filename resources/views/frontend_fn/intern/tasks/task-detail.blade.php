<div class="task-detail">

```
<h3>
    <i class="fa-solid fa-list-check"></i>
    Task Details
</h3>

{{-- Task Name --}}
<div class="form-group">
    <div class="form-label">Task Name</div>

    <h5 id="modalTaskTitle">
        {{ $task->title }}
    </h5>
</div>

{{-- Deadline --}}
<div class="form-group">
    <div class="form-label">Deadline</div>

    <div class="text-muted">
        <i class="fa-regular fa-calendar mr-1"></i>
        {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
    </div>
</div>

{{-- Priority + Status --}}
<div class="form-group">
    <div class="form-label">Task Information</div>

    <span class="badge pri-{{ $task->priority }}">
        {{ $task->priority }}
    </span>

    <span
        class="badge {{ $task->status }}"
        id="modal-status-badge"
    >
        {{ $task->status }}
    </span>
</div>

{{-- Description --}}
<div class="form-group">
    <div class="form-label">Description</div>

    <div class="alert alert-light mb-0">
        {{ $task->description ?: 'This task has no description.' }}
    </div>
</div>

{{-- Mentor Comment --}}
<div class="alert alert-success">
    <i class="fa-solid fa-comment-dots mr-1"></i>

    <strong>Mentor Comment:</strong>

    {{ $task->mentor_comment ?? 'No comment yet.' }}
</div>


@if ($task->status === 'Done')

    {{-- Task is completed --}}
    <div class="alert alert-light">
        <i class="fa-solid fa-lock mr-1"></i>

        <strong>Task completed.</strong>
        Only the mentor has permission to make further edits.
    </div>

    <div class="text-right">
        <button
            type="button"
            class="btn btn-secondary"
            onclick="closeTaskDetail()"
        >
            Close
        </button>
    </div>

@else

    {{-- Status update form --}}
    <form
        id="task-update-form"
        method="POST"
        action="{{ route('frontend.intern.tasks.update', $task->id) }}"
    >
        @csrf

        <input
            type="hidden"
            name="task_id"
            value="{{ $task->id }}"
        >

        <div class="form-group">
            <label class="form-label" for="task-status">
                Update Status
            </label>

            <select
                id="task-status"
                name="status"
                class="form-control"
            >
                <option
                    value="Todo"
                    @selected($task->status === 'Todo')
                >
                    Pending
                </option>

                <option
                    value="Doing"
                    @selected($task->status === 'Doing')
                >
                    In Progress
                </option>

                <option
                    value="Review"
                    @selected($task->status === 'Review')
                >
                    Pending Review
                </option>
            </select>
        </div>

        <div class="text-right">
            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeTaskDetail()"
            >
                Close
            </button>

            <button
                type="submit"
                class="btn btn-primary"
            >
                <i class="fa-solid fa-floppy-disk"></i>
                Save Progress
            </button>
        </div>

    </form>

@endif
```

</div>
