@extends('frontend.intern.layouts.intern')

@section('title', 'Weekly Report')
@section('breadcrumb', 'Weekly Report')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px">
        <div>
            <div class="page-title">Weekly Reports</div>
            <div class="page-sub">Báo cáo tiến độ hàng tuần · {{ ($reports ?? collect())->count() ?: 0 }} báo cáo</div>
        </div>
        <button type="button" class="btn btn-primary" onclick="toggleForm()">
            <i class="fa-solid fa-plus"></i> Nộp báo cáo mới
        </button>
    </div>

    {{-- Submit form --}}
    <div class="card form-section" id="submitForm" style="margin-bottom:20px">
        <div
            style="font-size:15px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between">
            <span><i class="fa-solid fa-pen-to-square" style="color:var(--c-primary);margin-right:6px"></i> Nộp báo cáo
                tuần</span>
            <button type="button" onclick="toggleForm()"
                style="background:none;border:none;cursor:pointer;color:var(--c-text-sub);font-size:18px">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('frontend.intern.reports.store') }}">
            @csrf
            <div class="form-row" style="margin-bottom:14px">
                <div class="form-group" style="margin-bottom:0">
                    <div class="form-label">Ngày bắt đầu tuần</div>
                    <input type="date" name="week_start_date" class="form-control"
                        value="{{ old('week_start_date', now()->toDateString()) }}">
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <div class="form-label">Ngày kết thúc tuần</div>
                    <input type="date" name="week_end_date" class="form-control"
                        value="{{ old('week_end_date', now()->addDays(6)->toDateString()) }}">
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">Công việc đã hoàn thành</div>
                <textarea name="completed_tasks" class="form-control" rows="3"
                    placeholder="Liệt kê các task đã làm trong tuần...">{{ old('completed_tasks') }}</textarea>
            </div>
            <div class="form-group">
                <div class="form-label">Khó khăn gặp phải</div>
                <textarea name="difficulties" class="form-control" rows="2" placeholder="Những vấn đề gặp khó khăn...">{{ old('difficulties') }}</textarea>
            </div>
            <div class="form-group">
                <div class="form-label">Kế hoạch tuần sau</div>
                <textarea name="next_plan" class="form-control" rows="2" placeholder="Dự kiến sẽ làm gì tuần tiếp theo...">{{ old('next_plan') }}</textarea>
            </div>
            <div class="form-group">
                <div class="form-label">Link tham khảo <span style="font-weight:400;color:var(--c-text-sub)">(tùy chọn –
                        reference_links)</span></div>
                <input type="text" name="reference_links" class="form-control"
                    placeholder="https://laravel.com/docs, https://github.com/..." value="{{ old('reference_links') }}">
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end">
                <button type="button" class="btn btn-outline" onclick="toggleForm()">Hủy</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Gửi báo cáo</button>
            </div>
        </form>
    </div>

    {{-- Report list --}}
    @foreach ($reports ?? [] as $report)
        <div class="card report-card">
            <div class="report-head">
                <div>
                    <div class="report-week">{{ $report->week_start_date }} – {{ $report->week_end_date }}</div>
                </div>
                @if ($report->mentor_comment)
                    <span class="badge reviewed"><i class="fa-solid fa-check" style="font-size:10px"></i> Đã nhận xét</span>
                @else
                    <span class="badge pending"><i class="fa-solid fa-clock" style="font-size:10px"></i> Chờ nhận xét</span>
                @endif
            </div>
            <div class="report-grid">
                <div>
                    <div class="report-col-label">Công việc hoàn thành</div>
                    <div class="report-col-val">{{ $report->completed_tasks }}</div>
                </div>
                <div>
                    <div class="report-col-label">Kế hoạch tuần sau</div>
                    <div class="report-col-val">{{ $report->next_plan }}</div>
                </div>
                <div>
                    <div class="report-col-label">Khó khăn gặp phải</div>
                    <div class="report-col-val">{{ $report->difficulties }}</div>
                </div>
                @if ($report->reference_links)
                    <div>
                        <div class="report-col-label">Link tham khảo</div>
                        <div class="links-wrap">
                            @foreach (explode(',', $report->reference_links) as $link)
                                <a href="{{ trim($link) }}" target="_blank" rel="noopener" class="link-chip"><i
                                        class="fa-solid fa-link" style="font-size:11px"></i> {{ trim($link) }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @if ($report->mentor_comment)
                <div class="mentor-comment">
                    <i class="fa-solid fa-comment-dots" style="font-size:16px;flex-shrink:0;margin-top:1px"></i>
                    <div><b>Mentor nhận xét:</b> "{{ $report->mentor_comment }}"</div>
                </div>
            @else
                <div
                    style="padding:12px;background:var(--c-warning-l);border:1px solid #fbd38d;border-radius:var(--radius);font-size:13px;color:#975a16;margin-top:12px">
                    <i class="fa-solid fa-clock" style="margin-right:6px"></i> Mentor chưa nhận xét báo cáo này.
                </div>
            @endif
        </div>
    @endforeach
@endsection
