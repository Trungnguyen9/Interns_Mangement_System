@extends('frontend.intern.layouts.intern')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
  <div style="margin-bottom:20px">
    <div class="page-title">Dashboard</div>
    <div class="page-sub">Chào buổi sáng, {{ auth()->user()->name ?? 'Nguyễn Văn An' }} 👋
      &nbsp;·&nbsp; {{ now()->locale('vi')->isoFormat('dddd, DD/MM/YYYY') }}
    </div>
  </div>

  {{-- Stat cards --}}
  <div class="grid-4" style="margin-bottom:20px">
    <div class="stat-card">
      <div class="stat-icon si-primary"><i class="fa-solid fa-list-check"></i></div>
      <div class="stat-label">Task tổng cộng</div>
      <div class="stat-val sv-primary">{{ $stats['total'] ?? 12 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">Được giao</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-warning"><i class="fa-solid fa-spinner"></i></div>
      <div class="stat-label">Đang thực hiện</div>
      <div class="stat-val sv-warning">{{ $stats['in_progress'] ?? 4 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">In progress</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-success"><i class="fa-solid fa-circle-check"></i></div>
      <div class="stat-label">Hoàn thành</div>
      <div class="stat-val sv-success">{{ $stats['done'] ?? 7 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">Đã xong</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
      <div class="stat-label">Quá hạn</div>
      <div class="stat-val sv-danger">{{ $stats['overdue'] ?? 1 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">Cần xử lý ngay</div>
    </div>
  </div>

  <div class="grid-2">
    {{-- Internship progress --}}
    <div class="card">
      <div class="card-head">
        <div class="card-title"><i class="fa-solid fa-chart-line"></i> Tiến độ thực tập</div>
        <span style="font-size:12px;color:var(--c-text-sub)">Tuần {{ $progress['current_week'] ?? 6 }} / {{ $progress['total_weeks'] ?? 12 }}</span>
      </div>
      <div class="progress-track">
        <div class="progress-fill" style="width:{{ $progress['percent'] ?? 50 }}%"></div>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--c-text-sub);margin-bottom:16px">
        <span>{{ $progress['percent'] ?? 50 }}% hoàn thành</span>
        <span style="color:var(--c-primary);font-weight:600">{{ $progress['weeks_left'] ?? 6 }} tuần còn lại</span>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:12px">
        <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
          <div style="color:var(--c-text-sub);margin-bottom:2px">Bắt đầu</div>
          <div style="font-weight:600">{{ $intern->start_date ?? '01/06/2025' }}</div>
        </div>
        <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
          <div style="color:var(--c-text-sub);margin-bottom:2px">Kết thúc</div>
          <div style="font-weight:600">{{ $intern->end_date ?? '31/08/2025' }}</div>
        </div>
        <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
          <div style="color:var(--c-text-sub);margin-bottom:2px">Công nghệ</div>
          <div style="font-weight:600">{{ $intern->desired_technology ?? 'Laravel, Vue.js' }}</div>
        </div>
        <div style="background:var(--c-bg);padding:10px;border-radius:var(--radius)">
          <div style="color:var(--c-text-sub);margin-bottom:2px">Trạng thái</div>
          <div style="font-weight:600;color:var(--c-success)">{{ $intern->status ?? 'Đang thực tập' }}</div>
        </div>
      </div>
    </div>

    {{-- Recent tasks --}}
    <div class="card">
      <div class="card-head">
        <div class="card-title"><i class="fa-solid fa-list-check"></i> Task gần đây</div>
        {{-- <a href="{{ route('frontend.intern.tasks') }}" style="font-size:12px;color:var(--c-primary);text-decoration:none">Xem tất cả →</a> --}}
      </div>
      @forelse(($recentTasks ?? []) as $task)
        <div class="task-row">
          <div class="task-dot {{ $task->status === 'done' ? 'dot-active' : 'dot-off' }}"></div>
          <span style="flex:1;font-weight:500">{{ $task->title }}</span>
          <span class="badge {{ $task->status }}">{{ $task->status_label }}</span>
        </div>
      @empty
        {{-- Dữ liệu mẫu khi chưa kết nối DB --}}
        <div class="task-row"><div class="task-dot dot-active"></div><span style="flex:1;font-weight:500">Thiết kế ERD database</span><span class="badge done">Xong</span></div>
        <div class="task-row"><div class="task-dot dot-active"></div><span style="flex:1;font-weight:500">Viết API intern list</span><span class="badge inprog">Đang làm</span></div>
        <div class="task-row"><div class="task-dot dot-off"></div><span style="flex:1;font-weight:500">Viết unit test</span><span class="badge overdue">Quá hạn</span></div>
        <div class="task-row"><div class="task-dot dot-off"></div><span style="flex:1;font-weight:500">Review code mentor</span><span class="badge todo">Chờ</span></div>
        <div class="task-row"><div class="task-dot dot-off"></div><span style="flex:1;font-weight:500">Báo cáo tuần 6</span><span class="badge todo">Chờ</span></div>
      @endforelse
    </div>
  </div>

  {{-- Latest report --}}
  <div class="section-divider" style="margin-top:24px">Báo cáo tuần mới nhất</div>
  <div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
      <div style="font-size:14px;font-weight:600">
        Tuần {{ $latestReport->week_number ?? 5 }} &nbsp;·&nbsp;
        {{ $latestReport->week_start_date ?? '02/06' }} – {{ $latestReport->week_end_date ?? '06/06/2025' }}
      </div>
      <span class="badge done"><i class="fa-solid fa-check" style="font-size:10px"></i> Đã nộp</span>
    </div>
    <div style="font-size:13px;color:var(--c-text-sub)">
      {{ $latestReport->completed_tasks ?? 'Hoàn thành thiết kế ERD, bắt đầu viết API. Gặp khó khăn về N+1 query trong Eloquent, đã nhờ mentor hỗ trợ và tự nghiên cứu Eager Loading.' }}
    </div>
    @if($latestReport->mentor_comment ?? true)
      <div class="mentor-comment">
        <i class="fa-solid fa-comment-dots"></i>
        <div><span style="font-weight:600">Mentor nhận xét:</span> "{{ $latestReport->mentor_comment ?? 'Tốt, tiếp tục duy trì nhé! Nhớ đọc thêm về Query Builder.' }}"</div>
      </div>
    @endif
    <div style="margin-top:12px">
      {{-- <a href="{{ route('frontend.intern.reports') }}" style="font-size:13px;color:var(--c-primary);text-decoration:none">Xem tất cả báo cáo →</a> --}}
    </div>
  </div>
@endsection
