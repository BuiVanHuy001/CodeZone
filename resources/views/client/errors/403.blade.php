@extends('layouts.client')

@section('title', '403 - Không có quyền truy cập')

@section('content')
    <div class="rbt-error-area bg-gradient-11 rbt-section-gap">
        <div class="error-area">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-10">
                        <h1 class="title">403!</h1>
                        <h3 class="sub-title">Truy cập bị từ chối</h3>
                        <p>Rất tiếc, bạn không có quyền truy cập vào khu vực này. Nếu bạn cho rằng đây là sự nhầm lẫn,
                            vui lòng liên hệ với Quản trị viên để được hỗ trợ.</p>
                        <a class="rbt-btn btn-gradient icon-hover" href="{{ route('page.home') }}">
                            <span class="btn-text">Trở về trang chủ</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
