<div class="rbt-banner-area rbt-banner-1 variation-2 height-750">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-8">
                <div class="content">
                    <div class="inner">
                        <div class="rbt-new-badge rbt-new-badge-one">
                            <span class="rbt-new-badge-icon">🎓</span> Cổng thông tin đào tạo trực tuyến
                        </div>
                        <h1 class="title">Hệ thống E-Learning <br> <span class="color-primary">Cao Đẳng Việt Mỹ</span>
                        </h1>
                        <p class="description">Truy cập lộ trình môn học chính khóa và mở rộng kỹ năng với thư viện khóa
                            học nâng cao. Thực học - Thực nghiệp ngay trên nền tảng số.</p>
                        <div class="slider-btn">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="#">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Vào lớp học ngay</span>
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
                            @foreach($hotCourses as $course)
                                <div class="swiper-slide">
                                    <div class="rbt-card variation-01 rbt-hover">
                                        <div class="rbt-card-img">
                                            <a href="{{ $course->detailsPageUrl }}">
                                                <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
                                            </a>
                                        </div>
                                        <div class="rbt-card-body">
                                            <ul class="rbt-meta">
                                                <li><i class="feather-book"></i>{{ $course->lessonCountText }}</li>
                                                <li><i class="feather-users"></i>{{ $course->enrollmentCountText }}</li>
                                            </ul>
                                            <h4 class="rbt-card-title">
                                                <a href="{{ $course->detailsPageUrl }}">{{ $course->title }}</a>
                                            </h4>
                                            <p class="rbt-card-text">{{ $course->heading }}</p>
                                            <div class="rbt-review">
                                                <x-client.course-details.reviews.components.star :starNumber="$course->rating" class="rating"/>
                                                <span class="rating-count"> ({{ $course->reviewCountText }})</span>
                                            </div>
                                            <div class="rbt-card-bottom">
                                                <div class="rbt-price">
                                                    <span class="current-price">{{ $course->priceFormatted }}</span>
                                                </div>
                                                <a class="rbt-btn-link" href="{{ $course->detailsPageUrl }}">Chi tiết
                                                    <i class="feather-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="rbt-swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
