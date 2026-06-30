@extends('frontend.intern.layouts.intern')

@section('title', 'Hồ sơ')
@section('breadcrumb', 'Hồ sơ')

@section('content')
  <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px">
    <div>
      <div class="page-title">Hồ sơ cá nhân</div>
      <div class="page-sub">Thông tin tài khoản và thực tập</div>
    </div>
    <button class="btn btn-outline"><i class="fa-solid fa-pen"></i> Yêu cầu chỉnh sửa</button>
  </div>

  {{-- Hero banner --}}
  <div class="profile-hero">
    <div class="profile-avatar-lg">{{ strtoupper(substr($intern->full_name ?? 'Nguyễn Văn An', 0, 2)) }}</div>
    <div>
      <div class="profile-name">{{ $intern->full_name ?? 'Nguyễn Văn An' }}</div>
      <div class="profile-meta">
        <span><i class="fa-solid fa-envelope" style="font-size:12px"></i> {{ $user->email ?? 'an.nguyen@intern.ims.vn' }}</span>
        <span>·</span>
        <span><i class="fa-solid fa-graduation-cap" style="font-size:12px"></i> {{ $intern->school ?? 'Đại học Đà Nẵng' }}</span>
        <span>·</span>
        <span style="background:rgba(255,255,255,.2);padding:2px 10px;border-radius:99px;font-size:11px">{{ $intern->status ?? 'Đang thực tập' }}</span>
      </div>
    </div>
  </div>

  {{-- Account info --}}
  <div class="section-divider">Thông tin tài khoản</div>
  <div class="info-grid">
    <div class="info-field">
      <div class="info-field-label">Username</div>
      <div class="info-field-val">{{ $user->name ?? 'an.nguyen' }}</div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Email</div>
      <div class="info-field-val">{{ $user->email ?? 'an.nguyen@intern.ims.vn' }}</div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Trạng thái tài khoản</div>
      <div class="info-field-val">
        <span class="badge {{ ($user->status ?? 'active') === 'active' ? 'done' : 'overdue' }}">
          {{ ucfirst($user->status ?? 'active') }}
        </span>
      </div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Role</div>
      <div class="info-field-val" style="color:var(--c-info)">
        Intern &nbsp;<span style="font-size:11px;color:var(--c-text-sub)">(id_role = 3)</span>
      </div>
    </div>
  </div>

  {{-- Intern info --}}
  <div class="section-divider">Thông tin thực tập</div>
  <div class="info-grid">
    <div class="info-field">
      <div class="info-field-label">Họ và tên</div>
      <div class="info-field-val">{{ $intern->full_name ?? 'Nguyễn Văn An' }}</div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Trường đại học</div>
      <div class="info-field-val">{{ $intern->school ?? 'Đại học Đà Nẵng – Khoa CNTT' }}</div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Năm học</div>
      <div class="info-field-val">{{ $intern->academic_year ?? 'Năm 3' }}</div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Công nghệ mong muốn</div>
      <div class="info-field-val">{{ $intern->desired_technology ?? 'Laravel · Vue.js · MySQL' }}</div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Ngày bắt đầu</div>
      <div class="info-field-val">{{ $intern->start_date ?? '01/06/2025' }}</div>
    </div>
    <div class="info-field">
      <div class="info-field-label">Ngày kết thúc</div>
      <div class="info-field-val">{{ $intern->end_date ?? '31/08/2025' }}</div>
    </div>
    <div class="info-field" style="grid-column:1/-1">
      <div class="info-field-label">Trạng thái thực tập</div>
      <div class="info-field-val"><span class="badge inprog">{{ $intern->status ?? 'Đang thực tập' }}</span></div>
    </div>
  </div>

  {{-- Mentor info --}}
  <div class="section-divider">Mentor phụ trách</div>
  <div class="card" style="display:flex;align-items:center;gap:16px">
    <div style="width:48px;height:48px;border-radius:50%;background:var(--c-success-l);color:var(--c-success);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;flex-shrink:0">
      {{ strtoupper(substr($mentor->full_name ?? 'Trần Thị Hoa', 0, 2)) }}
    </div>
    <div style="flex:1">
      <div style="font-size:15px;font-weight:600">{{ $mentor->full_name ?? 'Trần Thị Hoa' }}</div>
      <div style="font-size:13px;color:var(--c-text-sub)">{{ $mentor->department ?? 'Engineering' }} &nbsp;·&nbsp; {{ $mentor->position ?? 'Senior Developer' }}</div>
      <div style="font-size:13px;color:var(--c-info);margin-top:2px">
        <i class="fa-solid fa-envelope" style="font-size:12px"></i> {{ $mentor->email ?? 'hoa.tran@company.vn' }}
      </div>
    </div>
    <div style="text-align:right;font-size:12px;color:var(--c-text-sub)">
      <div>Tối đa {{ $mentor->max_interns ?? 3 }} intern</div>
      <div style="color:var(--c-success);font-weight:600;margin-top:2px">{{ $mentor->current_interns ?? 2 }} / {{ $mentor->max_interns ?? 3 }} hiện tại</div>
    </div>
  </div>
@endsection
