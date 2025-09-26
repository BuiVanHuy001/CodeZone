@extends('layouts.client')

@section('content')
    <div class="rbt-breadcrumb-default rbt-breadcrumb-style-3">
        <div class="breadcrumb-inner breadcrumb-dark">
            <img src="{{ asset('images/bg/bg-image-10.jpg') }}" alt="Education Images">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content text-start">
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Web developer</li>
                        </ul>
                        <h1 class="title">{{ $course->title }}</h1>
                        <p class="description">{{ $course->heading }}</p>

                        <div class="d-flex align-items-center mb--20 flex-wrap rbt-course-details-feature">

                            <div class="feature-sin best-seller-badge">
                                <span class="rbt-badge-2">
                                    <span class="image">
                                        <img src="{{ asset('images/icons/card-icon-1.png') }}" alt="Best Seller Icon">
                                    </span> Bestseller
                                </span>
                            </div>

                            <div class="feature-sin rating">
                                <a href="#">{{ $course->rating }}</a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                                <a href="#"><i class="fa fa-star"></i></a>
                            </div>

                            <div class="feature-sin total-rating">
                                <a class="rbt-badge-4" href="#">{{ $course->review_count }} rating</a>
                            </div>

                            <div class="feature-sin total-student">
                                <span>{{ $course->enrollment_count }} {{ \Illuminate\Support\Str::plural('student', $course->enrollment_count) }}</span>
                            </div>

                        </div>

                        <div class="rbt-author-meta mb--20">
                            <div class="rbt-avater">
                                <a href="#">
                                    <img src="{{ $course->author->getAvatarPath() }}" alt="Instructor avatar">
                                </a>
                            </div>
                            <div class="rbt-author-info">
                                By <a href="">{{ $course->author->name }}</a> in
                                <a href="#">{{ $course->category->name }}</a>
                            </div>
                        </div>

                        <ul class="rbt-meta">
                            <li><i class="feather-calendar"></i>Last updates {{ $course->updated_at->diffForHumans() }}
                            </li>
                            <li><i class="feather-globe"></i>English</li>
                            <li><i class="feather-award"></i>Certification</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-course-details-area ptb--60">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="course-details-content">
                        <div class="rbt-inner-onepage-navigation sticky-top">
                            <nav class="mainmenu-nav onepagenav">
                                <ul class="mainmenu">
                                    <li class="current">
                                        <a href="#overview">Overview</a>
                                    </li>
                                    <li>
                                        <a href="#details">Description</a>
                                    </li>
                                    <li>
                                        <a href="#coursecontent">Course content</a>
                                    </li>
                                    <li>
                                        <a href="#instructor">Instructor</a>
                                    </li>
                                    <li>
                                        <a href="#review">Reviews</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        @if($course->skills)
                            <x-client.course-details.feature-box
                                title="What you'll learn"
                                :features="$course->skills"
                            />
                        @endif

                        @if($course->requirements)
                            <x-client.course-details.feature-box
                                title="Requirements"
                                :features="$course->requirements"
                            />
                        @endif

                        @if($course->target_audiences)
                            <x-client.course-details.feature-box
                                title="Who this course is for"
                                :features="$course->target_audiences"
                            />
                        @endif

                        <x-client.course-details.description
                            :description="$course->description"
                        />


                        <x-client.course-details.content
                            :course="$course"
                        />

                        <x-client.course-details.instructor
                            :instructor="$course->author"
                        />

                        @if($course->review_count > 1)
                            <livewire:client.review.index :$course/>
                        @endif
                    </div>

                    <x-client.course-details.related-course
                        :authorId="$course->author->id"
                        :currentCourseId="$course->id"
                    />
                </div>

                <div class="col-lg-4">
                    <div class="course-sidebar sticky-top rbt-shadow-box course-sidebar-top rbt-gradient-border">
                        <div class="inner">
                            <a class="video-popup-with-text video-popup-wrapper text-center popup-video sidebar-video-hidden mb--15"
                               href="{{ asset($course->getIntroductionVideo()) }}"
                            >
                                <div class="video-content">
                                    <img class="w-100 rbt-radius" src="{{ $course->getThumbnailPath() }}"
                                         alt="Video Images">
                                    <div class="position-to-top">
                                        <span class="rbt-btn rounded-player-2 with-animation">
                                            <span class="play-icon"></span>
                                        </span>
                                    </div>
                                    <span class="play-view-text d-block color-white"><i class="feather-eye"></i>Preview this course</span>
                                </div>
                            </a>

                            <div class="content-item-content">
                                @if(!$course->author->isOrganization())
                                    <div
                                        class="rbt-price-wrapper d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="rbt-price">
                                            <span class="current-price">{{ number_format($course->price) }}₫</span>
                                        </div>
                                        <div class="discount-time">
                                        <span class="rbt-badge color-danger bg-color-danger-opacity"><i
                                                class="feather-clock"></i> 3 days left!</span>
                                        </div>
                                    </div>
                                    @if($canAccess)
                                        <div class="buy-now-btn mt--15">
                                            <a class="rbt-btn btn-border icon-hover w-100 d-block text-center" href="{{ route('course.learn', $course->slug) }}">
                                                <span class="btn-text">Go to course</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </a>
                                        </div>
                                    @else
                                        <div class="add-to-card-button mt--15">
                                            <button onclick="Livewire.dispatch('add-to-cart', ['{{ $course->id }}'])" class="rbt-btn btn-gradient icon-hover w-100 d-block text-center">
                                                <span class="btn-text">Add to cart</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <h5 class="text-center text-primary">This is Organization Course</h5>
                                @endif
                                <div class="rbt-widget-details has-show-more">
                                    <ul class="has-show-more-inner-content rbt-course-details-list-wrapper">
                                        <li>
                                            <span>Duration: </span><span class="rbt-feature-value rbt-badge-5">{{ $course->convertDurationToString()  }}</span>
                                        </li>
                                        <li>
                                            <span>Enrolled: </span><span
                                                class="rbt-feature-value rbt-badge-5">{{ $course->enrollment_count }}</span>
                                        </li>
                                        <li>
                                            <span>Lesson: </span><span class="rbt-feature-value rbt-badge-5">{{ $course->lesson_count }}</span>
                                        </li>
                                        <li>
                                            <span>Level: </span><span class="rbt-feature-value rbt-badge-5">{{ ucfirst($course->level) }}</span>
                                        </li>
                                        @if($course->getQuizCount() > 0)
                                            <li>
                                                <span>Quiz: </span><span class="rbt-feature-value rbt-badge-5">{{ $course->getQuizCount() }}</span>
                                            </li>
                                        @endif
                                        <li>
                                            <span>Certification: </span><span
                                                class="rbt-feature-value rbt-badge-5">Yes</span>
                                        </li>
                                    </ul>
                                    <div class="rbt-show-more-btn">Show more</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>

    <div class="rbt-course-action-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="section-title text-center text-md-start">
                        <h5 class="title mb--0">{{ $course->title }}</h5>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mt_sm--15">
                    <div class="course-action-bottom-right rbt-single-group">
                        <div class="rbt-single-list rbt-price large-size justify-content-center">
                            <span class="current-price color-primary">{{ $course->getFormattedPrice() }}</span>
                            {{--                            <span class="off-price">37.500.000₫</span>--}}
                        </div>
                        <div class="rbt-single-list action-btn">
                            <a class="rbt-btn btn-gradient hover-icon-reverse btn-md" href="#">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Buy now</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
@endsection
