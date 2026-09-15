@extends('admin.layout.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Reports Management</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/adminpage') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Weekly Reports</li>
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
                        <h5 class="card-title m-b-0 text-muted">Total Reports</h5>
                        <h2 class="font-light m-b-0">{{ $stats['total'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 text-muted">Submitted This Week</h5>
                        <h2 class="font-light m-b-0">{{ $stats['this_week'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 text-muted">Pending Review</h5>
                        <h2 class="font-light m-b-0">{{ $stats['pending'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-0 text-muted">Reviewed</h5>
                        <h2 class="font-light m-b-0">{{ $stats['reviewed'] ?? 0 }}</h2>
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
                        <form method="GET" action="{{ route('admin.reports.index') }}" class="row align-items-end">
                            <div class="col-md-2 col-sm-6 form-group m-b-0">
                                <label class="font-14 text-muted">Mentor</label>
                                <select name="mentor_id" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($mentors as $mentor)
                                        <option value="{{ $mentor->id }}" @selected(request('mentor_id') == $mentor->id)>
                                            {{ $mentor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 form-group m-b-0">
                                <label class="font-14 text-muted">Intern</label>
                                <select name="intern_id" class="form-control">
                                    <option value="">All</option>
                                    @foreach ($interns as $intern)
                                        <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>
                                            {{ $intern->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 form-group m-b-0">
                                <label class="font-14 text-muted">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">All</option>
                                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                                    <option value="reviewed" @selected(request('status') == 'reviewed')>Reviewed</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group m-b-0">
                                <button type="submit" class="btn btn-info btn-block waves-effect waves-light">
                                    <i class="fas fa-filter"></i> filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================== --}}
        {{-- Bảng danh sách báo cáo --}}
        {{-- ============================================================== --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Weekly Reports List</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="border-top-0">WEEK</th>
                                    <th class="border-top-0">INTERN</th>
                                    <th class="border-top-0">MENTOR</th>
                                    <th class="border-top-0">SUBMISSION DATE</th>
                                    <th class="border-top-0">STATUS</th>
                                    <th class="border-top-0">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    @php
                                        $statusMap = [
                                            'pending' => ['Pending', 'warning'],
                                            'reviewed' => ['Reviewed', 'success'],
                                        ];
                                        [$statusLabel, $statusColor] = $statusMap[$report->status] ?? ['—', 'default'];
                                    @endphp
                                    <tr style="cursor:pointer">
                                        <td class="txt-oflo">
                                            {{ \Carbon\Carbon::parse($report->week_start_date)->format('d/m') }} -
                                            {{ \Carbon\Carbon::parse($report->week_end_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="txt-oflo">{{ $report->intern->user->name ?? '—' }}</td>
                                        <td class="txt-oflo">{{ $report->intern->mentor->user->name ?? '—' }}</td>
                                        <td class="txt-oflo">
                                            {{ optional($report->created_at)->format('d/m/Y') ?? '—' }}
                                        </td>
                                        <td>
                                            <span
                                                class="label label-{{ $statusColor }} label-rounded">{{ $statusLabel }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reports.show', $report->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Show
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted p-4">No reports found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            {{ $reports->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
