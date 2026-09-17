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

        {{-- Success --}}
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Errors --}}
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

                {{-- ==================== FILTER CARD ==================== --}}
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Weekly Report Management</h4>
                        <p class="text-muted">
                            Reports from your assigned interns
                        </p>

                        <form method="GET" action="{{ route('frontend.mentor.reports') }}" class="form-inline">

                            @csrf

                            <div class="form-group mr-2 mb-2">
                                <select name="intern_id" class="form-control">
                                    <option value="">All Interns</option>

                                    @foreach ($interns ?? [] as $intern)
                                        <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>
                                            {{ $intern->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

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


                {{-- ==================== REPORT LIST ==================== --}}
                @forelse(($reports ?? []) as $report)
                    <div class="card report-card">
                        <div class="card-body">

                            {{-- Report header --}}
                            <div class="d-flex align-items-center justify-content-between mb-3">

                                <div>
                                    <h5 class="card-title mb-1">
                                        <i class="fa-solid fa-user-circle"></i>
                                        {{ $report->intern->full_name }}
                                    </h5>

                                    <small class="text-muted">
                                        Week {{ $report->week_number }}
                                        &middot;
                                        
                                        {{ \Carbon\Carbon::parse($report->week_start_date)->format('d/m/Y') }}
                                        –
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

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <small class="text-muted">
                                        Completed Tasks
                                    </small>

                                    <div class="mt-1">
                                        {{ $report->completed_tasks }}
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-6 mb-3">
                                    <small class="text-muted">
                                        Difficulties Encountered
                                    </small>

                                    <div class="mt-1">
                                        {{ $report->difficulties }}
                                    </div>
                                </div>


                                <div class="col-lg-4 col-md-6 mb-3">
                                    <small class="text-muted">
                                        Next Week's Plan
                                    </small>

                                    <div class="mt-1">
                                        {{ $report->next_plan }}
                                    </div>
                                </div>

                            </div>


                            {{-- Reference links --}}
                            @if ($report->reference_links)
                                <div class="mb-3">

                                    <small class="text-muted d-block mb-2">
                                        Reference Links
                                    </small>

                                    <div class="links-wrap">
                                        @foreach (explode(',', $report->reference_links) as $link)
                                            <a href="{{ trim($link) }}" target="_blank" class="link-chip">

                                                <i class="fa-solid fa-link"></i>
                                                {{ trim($link) }}

                                            </a>
                                        @endforeach
                                    </div>

                                </div>
                            @endif


                            <hr>


                            {{-- ==================== REVIEW FORM ==================== --}}
                            <form method="POST" action="{{ route('frontend.mentor.reports.update', $report->id) }}">

                                @csrf


                                @if ($report->status === 'reviewed')
                                    <div class="report-meta mb-3">
                                        <i class="fa-solid fa-clock"></i>

                                        Reviewed
                                        {{ $report->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                @endif


                                <div class="form-group">

                                    <label>
                                        <i class="fa-solid fa-comment-dots"></i>
                                        Mentor's Comment
                                    </label>

                                    <input type="text" name="mentor_comment" class="form-control"
                                        placeholder="Enter report comments..." required
                                        value="{{ old('mentor_comment', $report->mentor_comment) }}">

                                </div>


                                <div class="d-flex justify-content-end">

                                    @if ($report->status === 'pending')
                                        <button type="submit" class="btn btn-primary">

                                            <i class="fa-solid fa-check"></i>
                                            Confirm Review

                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-outline-primary">

                                            <i class="fa-solid fa-pen"></i>
                                            Update Comment

                                        </button>
                                    @endif

                                </div>

                            </form>

                        </div>
                    </div>

                @empty

                    <div class="card">
                        <div class="card-body text-center">

                            <i class="fa-solid fa-file-lines fa-2x text-muted mb-2"></i>

                            <p class="text-muted mb-0">
                                No report data available
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