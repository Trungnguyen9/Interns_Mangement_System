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
            <div class="page-sub">Chỉnh sửa báo cáo</div>
        </div>
    </div>

    {{-- Submit form --}}
    <div class="card form-section open" id="submitForm" style="margin-bottom:20px">
        <div
            style="font-size:15px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between">
            <span><i class="fa-solid fa-pen-to-square" style="color:var(--c-primary);margin-right:6px"></i> Nộp báo cáo
                tuần</span>
        </div>

        <form method="POST" >
            @csrf
            <div class="form-row" style="margin-bottom:14px">
                <div class="form-group" style="margin-bottom:0">
                    <div class="form-label">Ngày bắt đầu tuần</div>
                    <input type="date" name="week_start_date" class="form-control"
                        value="{{ $reports->week_start_date }}">
                </div>
                <div class="form-group" style="margin-bottom:0">
                    <div class="form-label">Ngày kết thúc tuần</div>
                    <input type="date" name="week_end_date" class="form-control" value="{{ $reports->week_end_date }}">
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">Công việc đã hoàn thành</div>
                <textarea name="completed_tasks" class="form-control" rows="3"
                    placeholder="Liệt kê các task đã làm trong tuần...">{{ $reports->completed_tasks }}</textarea>
            </div>
            <div class="form-group">
                <div class="form-label">Khó khăn gặp phải</div>
                <textarea name="difficulties" class="form-control" rows="2" placeholder="Những vấn đề gặp khó khăn...">{{ $reports->difficulties }}</textarea>
            </div>
            <div class="form-group">
                <div class="form-label">Kế hoạch tuần sau</div>
                <textarea name="next_plan" class="form-control" rows="2" placeholder="Dự kiến sẽ làm gì tuần tiếp theo...">{{ $reports->next_plan }}</textarea>
            </div>
            <div class="form-group">
                <div class="form-label">Link tham khảo <span style="font-weight:400;color:var(--c-text-sub)">(tùy chọn –
                        reference_links)</span></div>
                <input type="text" name="reference_links" class="form-control"
                    placeholder="https://laravel.com/docs, https://github.com/..." value="{{ $reports->reference_links }}">
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end">
                <a href="{{ route('frontend.intern.reports') }}" type="button" class="btn btn-outline" >Back</a>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-wrench"></i>Cập nhật báo cáo</button>
            </div>
        </form>
    </div>

@endsection
