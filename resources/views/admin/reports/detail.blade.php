@extends('admin.layout.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Chi tiết báo cáo tuần</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/adminpage') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Weekly Reports</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        @php
            $statusMap = [
                'pending' => ['Chờ duyệt', 'warning'],
                'reviewed' => ['Đã duyệt', 'success'],
            ];
            [$statusLabel, $statusColor] = $statusMap[$report->status] ?? ['—', 'default'];
        @endphp

        <div class="row">

            {{-- ============================================================== --}}
            {{-- Cột trái: thông tin intern & tuần báo cáo --}}
            {{-- ============================================================== --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="round-img m-b-20">
                            <i class="fas fa-user-circle" style="font-size: 64px; color: #ccc;"></i>
                        </div>
                        <h4 class="m-b-0">{{ $report->intern->user->name ?? '—' }}</h4>
                        <span class="text-muted font-14">Intern</span>

                        <hr>

                        <table class="table no-border mini-table m-t-10">
                            <tbody>
                                <tr>
                                    <td class="text-muted">Mentor</td>
                                    <td class="text-right font-medium">
                                        {{ $report->intern->mentor->user->name ?? '—' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tuần báo cáo</td>
                                    <td class="text-right font-medium">
                                        {{ \Carbon\Carbon::parse($report->week_start_date)->format('d/m/Y') }} -
                                        {{ \Carbon\Carbon::parse($report->week_end_date)->format('d/m/Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Ngày nộp</td>
                                    <td class="text-right font-medium">
                                        {{ optional($report->created_at)->format('d/m/Y H:i') ?? '—' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Trạng thái</td>
                                    <td class="text-right">
                                        <span
                                            class="label label-{{ $statusColor }} label-rounded">{{ $statusLabel }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary btn-block m-t-10">
                            <i class="fas fa-arrow-left"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>

            {{-- ============================================================== --}}
            {{-- Cột phải: nội dung báo cáo --}}
            {{-- ============================================================== --}}
            <div class="col-md-8">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="fas fa-check-circle text-success"></i> Công việc đã hoàn thành
                        </h4>
                        <p class="m-b-0" style="white-space: pre-line;">{{ $report->completed_tasks }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="fas fa-exclamation-triangle text-warning"></i> Khó khăn gặp phải
                        </h4>
                        @if ($report->difficulties)
                            <p class="m-b-0" style="white-space: pre-line;">{{ $report->difficulties }}</p>
                        @else
                            <p class="m-b-0 text-muted">Không có.</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="fas fa-flag text-info"></i> Kế hoạch tuần tới
                        </h4>
                        <p class="m-b-0" style="white-space: pre-line;">{{ $report->next_plan }}</p>
                    </div>
                </div>

                @if ($report->reference_links)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                <i class="fas fa-link text-muted"></i> Tài liệu tham khảo
                            </h4>
                            @foreach (explode(',', $report->reference_links) as $link)
                                <a href="{{ trim($link) }}" target="_blank" class="link-chip"><i class="fa-solid fa-link"
                                        style="font-size:11px"></i> {{ trim($link) }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="fas fa-comment-dots text-primary"></i> Nhận xét của mentor
                        </h4>
                        @if ($report->mentor_comment)
                            <p class="m-b-0" style="white-space: pre-line;">{{ $report->mentor_comment }}</p>
                        @else
                            <p class="m-b-0 text-muted">Mentor chưa để lại nhận xét.</p>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
