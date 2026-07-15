@extends('frontend.mentor.layouts.mentor')

@section('title', 'Báo cáo tuần')
@section('breadcrumb', 'Báo cáo tuần')

@section('content')
    <div style="margin-bottom:20px">
        <div class="page-title">Báo cáo tuần</div>
        <div class="page-sub">Báo cáo của intern bạn phụ trách</div>
    </div>

    {{-- Toolbar --}}
    <form method="GET" action="{{ route('frontend.mentor.reports') }}" class="toolbar">
        @csrf
        <select name="intern_id" class="form-control" style="width:auto">
            <option value="">Tất cả intern</option>
            @foreach ($interns ?? [] as $intern)
                <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>{{ $intern->full_name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-control" style="width:auto">
            <option value="">Tất cả trạng thái</option>
            <option value="pending" @selected(request('status') === 'pending')>Chờ duyệt</option>
            <option value="reviewed" @selected(request('status') === 'reviewed')>Đã duyệt</option>
        </select>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Lọc</button>
    </form>

    {{--
    Mỗi report card có form nhận xét + nút chuyển trạng thái sang "reviewed".
  --}}
    @forelse(($reports ?? []) as $report)
        <div class="card report-card">
            <div class="report-card-head">
                <div class="report-intern-tag">
                    <i class="fa-solid fa-user-circle"></i>
                    {{ $report->intern->full_name }} &middot; Tuần {{ $report->week_number }} &middot;
                    {{ $report->week_start_date }} – {{ $report->week_end_date }}
                </div>
                @if ($report->status === 'reviewed')
                    <span class="badge reviewed"><i class="fa-solid fa-check" style="font-size:10px"></i> Đã duyệt</span>
                @else
                    <span class="badge submitted"><i class="fa-solid fa-clock" style="font-size:10px"></i> Chờ duyệt</span>
                @endif
            </div>
            <div class="report-row">
                <div>
                    <div class="report-col-label">Công việc hoàn thành</div>
                    <div class="report-col-val">{{ $report->completed_tasks }}</div>
                </div>
                <div>
                    <div class="report-col-label">Khó khăn gặp phải</div>
                    <div class="report-col-val">{{ $report->difficulties }}</div>
                </div>
                <div>
                    <div class="report-col-label">Kế hoạch tuần sau</div>
                    <div class="report-col-val">{{ $report->next_plan }}</div>
                </div>
                @if ($report->reference_links)
                    <div>
                        <div class="report-col-label">Link tham khảo</div>
                        <div class="links-wrap">
                            @foreach (explode(',', $report->reference_links) as $link)
                                <a href="{{ trim($link) }}" target="_blank" class="link-chip"><i class="fa-solid fa-link"
                                        style="font-size:11px"></i> {{ trim($link) }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>


            <form method="POST" action="{{ route('frontend.mentor.reports.update', $report->id) }}">
                @csrf
                @if ($report->status === 'reviewed')
                    <div class="report-meta">
                        <i class="fa-solid fa-clock"></i>
                        Đã review {{ $report->updated_at->format('d/m/Y H:i') }}
                    </div>
                @endif
                <div class="comment-box">
                    <i class="fa-solid fa-comment-dots"></i>
                    <input type="text" name="mentor_comment" placeholder="Nhập nhận xét báo cáo..." required
                        value="{{ old('mentor_comment', $report->mentor_comment) }}">
                </div>
                <div class="action-row">
                    @if ($report->status === 'pending')
                        <button class="btn btn-primary">
                            Xác nhận Review
                        </button>
                    @else
                        <button class="btn btn-outline">
                            Cập nhật nhận xét
                        </button>
                    @endif
                </div>
            </form>

        </div>
    @empty
        {{-- Dữ liệu mẫu khi chưa kết nối DB --}}
        <div class="card report-card">
            Chưa có dữ liệu
        </div>


    @endforelse
    <div>{{ $reports->links('vendor.pagination.ims') }}</div>

@endsection
