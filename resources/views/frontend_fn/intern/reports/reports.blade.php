@extends('frontend_fn.layout.app')
@section('content')


    {{-- ==================== PAGE BREADCRUMB ==================== --}}
    <div class="page-breadcrumb">
        <div class="row">

            <div class="col-5 align-self-center">
                <h4 class="page-title">Weekly Reports</h4>
            </div>

            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>

                            <li class="breadcrumb-item active">
                                Weekly Reports
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>


    {{-- ==================== MAIN CONTENT ==================== --}}
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="row">
            <div class="col-12">

                {{-- ==================== HEADER CARD ==================== --}}
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <h4 class="card-title">
                                    Weekly Report Management
                                </h4>

                                <p class="text-muted mb-0">
                                    Weekly progress reports ·
                                    {{ ($reports ?? collect())->total() ?? 0 }} reports
                                </p>
                            </div>

                            <button type="button" class="btn btn-primary" onclick="toggleForm()">

                                <i class="fa-solid fa-plus"></i>
                                Nộp reports mới
                            </button>

                        </div>

                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('frontend.intern.reports') }}" class="form-inline">
                            @csrf
                            <div class="form-group mr-2 mb-2">
                                <select name="status" class="form-control">
                                    <option value="">All Statuses</option>

                                    <option value="pending" @selected(request('status') === 'pending')>
                                        Pending Review
                                    </option>

                                    <option value="reviewed" @selected(request('status') === 'reviewed')>
                                        Reviewed
                                    </option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-filter"></i>
                                    Filter
                                </button>
                            </div>

                        </form>

                    </div>
                </div>


                {{-- ==================== SUBMIT REPORT FORM ==================== --}}
                <div class="card form-section" id="submitForm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">

                            <h4 class="card-title mb-0">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Nộp reports tuần
                            </h4>

                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleForm()">

                                <i class="fa-solid fa-xmark"></i>
                            </button>

                        </div>


                        <form method="POST" action="{{ route('frontend.intern.reports.store') }}">

                            @csrf


                            {{-- Week dates --}}
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="week_start_date">
                                            Week Start Date
                                        </label>

                                        <input type="date" id="week_start_date" name="week_start_date"
                                            class="form-control"
                                            value="{{ old('week_start_date', now()->toDateString()) }}">

                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="week_end_date">
                                            Week End Date
                                        </label>

                                        <input type="date" id="week_end_date" name="week_end_date" class="form-control"
                                            value="{{ old('week_end_date', now()->addDays(6)->toDateString()) }}">

                                    </div>
                                </div>

                            </div>


                            {{-- Completed tasks --}}
                            <div class="form-group">

                                <label for="completed_tasks">
                                    Completed Tasks
                                </label>

                                <textarea id="completed_tasks" name="completed_tasks" class="form-control" rows="3"
                                    placeholder="List the tasks completed this week...">{{ old('completed_tasks') }}</textarea>

                            </div>


                            {{-- Difficulties --}}
                            <div class="form-group">

                                <label for="difficulties">
                                    Difficulties Encountered
                                </label>

                                <textarea id="difficulties" name="difficulties" class="form-control" rows="3"
                                    placeholder="Describe any difficulties encountered...">{{ old('difficulties') }}</textarea>

                            </div>


                            {{-- Next plan --}}
                            <div class="form-group">

                                <label for="next_plan">
                                    Next Week's Plan
                                </label>

                                <textarea id="next_plan" name="next_plan" class="form-control" rows="3"
                                    placeholder="Describe what you plan to do next week...">{{ old('next_plan') }}</textarea>

                            </div>


                            {{-- Reference links --}}
                            <div class="form-group">

                                <label for="reference_links">
                                    Reference Links
                                    <small class="text-muted">
                                        (Optional)
                                    </small>
                                </label>

                                <input type="text" id="reference_links" name="reference_links" class="form-control"
                                    placeholder="https://laravel.com/docs, https://github.com/..."
                                    value="{{ old('reference_links') }}">

                            </div>


                            {{-- Actions --}}
                            <div class="d-flex justify-content-end">

                                <button type="button" class="btn btn-outline-secondary mr-2" onclick="toggleForm()">

                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">

                                    <i class="fa-solid fa-paper-plane"></i>
                                    Gửi reports
                                </button>

                            </div>

                        </form>

                    </div>
                </div>


                {{-- ==================== REPORT LIST ==================== --}}
                @forelse ($reports ?? [] as $report)
                    <div class="card report-card">
                        <div class="card-body">
                            {{-- ==================== REPORT HEADER ==================== --}}
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="fa-solid fa-file-lines"></i>
                                        Weekly Report
                                        @if ($report->week_number)
                                            {{ $report->week_number }}
                                        @endif
                                    </h5>

                                    <small class="text-muted">
                                        <i class="fa-regular fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($report->week_start_date)->format('d/m/Y') }}
                                        &ndash;
                                        {{ \Carbon\Carbon::parse($report->week_end_date)->format('d/m/Y') }}

                                    </small>

                                </div>


                                <div>

                                    @if ($report->status === 'reviewed')
                                        <span class="badge badge-success">
                                            <i class="fa-solid fa-check"></i>
                                            Reviewed
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fa-solid fa-clock"></i>
                                            Pending Review
                                        </span>
                                    @endif

                                </div>

                            </div>
                            {{-- ==================== REPORT CONTENT ==================== --}}
                            <div class="row">
                                {{-- Completed --}}
                                <div class="col-lg-4 col-md-6 mb-3">

                                    <small class="text-muted">
                                        Completed Work
                                    </small>

                                    <div class="mt-1">
                                        {{ $report->completed_tasks ?: 'No content.' }}
                                    </div>

                                </div>


                                {{-- Difficulties --}}
                                <div class="col-lg-4 col-md-6 mb-3">

                                    <small class="text-muted">
                                        Difficulties Encountered
                                    </small>

                                    <div class="mt-1">
                                        {{ $report->difficulties ?: 'No content.' }}
                                    </div>

                                </div>

                                {{-- Next plan --}}
                                <div class="col-lg-4 col-md-6 mb-3">

                                    <small class="text-muted">
                                        Next Week's Plan
                                    </small>

                                    <div class="mt-1">
                                        {{ $report->next_plan ?: 'No content.' }}
                                    </div>

                                </div>

                            </div>

                            {{-- ==================== REFERENCE LINKS ==================== --}}
                            @if ($report->reference_links)
                                <div class="mb-3">

                                    <small class="text-muted d-block mb-2">
                                        Reference Links
                                    </small>

                                    <div class="links-wrap">

                                        @foreach (explode(',', $report->reference_links) as $link)
                                            <a href="{{ trim($link) }}" target="_blank" rel="noopener noreferrer"
                                                class="link-chip">

                                                <i class="fa-solid fa-link"></i>

                                                {{ trim($link) }}

                                            </a>
                                        @endforeach

                                    </div>

                                </div>
                            @endif

                            <hr>
                            {{-- ==================== MENTOR REVIEW ==================== --}}
                            @if ($report->mentor_comment)
                                <div class="alert alert-submit mb-3">
                                    <i class="fa-solid fa-comment-dots"></i>
                                    <strong>Mentor's Comment:</strong>
                                    {{ $report->mentor_comment }}
                                </div>

                                @if ($report->updated_at)
                                    <div class="text-muted">
                                        <small>
                                            <i class="fa-regular fa-clock"></i>
                                            Updated at
                                            {{ $report->updated_at->format('d/m/Y H:i') }}
                                        </small>
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-warning mb-3">
                                    <i class="fa-solid fa-clock"></i>
                                    Mentor chưa nhận xét reports này.
                                </div>

                                {{-- Intern chỉ được sửa khi mentor chưa review --}}
                                <div class="d-flex justify-content-end">

                                    <a href="{{ route('frontend.intern.reports.edit', $report->id) }}"
                                        class="btn btn-outline-primary">

                                        <i class="fa-solid fa-pen"></i>
                                        Cập nhật reports

                                    </a>

                                </div>
                            @endif

                        </div>
                    </div>

                @empty

                    {{-- ==================== EMPTY STATE ==================== --}}
                    <div class="card">

                        <div class="card-body text-center">

                            <i class="fa-solid fa-file-lines fa-2x text-muted mb-2"></i>

                            <p class="text-muted mb-0">
                                Bạn chưa có reports tuần nào.
                            </p>

                        </div>

                    </div>
                @endforelse


                {{-- ==================== PAGINATION ==================== --}}
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        {{ $reports->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
