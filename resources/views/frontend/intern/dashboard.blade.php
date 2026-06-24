{{--
    Trang preview đơn giản để kiểm tra layout Intern.
--}}

@extends('frontend.layouts.intern')

@section('title', 'Bảng điều khiển Intern')

@section('breadcrumb')
    <span class="crumb-current">Dashboard Intern</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Giao diện Intern</h1>
        <p class="page-subtitle">Đây là trang preview dành cho Intern.</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Nội dung demo</span>
    </div>
    <div class="card-body">
        <p>Đây là trang mẫu để xem trước layout và sidebar dành cho Intern.</p>
    </div>
</div>
@endsection
