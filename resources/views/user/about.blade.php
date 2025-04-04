@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="display-4">Giới thiệu về Movie Website</h1>
        <p class="lead">Nền tảng xem phim trực tuyến hàng đầu Việt Nam</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <h3>Về chúng tôi</h3>
        <p>Movie Website là nền tảng xem phim trực tuyến với hơn 10.000 bộ phim chất lượng cao. Chúng tôi cung cấp trải nghiệm xem phim tốt nhất cho người dùng Việt Nam.</p>
    </div>
    <div class="col-md-6">
        <h3>Dịch vụ của chúng tôi</h3>
        <ul>
            <li>Xem phim chất lượng cao</li>
            <li>Phụ đề tiếng Việt</li>
            <li>Giao diện thân thiện</li>
            <li>Hỗ trợ đa nền tảng</li>
        </ul>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h3>Liên hệ</h3>
        <p>Email: contact@moviewebsite.com</p>
        <p>Điện thoại: 0123 456 789</p>
        <p>Địa chỉ: 123 Đường ABC, Quận XYZ, TP.HCM</p>
    </div>
</div>
@endsection
