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
                    <span class="sub-title">Course reviews</span>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="review-wrapper">
                    <x-client.course-details.reviews.components.progress-bar
                        starNumber="5"
                        percent="63"
                    />

                    <x-client.course-details.reviews.components.progress-bar
                        starNumber="4"
                        percent="29"
                    />

                    <x-client.course-details.reviews.components.progress-bar
                        starNumber="3"
                        percent="6"
                    />

                    <x-client.course-details.reviews.components.progress-bar
                        starNumber="2"
                        percent="1"
                    />

                    <x-client.course-details.reviews.components.progress-bar
                        starNumber="1"
                        percent="1"
                    />
                </div>
            </div>
        </div>
    </div>
</div>
