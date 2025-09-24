    <div class="rbt-course-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--55 g-5 align-items-end">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">Top Trending Courses</span>
                        <h2 class="title">Most <span class="color-primary">Popular Courses</span></h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="load-more-btn text-start text-md-end">
                        <a class="rbt-btn rbt-switch-btn bg-primary-opacity" href="">
                            <span data-text="View all Khóa học">View all courses</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                @foreach($courses as $course)
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12" data-sal-delay="300" data-sal="slide-up" data-sal-duration="800">
                        <div class="rbt-card variation-01 rbt-hover">
                            <div class="rbt-card-img">
                                <a href="{{ route('page.course_detail', $course->slug) }}">
                                    <img src="{{ $course->getThumbnailPath() }}" alt="Card image">
                                    {{--                                    <div class="rbt-badge-3 bg-white">--}}
                                    {{--                                        <span>-40%</span>--}}
                                    {{--                                        <span>Off</span>--}}
                                    {{--                                    </div>--}}
                                </a>
                            </div>
                            <div class="rbt-card-body">
                                <div class="rbt-card-top">
                                    <div class="rbt-review">
                                        <x-client.course-details.reviews.components.star
                                            :starNumber="4"
                                            class="rating"
                                        />
                                        <span class="rating-count"> ({{ $course->getFormattedReview() }})</span>
                                    </div>
                                    <div class="rbt-bookmark-btn">
                                        <a class="rbt-round-btn" title="mark" href="#"><i class="feather-heart"></i></a>
                                    </div>
                                </div>

                                <h4 class="rbt-card-title">
                                    <a href="{{ route('page.course_detail', $course->slug) }}">{{ $course->title }}</a>
                                </h4>

                                <ul class="rbt-meta">
                                    <li><i class="feather-book"></i>{{ $course->getFormattedLesson() }}</li>
                                    <li><i class="feather-users"></i>{{ $course->getFormattedEnrollment() }}</li>
                                </ul>

                                <p class="rbt-card-text">{{ $course->heading  }}</p>
                                <div class="rbt-author-meta mb--10">
                                    <div class="rbt-avater">
                                        <a href="#">
                                            <img src="{{ $course->author->getAvatarPath() }}" alt="{{ $course->author->name }}">
                                        </a>
                                    </div>
                                    <div class="rbt-author-info">
                                        By <a href="#">{{ $course->author->name }}</a>
                                    </div>
                                </div>
                                <div class="rbt-card-bottom">
                                    <div class="rbt-price">
                                        <span class="current-price">{{ $course->getFormattedPrice() }}</span>
                                        <span class="off-price">500 $</span>
                                    </div>
                                    <button onclick="Livewire.dispatch('add-to-cart', ['{{ $course->id }}'])" class="rbt-btn-link left-icon">
                                        <i class="feather-shopping-cart"></i> Add To Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
