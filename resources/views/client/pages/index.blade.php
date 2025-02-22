@extends('layouts.client')

@section('content')

    <div class="rbt-banner-area rbt-banner-1 variation-2 height-750">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-8">
                    <div class="content">
                        <div class="inner">
                            <div class="rbt-new-badge rbt-new-badge-one">
                                <span class="rbt-new-badge-icon">🏆</span> Leading Platform in Online Learning
                            </div>
                            <h1 class="title">The Largest <span class="color-primary">Online Learning</span> Platform to Boost Your Career.</h1>
                            <p class="description">Explore hundreds of high-quality programming courses from top industry experts. Learn <strong>anytime</strong>, <strong>anywhere</strong>, and
                                <strong>upgrade your skills</strong> to advance your tech career.
                            </p>
                            <div class="slider-btn">
                                <a class="rbt-btn btn-gradient hover-icon-reverse" href="#">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">View Course</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="content">
                        <div class="banner-card pb--60 swiper rbt-dot-bottom-center banner-swiper-active">
                            <div class="swiper-wrapper">
                                <x-client.bannercourseitem/>
                                <x-client.bannercourseitem/>
                                <x-client.bannercourseitem/>
                            </div>
                            <div class="rbt-swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-categories-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mb--60">
                        <h2 class="title">Course Categories</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <x-client.category-list :categories="$categories"/>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-course-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--55 g-5 align-items-end">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">Top Popular Course</span>
                        <h2 class="title">Most Popular <span class="color-primary">Courses</span></h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="load-more-btn text-start text-md-end">
                        <a class="rbt-btn rbt-switch-btn bg-primary-opacity" href="course.html">
                            <span data-text="View All Course">View All Course</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <x-client.popular-course-item/>
                <x-client.popular-course-item/>
                <x-client.popular-course-item/>
                <x-client.popular-course-item/>
                <x-client.popular-course-item/>
                <x-client.popular-course-item/>
            </div>
        </div>
    </div>

    <div class="rbt-testimonial-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb--60">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                        <h2 class="title">Student's <span class="color-primary">Feedback</span></h2>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <!-- Start Single Testimonial  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="assets/images/testimonial/client-01.png" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Martha Maldonado</h5>
                                    <span>Executive Chairman <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="rating mt--20">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="assets/images/testimonial/client-02.png" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Michael D. Lovelady</h5>
                                    <span>CEO <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                <div class="rating mt--20">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="assets/images/testimonial/client-03.png" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Valerie J. Creasman</h5>
                                    <span>Executive Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                <div class="rating mt--20">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
            </div>
        </div>
    </div>

    <div class="rbt-rbt-blog-area rbt-section-gapTop bg-color-white">
        <div class="container">
            <div class="row mb--55 g-5 align-items-end">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">Top News</span>
                        <h2 class="title">Have a look on <span class="color-primary">our News</span></h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="load-more-btn text-start text-md-end">
                        <a class="rbt-btn rbt-switch-btn bg-primary-opacity" href="blog.html">
                            <span data-text="View All News">View All News</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <x-client.index-blog-item/>
                <x-client.index-blog-item/>
                <x-client.index-blog-item/>
            </div>
        </div>
    </div>
@endsection
