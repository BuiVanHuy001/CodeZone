@extends('layouts.client')

@section('content')
    <div class="rbt-error-area bg-gradient-11 rbt-section-gap">
        <div class="error-area">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-10">
                        <h1 class="title">404!</h1>
                        <h3 class="sub-title">Page not found</h3>
                        <p>The page you were looking for could not be found.</p>
                        <a class="rbt-btn btn-gradient icon-hover" href="{{ route('page.home') }}">
                            <span class="btn-text">Back To Home</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
