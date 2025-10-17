<div class="{{ $attributes->get('class', 'col-lg-4 col-md-6 col-sm-12 col-12') }}">
    <div class="rbt-card variation-01 rbt-hover">
        <div class="rbt-card-img">
            <a href="{{ $course->detailsPageUrl }}">
                <img src="{{ $course->thumbnail }}" alt="Card image">
            </a>
        </div>
        <div class="rbt-card-body">
            <div class="rbt-card-top">
                <div class="rbt-review">
                    <x-client.course-details.reviews.components.star
                        :starNumber="$course->rating"
                        class="rating"
                    />
                    <span class="rating-count"> ({{ $course->reviewCountText }})</span>
                </div>
                <div class="rbt-bookmark-btn">
                    <a class="rbt-round-btn" title="mark" href="#"><i class="feather-heart"></i></a>
                </div>
            </div>

            <h4 class="rbt-card-title">
                <a href="{{ $course->detailsPageUrl }}">{{ $course->title }}</a>
            </h4>

            <ul class="rbt-meta">
                <li><i class="feather-book"></i>{{ $course->lessonCountText }}</li>
                <li><i class="feather-users"></i>{{ $course->enrollmentCountText }}</li>
            </ul>

            <p class="rbt-card-text">{{ $course->heading }}</p>
            <div class="rbt-author-meta mb--10">
                <div class="rbt-avater">
                    <a href="{{ $course->authorInfo['profileUrl'] }}">
                        <img src="{{ $course->authorInfo['avatar'] }}" alt="{{ $course->author['name'] }}">
                    </a>
                </div>
                <div class="rbt-author-info">
                    By <a href="{{ $course->authorInfo['profileUrl'] }}">{{ $course->author['name'] }}</a>
                </div>
            </div>
            <div class="rbt-card-bottom">
                <div class="rbt-price">
                    <span class="current-price">{{ $course->priceFormatted }}</span>
                </div>
                @if($isEnrolled)
                    <a class="rbt-btn btn-border icon-hover w-100 d-block text-center"
                       href="{{ route('course.learn', $course->slug) }}">
                        <span class="btn-text">Go to course</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>
                @else
                    <button onclick="Livewire.dispatch('add-to-cart', ['{{ $course->id }}'])"
                            class="rbt-btn btn-border icon-hover w-100 d-block text-center">
                        <i class="feather-shopping-cart"></i> Add To Cart
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
