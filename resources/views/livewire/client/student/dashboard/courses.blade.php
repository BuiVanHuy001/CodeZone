<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">

        <div class="section-title">
            <h4 class="rbt-title-style-3">My Courses</h4>
        </div>

        <div class="advance-tab-button mb--30">
            <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="myTab-4" role="tablist">
                <li role="presentation">
                    <a href="#" class="tab-button active" id="home-tab-4" data-bs-toggle="tab"
                       data-bs-target="#home-4" role="tab" aria-controls="home-4" aria-selected="true">
                        <span class="title">All Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="profile-tab-4" data-bs-toggle="tab"
                       data-bs-target="#profile-4" role="tab" aria-controls="profile-4" aria-selected="false">
                        <span class="title">Learning Courses</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="contact-tab-4" data-bs-toggle="tab"
                       data-bs-target="#contact-4" role="tab" aria-controls="contact-4" aria-selected="false">
                        <span class="title">Company Courses</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade active show" id="home-4" role="tabpanel" aria-labelledby="home-tab-4">
                <div class="row g-5">
                    @forelse($courses as $course)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="rbt-card variation-01 rbt-hover">
                                <div class="rbt-card-img">
                                    <a href="">
                                        <img src="{{ $course->getThumbnailPath() }}" alt="Card image">
                                    </a>
                                </div>
                                <div class="rbt-card-body">
                                    <h4 class="rbt-card-title">
                                        <a href="{{ route('page.course_detail', $course->slug) }}">{{ $course->title }}</a>
                                    </h4>
                                    <ul class="rbt-meta">
                                        <li><i class="feather-book"></i>{{ $course->lesson_count }} Lessons</li>
                                        <li><i class="feather-clock"></i>{{ $course->convertDurationToString() }}</li>
                                    </ul>
                                </div>
                                <div class="rbt-progress-style-1 mb--20 mt--10">
                                    <div class="single-progress">
                                        <h6 class="rbt-title-style-2 mb--10">Complete</h6>
                                        <div class="progress">
                                            <div class="progress-bar wow fadeInLeft bar-color-success"
                                                 data-wow-duration="0.5s" data-wow-delay=".3s" role="progressbar"
                                                 style="width: {{ auth()->user()->calculateCourseProgress($course) }}%" aria-valuenow="100" aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                            <span class="rbt-title-style-2 progress-number">{{ auth()->user()->calculateCourseProgress($course) }}%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-card-bottom">
                                    <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center"
                                       href="{{ route('course.learn', [$course->slug]) }}">Go to course</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <strong>No pending courses found.</strong>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="tab-pane fade" id="profile-4" role="tabpanel" aria-labelledby="profile-tab-4">
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-04.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (3 Reviews)</span>
                                    </div>
                                    <div class="rbt-bookmark-btn">
                                        <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                                class="feather-bookmark"></i></a>
                                    </div>
                                </div>
                                <h4 class="rbt-card-title"><a href="">English Langiage Club</a>
                                </h4>
                                <ul class="rbt-meta">
                                    <li><i class="feather-book"></i>20 Lessons</li>
                                    <li><i class="feather-users"></i>30 Students</li>
                                </ul>

                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$40</span>
                                        <span class="off-price">$86</span>
                                    </div>
                                    <a class="rbt-btn-link" href="">Learn
                                        More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->

                    <!-- Start Single Course  -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-06.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (3 Reviews)</span>
                                    </div>
                                    <div class="rbt-bookmark-btn">
                                        <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                                class="feather-bookmark"></i></a>
                                    </div>
                                </div>
                                <h4 class="rbt-card-title"><a href="">Graphic Courses Club</a>
                                </h4>
                                <ul class="rbt-meta">
                                    <li><i class="feather-book"></i>50 Lessons</li>
                                    <li><i class="feather-users"></i>10 Students</li>
                                </ul>

                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$40</span>
                                        <span class="off-price">$86</span>
                                    </div>
                                    <a class="rbt-btn-link" href="">Learn
                                        More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->

                    <!-- Start Single Course  -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-05.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (3 Reviews)</span>
                                    </div>
                                    <div class="rbt-bookmark-btn">
                                        <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                                class="feather-bookmark"></i></a>
                                    </div>
                                </div>
                                <h4 class="rbt-card-title"><a href="">Wed Design Club</a>
                                </h4>
                                <ul class="rbt-meta">
                                    <li><i class="feather-book"></i>20 Lessons</li>
                                    <li><i class="feather-users"></i>30 Students</li>
                                </ul>

                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">$40</span>
                                        <span class="off-price">$86</span>
                                    </div>
                                    <a class="rbt-btn-link" href="">Learn
                                        More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->

                </div>
            </div>

            <div class="tab-pane fade" id="contact-4" role="tabpanel" aria-labelledby="contact-tab-4">
                <div class="row g-5">
                    <!-- Start Single Course  -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-01.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (15 Reviews)</span>
                                    </div>
                                    <div class="rbt-bookmark-btn">
                                        <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                                class="feather-bookmark"></i></a>
                                    </div>
                                </div>
                                <h4 class="rbt-card-title"><a href="">React Front To Back</a>
                                </h4>
                                <ul class="rbt-meta">
                                    <li><i class="feather-book"></i>20 Lessons</li>
                                    <li><i class="feather-users"></i>40 Students</li>
                                </ul>

                                <div class="rbt-progress-style-1 mb--20 mt--10">
                                    <div class="single-progress">
                                        <h6 class="rbt-title-style-2 mb--10">Complete</h6>
                                        <div class="progress">
                                            <div class="progress-bar wow fadeInLeft bar-color-success"
                                                 data-wow-duration="0.5s" data-wow-delay=".3s" role="progressbar"
                                                 style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                            <span class="rbt-title-style-2 progress-number">100%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-card-bottom">
                                    <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center"
                                       href="#">Download Certificate</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->

                    <!-- Start Single Course  -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-02.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (15 Reviews)</span>
                                    </div>
                                    <div class="rbt-bookmark-btn">
                                        <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                                class="feather-bookmark"></i></a>
                                    </div>
                                </div>
                                <h4 class="rbt-card-title"><a href="">PHP
                                        Beginner + Advanced</a>
                                </h4>
                                <ul class="rbt-meta">
                                    <li><i class="feather-book"></i>10 Lessons</li>
                                    <li><i class="feather-users"></i>30 Students</li>
                                </ul>

                                <div class="rbt-progress-style-1 mb--20 mt--10">
                                    <div class="single-progress">
                                        <h6 class="rbt-title-style-2 mb--10">Complete</h6>
                                        <div class="progress">
                                            <div class="progress-bar wow fadeInLeft bar-color-success"
                                                 data-wow-duration="0.5s" data-wow-delay=".3s" role="progressbar"
                                                 style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                            <span class="rbt-title-style-2 progress-number">100%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-card-bottom">
                                    <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center"
                                       href="#">Download Certificate</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->

                    <!-- Start Single Course  -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="">
                                    <img src="{{ asset('images/course/course-online-03.jpg') }}" alt="Card image">
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (4 Reviews)</span>
                                    </div>
                                    <div class="rbt-bookmark-btn">
                                        <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                                class="feather-bookmark"></i></a>
                                    </div>
                                </div>
                                <h4 class="rbt-card-title"><a href="">Angular Zero to
                                        Mastery</a>
                                </h4>
                                <ul class="rbt-meta">
                                    <li><i class="feather-book"></i>14 Lessons</li>
                                    <li><i class="feather-users"></i>26 Students</li>
                                </ul>

                                <div class="rbt-progress-style-1 mb--20 mt--10">
                                    <div class="single-progress">
                                        <h6 class="rbt-title-style-2 mb--10">Complete</h6>
                                        <div class="progress">
                                            <div class="progress-bar wow fadeInLeft bar-color-success"
                                                 data-wow-duration="0.5s" data-wow-delay=".3s" role="progressbar"
                                                 style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                            <span class="rbt-title-style-2 progress-number">100%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rbt-card-bottom">
                                    <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center"
                                       href="#">Download Certificate</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Course  -->
                </div>
            </div>
        </div>

    </div>
</div>
