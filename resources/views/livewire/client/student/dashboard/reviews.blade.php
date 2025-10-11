<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Reviews</h4>
        </div>

        <div class="advance-tab-button mb--30">
            <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="reviewTab-4" role="tablist">
                <li role="presentation">
                    <a href="#" class="tab-button active" id="course-tab" data-bs-toggle="tab"
                       data-bs-target="#course" role="tab" aria-controls="course" aria-selected="true">
                        <span class="title">Course</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="instructor-tab" data-bs-toggle="tab" data-bs-target="#instructor"
                       role="tab" aria-controls="instructor" aria-selected="false">
                        <span class="title">Instructor</span>
                    </a>
                </li>
            </ul>
        </div>


        <div class="tab-content">
            <div class="tab-pane fade active show" id="course" role="tabpanel" aria-labelledby="course-tab">
                <div class="rbt-dashboard-table table-responsive mobile-table-750">
                    <table class="rbt-table table table-borderless">
                        <thead>
                        <tr>
                            <th>Course title</th>
                            <th>Date</th>
                            <th>Feedback</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($courseReviews as $review)
                            <tr>
                                <td>
                                    <a href="{{ route('page.course_detail', $review->reviewable->slug) }}">{{ $review->reviewable->title }}</a>
                                </td>
                                <td>{{ $review->updated_at->diffForHumans() }}</td>
                                <td>
                                    <span class="b3">{{ $review->content }}</span>
                                    <div class="rbt-review">
                                        <x-client.course-details.reviews.components.star
                                            :star-number="$review->rating"
                                            class="rating"
                                        />
                                    </div>
                                </td>
                                <td>
                                    <div class="rbt-button-group">
                                        <a class="rbt-btn-link left-icon" href="#"><i class="feather-edit"></i>
                                            Edit</a>
                                        <a class="rbt-btn-link left-icon" href="#"><i
                                                class="feather-trash-2"></i> Delete</a>
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

            <div class="tab-pane fade" id="instructor" role="tabpanel" aria-labelledby="instructor-tab">
                <div class="rbt-dashboard-table table-responsive mobile-table-750">
                    <table class="rbt-table table table-borderless">
                        <thead>
                        <tr>
                            <th>Instructor</th>
                            <th>Feedback</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($instructorReviews as $review)
                            <tr>
                                <td>
                                    <a href="{{ route('instructor.details', $review->reviewable->slug) }}">{{ $review->reviewable->name }}</a>
                                </td>
                                <td>
                                    <span class="b3">{{ $review->content }}</span>
                                    <div class="rbt-review">
                                        <x-client.course-details.reviews.components.star
                                            :star-number="$review->rating"
                                            class="rating"
                                        />
                                    </div>
                                </td>
                                <td>
                                    <div class="rbt-button-group">
                                        <a class="rbt-btn-link left-icon" href="#"><i class="feather-edit"></i>
                                            Edit</a>
                                        <a class="rbt-btn-link left-icon" href="#"><i
                                                class="feather-trash-2"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No reviews found.</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
