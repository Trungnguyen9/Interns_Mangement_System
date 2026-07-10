@extends('frontend.mentor.layouts.mentor')

@section('title', 'Intern phụ trách')
@section('breadcrumb', 'Intern phụ trách')

@section('content')
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px">
        <div>
            <div class="page-title">Intern phụ trách</div>
            <div class="page-sub">Danh sách thực tập sinh bạn đang hướng dẫn ({{ $currentInterns ?? 0 }} /
                {{ $data->max_interns }} slot)</div>
        </div>
    </div>

    @if ($currentInterns >= $data->max_interns)
        <div class="capacity-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>Bạn đã đạt số lượng thực tập sinh tối đa là ({{ $data->max_interns }}) thực tập sinh. Liên hệ Admin nếu
                cần được gán thêm thực tập sinh.</span>
        </div>
    @endif

    {{-- Toolbar --}}
    <form method="GET" action="{{ route('frontend.mentor.interns') }}" class="toolbar">
        @csrf
        <input type="text" name="search" class="form-control" placeholder="Tìm intern theo tên hoặc email..."
            value="{{ request('search') }}">
        <select name="status" class="form-control" style="width:auto">
            <option value="">Tất cả trạng thái</option>
            <option value="Đang thực tập" @selected(request('status') === 'Đang thực tập')>Đang thực tập</option>
            <option value="Đã hoàn thành" @selected(request('status') === 'Đã hoàn thành')>Đã hoàn thành</option>
        </select>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
    </form>

    {{-- Table --}}
    <div class="tbl-wrap">
        <table class="tbl">
            <thead>
                <tr>
                    <th>Intern</th>
                    <th>Trường học</th>
                    <th>Công nghệ</th>
                    <th>Bắt đầu</th>
                    <th>Kết thúc</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($interns as $intern)
                    <tr>
                        <td style="display:flex;align-items:center;gap:10px">
                            <div class="mini-avatar">{{ strtoupper(substr($intern->full_name, 0, 3)) }}</div>
                            <div>
                                <div style="font-weight:600">{{ $intern->full_name }}</div>
                                <div style="font-size:11px;color:var(--c-text-sub)">{{ $intern->user->email ?? 'N/A' }}
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--c-text-sub)">{{ $intern->school }}</td>
                        <td style="color:var(--c-text-sub)">{{ $intern->desired_technology }}</td>
                        <td>{{ $intern->start_date }}</td>
                        <td>{{ $intern->end_date }}</td>
                        <td>
                            @if ($intern->status === 'Đang thực tập')
                                <span class="badge doing">{{ $intern->status }}</span>
                            @else
                                <span class="badge done">{{ $intern->status }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('frontend.mentor.interns.show', $intern->id) }}" class="btn btn-outline" style="padding:5px 10px;font-size:12px">
                                <i class="fa-solid fa-eye"></i> Xem
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $interns->links('vendor.pagination.ims') }}</div>

@endsection
