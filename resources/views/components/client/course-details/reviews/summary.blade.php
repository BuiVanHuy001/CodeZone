<div class="rbt-review-wrapper rbt-shadow-box review-wrapper mt--30" id="review">
    <div class="course-content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Reviews</h4>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-3">
                <div class="rating-box">
                    <div class="rating-number">{{ $course->rating }}</div>
                    <x-client.course-details.reviews.components.star
                        :starNumber="$course->rating"
                        class="rating"
                    />
                    <span class="sub-title">Rating</span>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="review-wrapper">
                    @for($star = 5; $star >= 1; $star--)
                        <x-client.course-details.reviews.components.progress-bar
                            :starNumber="$star"
                            :percent="round($percentages[$star], 1)"
                        />
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
