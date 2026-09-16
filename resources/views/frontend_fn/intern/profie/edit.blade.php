@extends('frontend.intern.layouts.intern')

@section('title', 'Hồ sơ')
@section('breadcrumb', 'Hồ sơ')

@section('content')
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px">
        <div>
            <div class="page-title">Chỉnh sửa thông tin cá nhân</div>
        </div>
        <div style="display:flex;gap:10px">
            <button type="button" class="btn btn-outline" onclick="window.history.back()">Hủy</button>
            <button type="submit" form="profile-edit-form" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="profile-edit-form" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $intern->user_id }}">

        {{-- Account info (read-only) --}}
        <div class="section-divider">Thông tin tài khoản</div>
        <div class="info-grid">
            <div class="info-field">
                <div class="info-field-label">Username</div>
                <input type="text" id="name" name="name" class="form-control" value="{{ $intern->user->name }}"
                    placeholder="#">
            </div>
            <div class="info-field">
                <div class="info-field-label">Email</div>
                <div class="info-field-val">{{ $intern->user->email ?? '#@intern.ims.vn' }}</div>
            </div>
            <div class="info-field">
                <div class="info-field-label">Trạng thái tài khoản</div>
                <div class="info-field-val">
                    <span class="badge {{ ($intern->user->status ?? 'active') === 'active' ? 'done' : 'overdue' }}">
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

        {{-- Intern info (editable) --}}
        <div class="section-divider">Thông tin thực tập</div>
        <div class="info-grid">
            <div class="info-field">
                <label class="info-field-label" for="full_name">Họ và tên</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="{{ $intern->full_name }}"
                    placeholder="#">
            </div>
            <div class="info-field">
                <label class="info-field-label" for="school">Trường đại học</label>
                <input type="text" id="school" name="school" class="form-control" value="{{ $intern->school }}"
                    placeholder="#">
            </div>
            <div class="info-field">
                <label class="info-field-label" for="academic_year">Năm học</label>
                <input type="text" id="academic_year" name="academic_year" class="form-control"
                    value="{{ $intern->academic_year }}" placeholder="#">
            </div>
            <div class="info-field">
                <label class="info-field-label" for="desired_technology">Công nghệ mong muốn</label>
                <input type="text" id="desired_technology" name="desired_technology" class="form-control"
                    value="{{ $intern->desired_technology }}" placeholder="#">
            </div>
            <div class="info-field">
                <label class="info-field-label" for="start_date">Ngày bắt đầu</label>
                <input type="date" id="start_date" name="start_date" class="form-control"
                    value="{{ $intern->start_date }}">
            </div>
            <div class="info-field">
                <label class="info-field-label" for="end_date">Ngày kết thúc</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $intern->end_date }}">
            </div>
            <div class="info-field" style="grid-column:1/-1">
                <div class="info-field-label">Trạng thái thực tập</div>
                <div class="info-field-val"><span class="badge inprog">{{ $intern->status ?? '#' }}</span></div>
            </div>
        </div>
    </form>

@endsection
