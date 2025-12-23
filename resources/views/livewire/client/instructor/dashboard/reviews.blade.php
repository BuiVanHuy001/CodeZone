<div class="rbt-dashboard-content bg-color-white rbt-shadow-box">
    <div class="content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Đánh giá & Phản hồi</h4>
        </div>

        <div class="advance-tab-button mb--30">
            <ul class="nav nav-tabs tab-button-style-2 justify-content-start" id="reviewTab-4" role="tablist">
                <li role="presentation">
                    <a href="#" class="tab-button active" id="review-of-me-tab" data-bs-toggle="tab"
                       data-bs-target="#review-of-me" role="tab" aria-controls="review-of-me" aria-selected="true">
                        <span class="title">Dành cho giảng viên</span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-button" id="review-of-my-courses-tab" data-bs-toggle="tab" data-bs-target="#review-of-my-courses"
                       role="tab" aria-controls="review-of-my-courses" aria-selected="false">
                        <span class="title">Dành cho khóa học</span>
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
                            <th>Sinh viên</th>
                            <th>Thời gian</th>
                            <th>Nội dung phản hồi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reviewInstructor as $review)
                            <tr>
                                <th>{{ $review->user->name }}</th>
                                <td>{{ $review->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="rbt-review mb--5">
                                        <x-client.course-details.reviews.components.star
                                            :star-number="$review->rating"
                                            class="rating"
                                        />
                                    </div>
                                    <span class="b3 text-dark">{{ $review->content }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">Chưa có đánh giá nào dành cho bạn.</td>
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
                            <th>Sinh viên</th>
                            <th>Tên khóa học</th>
                            <th>Nội dung phản hồi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($reviewCourses as $review)
                            <tr>
                                <td>
                                    <span class="font-system-bold">{{ $review->user->name }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('page.course_detail', $review->reviewable->slug) }}" class="rbt-link">
                                        {{ $review->reviewable->title }}
                                    </a>
                                </td>
                                <td>
                                    <div class="rbt-review mb--5">
                                        <x-client.course-details.reviews.components.star
                                            :star-number="$review->rating"
                                            class="rating"
                                        />
                                    </div>
                                    <p class="b3 text-dark">{{ $review->content }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">Chưa có đánh giá nào cho các khóa học của bạn.</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
