<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Reviews</h4>
        </div>

        <div class="advance-tab-button mb--30">
            <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="reviewTab-4" role="tablist">
                <li role="presentation">
                    <a href="#" class="tab-button active" id="review-of-me-tab" data-bs-toggle="tab"
                       data-bs-target="#review-of-me" role="tab" aria-controls="review-of-me" aria-selected="true">
                        <span class="title">For me</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="review-of-my-courses-tab" data-bs-toggle="tab" data-bs-target="#review-of-my-courses"
                       role="tab" aria-controls="review-of-my-courses" aria-selected="false">
                        <span class="title">For my Courses</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="review-of-me" role="tabpanel" aria-labelledby="review-of-me-tab">
                <div class="rbt-dashboard-table table-responsive mobile-table-750">
                    <table class="rbt-table table table-borderless">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Feedback</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reviewInstructor as $review)
                            <tr>
                                <th>{{ $review->user->name }}</th>
                                <td>{{ $review->created_at->diffForHumans() }}</td>
                                <td>
                                    <span class="b3">{{ $review->content }}</span>
                                    <div class="rbt-review">
                                        <x-client.course-details.reviews.components.star
                                            :star-number="$review->rating"
                                            class="rating"
                                        />
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No reviews found.</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="review-of-my-courses" role="tabpanel" aria-labelledby="review-of-my-courses-tab">
                <div class="rbt-dashboard-table table-responsive mobile-table-750">
                    <table class="rbt-table table table-borderless">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Course title</th>
                            <th>Feedback</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reviewCourses as $review)
                            <tr>
                                <td>
                                    {{ $review->user->name }}
                                </td>
                                <td>
                                    <a href="{{ route('page.course_detail', $review->reviewable->slug) }}">
                                        {{ $review->reviewable->title }}
                                    </a>
                                </td>
                                <td>
                                    <div class="rbt-review">
                                        <x-client.course-details.reviews.components.star
                                            :star-number="$review->rating"
                                            class="rating"
                                        />
                                    </div>
                                    <p class="b3">{{ $review->content }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No reviews found.</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
