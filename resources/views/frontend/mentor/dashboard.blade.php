@extends('frontend.mentor.layouts.mentor')

@section('title', 'Dashboard Mentor')
@section('breadcrumb', 'Dashboard')

@section('content')
  <div style="margin-bottom:20px">
    <div class="page-title">Dashboard Mentor</div>
    <div class="page-sub">Chào {{ auth()->user()->name ?? 'Trần Thị Hoa' }} 👋 &nbsp;·&nbsp; Tổng quan intern bạn phụ trách</div>
  </div>

  {{-- Stat cards --}}
  <div class="grid-4" style="margin-bottom:20px">
    <div class="stat-card">
      <div class="stat-icon si-primary"><i class="fa-solid fa-users"></i></div>
      <div class="stat-label">Intern phụ trách</div>
      <div class="stat-val sv-primary">{{ $currentInterns ?? 2 }} / {{ $maxInterns ?? 3 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">Slot hiện tại</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-primary"><i class="fa-solid fa-list-check"></i></div>
      <div class="stat-label">Task đã giao</div>
      <div class="stat-val sv-primary">{{ $stats['total_tasks'] ?? 12 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">Tổng cộng</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-warning"><i class="fa-solid fa-hourglass-half"></i></div>
      <div class="stat-label">Chờ review</div>
      <div class="stat-val sv-warning">{{ $stats['pending_review'] ?? 3 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">Task ở trạng thái review</div>
    </div>
    <div class="stat-card">
      <div class="stat-icon si-danger"><i class="fa-solid fa-file-circle-exclamation"></i></div>
      <div class="stat-label">Báo cáo chưa duyệt</div>
      <div class="stat-val sv-danger">{{ $stats['pending_reports'] ?? 1 }}</div>
      <div style="font-size:12px;color:var(--c-text-sub);margin-top:4px">Cần nhận xét</div>
    </div>
  </div>

  <div class="grid-2">
    {{-- Interns roster --}}
    <div class="card">
      <div class="card-head">
        <div class="card-title"><i class="fa-solid fa-users"></i> Intern phụ trách</div>
        <a href="#" style="font-size:12px;color:var(--c-primary);text-decoration:none">Xem tất cả →</a>
      </div>
      @forelse(($interns ?? []) as $intern)
        <div class="intern-row">
          <div class="mini-avatar">{{ strtoupper(substr($intern->full_name, 0, 2)) }}</div>
          <div class="intern-row-name">{{ $intern->full_name }}<div class="intern-row-sub">{{ $intern->desired_technology }}</div></div>
          <span class="badge active-st">{{ $intern->status }}</span>
        </div>
      @empty
        <div class="intern-row"><div class="mini-avatar">NA</div><div class="intern-row-name">Nguyễn Văn An<div class="intern-row-sub">Laravel, Vue.js</div></div><span class="badge active-st">Đang TT</span></div>
        <div class="intern-row"><div class="mini-avatar">LB</div><div class="intern-row-name">Lê Thị Bình<div class="intern-row-sub">React, Node.js</div></div><span class="badge active-st">Đang TT</span></div>
      @endforelse
    </div>

    {{-- Near deadline tasks --}}
    <div class="card">
      <div class="card-head">
        <div class="card-title"><i class="fa-solid fa-clock"></i> Task gần deadline</div>
        <a href="#" style="font-size:12px;color:var(--c-primary);text-decoration:none">Xem tất cả →</a>
      </div>
      @forelse(($nearDeadlineTasks ?? []) as $task)
        <div class="intern-row">
          <span style="flex:1">{{ $task->title }} &middot; <span style="color:var(--c-text-sub)">{{ $task->intern_name }}</span></span>
          <span class="badge pri-{{ $task->priority }}">{{ $task->priority_label }}</span>
        </div>
      @empty
        <div class="intern-row"><span style="flex:1">Viết unit test &middot; <span style="color:var(--c-text-sub)">Nguyễn Văn An</span></span><span class="badge pri-high">Cao</span></div>
        <div class="intern-row"><span style="flex:1">Tích hợp Pinata API &middot; <span style="color:var(--c-text-sub)">Lê Thị Bình</span></span><span class="badge pri-medium">Trung bình</span></div>
        <div class="intern-row"><span style="flex:1">Báo cáo tuần 6 &middot; <span style="color:var(--c-text-sub)">Nguyễn Văn An</span></span><span class="badge pri-low">Thấp</span></div>
      @endforelse
    </div>
  </div>

  {{-- Tasks pending review --}}
  <div class="section-divider" style="margin-top:24px">Task chờ review</div>
  <div class="card">
    @forelse(($pendingReviewTasks ?? []) as $task)
      <div class="intern-row">
        <div class="mini-avatar">{{ strtoupper(substr($task->intern_name, 0, 2)) }}</div>
        <span style="flex:1">{{ $task->title }}</span>
        <span class="badge review">Review</span>
        <a href="{{ route('mentor.tasks') }}#task-{{ $task->id }}" class="btn btn-outline" style="padding:5px 10px;font-size:12px;margin-left:8px">Duyệt</a>
      </div>
    @empty
      <div class="intern-row"><div class="mini-avatar">NA</div><span style="flex:1">Viết API intern list</span><span class="badge review">Review</span><a href="#" class="btn btn-outline" style="padding:5px 10px;font-size:12px;margin-left:8px">Duyệt</a></div>
      <div class="intern-row"><div class="mini-avatar">LB</div><span style="flex:1">Thiết kế giao diện Task Board</span><span class="badge review">Review</span><a href="#" class="btn btn-outline" style="padding:5px 10px;font-size:12px;margin-left:8px">Duyệt</a></div>
    @endforelse
  </div>
@endsection
