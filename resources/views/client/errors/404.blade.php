@extends('layouts.client')

@section('title', '404 - Không tìm thấy trang')

@section('content')
    <div class="rbt-error-area bg-gradient-11 rbt-section-gap">
        <div class="error-area">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-10">
                        <h1 class="title">404!</h1>
                        <h3 class="sub-title">Không tìm thấy trang</h3>
                        <p>Rất tiếc, trang bạn đang tìm kiếm không tồn tại, đã bị xóa hoặc địa chỉ URL không chính xác.
                            Vui lòng kiểm tra lại đường dẫn.</p>
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
