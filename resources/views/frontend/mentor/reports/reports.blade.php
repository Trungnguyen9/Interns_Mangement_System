@extends('frontend.mentor.layouts.mentor')

@section('title', 'Báo cáo tuần')
@section('breadcrumb', 'Báo cáo tuần')

@section('content')
  <div style="margin-bottom:20px">
    <div class="page-title">Báo cáo tuần</div>
    <div class="page-sub">Báo cáo của intern bạn phụ trách</div>
  </div>

  {{-- Toolbar --}}
  <form method="GET" action="#" class="toolbar">
    <select name="intern_id" class="form-control" style="width:auto">
      <option value="">Tất cả intern</option>
      @forelse(($interns ?? []) as $intern)
        <option value="{{ $intern->id }}" @selected(request('intern_id') == $intern->id)>{{ $intern->full_name }}</option>
      @empty
        <option value="5">Nguyễn Văn An</option>
        <option value="6">Lê Thị Bình</option>
      @endforelse
    </select>
    <select name="status" class="form-control" style="width:auto">
      <option value="">Tất cả trạng thái</option>
      <option value="submitted" @selected(request('status') === 'submitted')>Chờ duyệt</option>
      <option value="reviewed" @selected(request('status') === 'reviewed')>Đã duyệt</option>
    </select>
  </form>

  {{--
    Mỗi report card có form nhận xét + nút chuyển trạng thái sang "reviewed".
    Theo yêu cầu: mentor chỉ thấy báo cáo của intern mình phụ trách,
    không sửa được nội dung report — chỉ thêm mentor_comment + đổi status.
  --}}
  @forelse(($reports ?? []) as $report)
    <div class="card report-card">
      <div class="report-card-head">
        <div class="report-intern-tag">
          <i class="fa-solid fa-user-circle"></i>
          {{ $report->intern_name }} &middot; Tuần {{ $report->week_number }} &middot; {{ $report->week_start_date }} – {{ $report->week_end_date }}
        </div>
        @if($report->status === 'reviewed')
          <span class="badge reviewed"><i class="fa-solid fa-check" style="font-size:10px"></i> Đã duyệt</span>
        @else
          <span class="badge submitted"><i class="fa-solid fa-clock" style="font-size:10px"></i> Chờ duyệt</span>
        @endif
      </div>
      <div class="report-row">
        <div><div class="report-col-label">Công việc hoàn thành</div><div class="report-col-val">{{ $report->completed_tasks }}</div></div>
        <div><div class="report-col-label">Khó khăn gặp phải</div><div class="report-col-val">{{ $report->difficulties }}</div></div>
        <div><div class="report-col-label">Kế hoạch tuần sau</div><div class="report-col-val">{{ $report->next_plan }}</div></div>
        @if($report->reference_links)
          <div>
            <div class="report-col-label">Link tham khảo</div>
            <div class="links-wrap">
              @foreach(explode(',', $report->reference_links) as $link)
                <a href="{{ trim($link) }}" target="_blank" class="link-chip"><i class="fa-solid fa-link" style="font-size:11px"></i> {{ trim($link) }}</a>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      @if($report->status === 'reviewed')
        <div class="mentor-comment">
          <i class="fa-solid fa-comment-dots" style="font-size:16px;flex-shrink:0;margin-top:1px"></i>
          <div><b>Bạn đã nhận xét:</b> "{{ $report->mentor_comment }}"</div>
        </div>
      @else
        <form method="POST" action="#">
          @csrf
          @method('PATCH')
          <div class="comment-box">
            <i class="fa-solid fa-comment-dots"></i>
            <input type="text" name="mentor_comment" placeholder="Nhập nhận xét báo cáo..." required>
          </div>
          <div class="action-row">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Chuyển sang Reviewed</button>
          </div>
        </form>
      @endif
    </div>
  @empty
    {{-- Dữ liệu mẫu khi chưa kết nối DB --}}
    <div class="card report-card">
      <div class="report-card-head">
        <div class="report-intern-tag"><i class="fa-solid fa-user-circle"></i> Nguyễn Văn An &middot; Tuần 5 &middot; 02/06 – 06/06/2025</div>
        <span class="badge submitted"><i class="fa-solid fa-clock" style="font-size:10px"></i> Chờ duyệt</span>
      </div>
      <div class="report-row">
        <div><div class="report-col-label">Công việc hoàn thành</div><div class="report-col-val">Hoàn thiện ERD, viết API intern list, cấu hình Route model binding</div></div>
        <div><div class="report-col-label">Khó khăn gặp phải</div><div class="report-col-val">N+1 query problem trong Eloquent – đã giải quyết bằng Eager Loading</div></div>
        <div><div class="report-col-label">Kế hoạch tuần sau</div><div class="report-col-val">Hoàn thiện Blade view, thêm validation Form Request, viết Seeder</div></div>
        <div><div class="report-col-label">Link tham khảo</div><div class="links-wrap"><a href="#" class="link-chip"><i class="fa-solid fa-link" style="font-size:11px"></i> GitHub PR</a></div></div>
      </div>
      <form method="POST" action="#">
        @csrf
        @method('PATCH')
        <div class="comment-box">
          <i class="fa-solid fa-comment-dots"></i>
          <input type="text" name="mentor_comment" placeholder="Nhập nhận xét báo cáo..." required>
        </div>
        <div class="action-row">
          <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Chuyển sang Reviewed</button>
        </div>
      </form>
    </div>

    <div class="card report-card">
      <div class="report-card-head">
        <div class="report-intern-tag"><i class="fa-solid fa-user-circle"></i> Lê Thị Bình &middot; Tuần 3 &middot; 19/05 – 23/05/2025</div>
        <span class="badge reviewed"><i class="fa-solid fa-check" style="font-size:10px"></i> Đã duyệt</span>
      </div>
      <div class="report-row">
        <div><div class="report-col-label">Công việc hoàn thành</div><div class="report-col-val">Setup môi trường React, gọi thử API mẫu</div></div>
        <div><div class="report-col-label">Khó khăn gặp phải</div><div class="report-col-val">Chưa quen cách quản lý state với useEffect</div></div>
        <div><div class="report-col-label">Kế hoạch tuần sau</div><div class="report-col-val">Xây dựng giao diện Task Board</div></div>
      </div>
      <div class="mentor-comment">
        <i class="fa-solid fa-comment-dots" style="font-size:16px;flex-shrink:0;margin-top:1px"></i>
        <div><b>Bạn đã nhận xét:</b> "Tốt, tiếp tục phát huy nhé! Đọc thêm tài liệu React Hooks."</div>
      </div>
    </div>
  @endforelse
@endsection
