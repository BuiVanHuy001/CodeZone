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
                        <div class="tutor-bg-photo bg_image bg_image--14 height-350">
                        </div>

                        <div class="rbt-tutor-information">
                            <div class="rbt-tutor-information-left">
                                <div class="thumbnail rbt-avatars size-lg">
                                    <img src="{{ $instructor->avatar }}" alt="Instructor">
                                </div>
                                <div class="tutor-content">
                                    <h5 class="title">{{ $instructor->name }}</h5>
                                    <div class="rbt-review">
                                        <x-client.course-details.reviews.components.star
                                            :star-number="$instructor->rating"
                                            class="rating"
                                        />
                                        <span class="rating-count"> ({{ $instructor->reviewCountText }})</span>
                                    </div>
                                    <ul class="rbt-meta rbt-meta-white mt--5">
                                        <li><i class="feather-book"></i>{{ $instructor->courseCountText }}</li>
                                        <li><i class="feather-users"></i>{{ $instructor->studentCountText }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($instructor->aboutMe)
                    <div class="col-lg-12 mt--30">
                        <div class="profile-content rbt-shadow-box">
                            <h4 class="rbt-title-style-3">About me</h4>
                            <div class="row px-5">
                                <p class="mt--10 mb--20">
                                    {!! nl2br(e($instructor->aboutMe)) !!}
                                </p>
                                <x-client.share-ui.social-link-list :socials="$instructor->socialLinks"/>
                            </div>
                        </div>
                    </div>
                @endif

                @if($instructor->bio)
                    <div class="col-lg-12 mt--30">
                        <div class="profile-content rbt-shadow-box">
                            <h4 class="rbt-title-style-3">Biography</h4>
                            <div class="markdown-body has-show-more">
                                <div class="has-show-more-inner-content">
                                    @markdown($instructor->bio)
                                </div>
                                <div class="rbt-show-more-btn">Show More</div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-lg-12 mt--30">
                    <livewire:client.review.index
                        :model="$instructor"
                        :reviews="$instructor->reviews"
                    />
                </div>

                @if($instructor->courses)
                    <div class="rbt-profile-course-area mt--60">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="sction-title">
                                    <h2 class="rbt-title-style-3">My courses</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row g-5 mt--5">
                            @foreach($instructor->courses as $course)
                                <x-client.share-ui.course-card :$course/>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
@endsection
