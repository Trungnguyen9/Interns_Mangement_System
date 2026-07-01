@extends('frontend.intern.layouts.intern')

@section('title', 'Hồ sơ')
@section('breadcrumb', 'Hồ sơ')

@section('content')
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px">
        <div>
            <div class="page-title">Hồ sơ cá nhân</div>
            <div class="page-sub">Thông tin tài khoản và thực tập</div>
        </div>
        <a class="btn btn-outline" href="{{ route('frontend.intern.profile.edit', $intern->id) }}"><i
                class="fa-solid fa-pen"></i> Chỉnh sửa</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Hero banner --}}
    <div class="profile-hero">
        <div class="profile-avatar-lg">{{ strtoupper(substr($intern->full_name ?? '#', 0, 1)) }}</div>
        <div>
            <div class="profile-name">{{ $intern->full_name ?? '#' }}</div>
            <div class="profile-meta">
                <span><i class="fa-solid fa-envelope" style="font-size:12px"></i>
                    {{ $intern->user->email ?? '#@intern.ims.vn' }}</span>
                <span>·</span>
                <span><i class="fa-solid fa-graduation-cap" style="font-size:12px"></i> {{ $intern->school ?? '#' }}</span>
                <span>·</span>
                <span
                    style="background:rgba(255,255,255,.2);padding:2px 10px;border-radius:99px;font-size:11px">{{ $intern->status ?? '#' }}</span>
            </div>
        </div>
    </div>

    {{-- Account info --}}
    <div class="section-divider">Thông tin tài khoản</div>
    <div class="info-grid">
        <div class="info-field">
            <div class="info-field-label">Username</div>
            <div class="info-field-val">{{ $intern->user->name ?? '#' }}</div>
        </div>
        <div class="info-field">
            <div class="info-field-label">Email</div>
            <div class="info-field-val">{{ $intern->user->email ?? '#@intern.ims.vn' }}</div>
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
                Intern &nbsp;<span style="font-size:11px;color:var(--c-text-sub)"></span>
            </div>
        </div>
    </div>

    {{-- Intern info --}}
    <div class="section-divider">Thông tin thực tập</div>
    <div class="info-grid">
        <div class="info-field">
            <div class="info-field-label">Họ và tên</div>
            <div class="info-field-val">{{ $intern->full_name ?? '#' }}</div>
        </div>
        <div class="info-field">
            <div class="info-field-label">Trường đại học</div>
            <div class="info-field-val">{{ $intern->school ?? '#' }}</div>
        </div>
        <div class="info-field">
            <div class="info-field-label">Năm học</div>
            <div class="info-field-val">{{ $intern->academic_year ?? '#' }}</div>
        </div>
        <div class="info-field">
            <div class="info-field-label">Công nghệ mong muốn</div>
            <div class="info-field-val">{{ $intern->desired_technology ?? '#' }}</div>
        </div>
        <div class="info-field">
            <div class="info-field-label">Ngày bắt đầu</div>
            <div class="info-field-val">{{ $intern->start_date ?? '#' }}</div>
        </div>
        <div class="info-field">
            <div class="info-field-label">Ngày kết thúc</div>
            <div class="info-field-val">{{ $intern->end_date ?? '#' }}</div>
        </div>
        <div class="info-field" style="grid-column:1/-1">
            <div class="info-field-label">Trạng thái thực tập</div>
            <div class="info-field-val"><span class="badge inprog">{{ $intern->status ?? '#' }}</span></div>
        </div>
    </div>

    {{-- Mentor info --}}
    <div class="section-divider">Mentor phụ trách</div>
    <div class="card" style="display:flex;align-items:center;gap:16px">
        <div
            style="width:48px;height:48px;border-radius:50%;background:var(--c-success-l);color:var(--c-success);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;flex-shrink:0">
            {{ strtoupper(substr($intern->mentor->full_name ?? '#', 0, 2)) }}
        </div>
        <div style="flex:1">
            <div style="font-size:15px;font-weight:600">{{ $intern->mentor->full_name ?? 'Trần Thị Hoa' }}</div>
            <div style="font-size:13px;color:var(--c-text-sub)">{{ $intern->mentor->department ?? '#' }} &nbsp;·&nbsp;
                {{ $intern->mentor->position ?? '#' }}</div>
            <div style="font-size:13px;color:var(--c-info);margin-top:2px">
                <i class="fa-solid fa-envelope" style="font-size:12px"></i>
                {{ $intern->mentor->user->email ?? '#@company.vn' }}
            </div>
        </div>
    </div>
@endsection
