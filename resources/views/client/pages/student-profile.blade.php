@extends('layouts.client')

@section('content')
    <div class="rbt-page-banner-wrapper">
        <div class="rbt-banner-image"></div>
    </div>
    <div class="rbt-dashboard-area rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="rbt-dashboard-content-wrapper">
                        <div class="tutor-bg-photo bg_image bg_image--12 height-350">
                        </div>

                        <div class="rbt-tutor-information">
                            <div class="rbt-tutor-information-left">
                                <div class="thumbnail rbt-avatars size-lg">
                                    <img src="{{ $student->avatar }}" alt="Instructor">
                                </div>
                                <div class="tutor-content">
                                    <h5 class="title">{{ $student->name }}</h5>
                                    <ul class="rbt-meta rbt-meta-white mt--5">
                                        <li><i class="feather-book"></i>{{ $student->enrolledCountText }}</li>
                                        <li><i class="feather-check-circle"></i>{{ $student->completedCountText }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
