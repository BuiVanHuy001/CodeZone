<x-client.course-details.reviews.summary/>
<div class="about-author-list rbt-shadow-box featured-wrapper mt--30 has-show-more">
    <div class="section-title">
        <h4 class="rbt-title-style-3">Featured review</h4>
    </div>
    <div class="has-show-more-inner-content rbt-featured-review-list-wrapper">
        @forelse($reviews as $review)
            <div class="rbt-course-review about-author">
                <div class="media">
                    <div class="thumbnail">
                        <a href="#">
                            <img src="{{ $review->user->getAvatarPath() }}"
                                 alt="Author Image" style="width: 60px; height: 60px; border-radius: 50%;">
                        </a>
                    </div>
                    <div class="media-body">
                        <div class="author-info">
                            <h5 class="title">
                                <a class="hover-flip-item-wrapper" href="#">
                                    {{ $review->user->name }}
                                </a>
                            </h5>
                            <div class="rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="content">
                            <p class="description">{{ $review->content }}</p>
                            <ul
                                class="social-icon social-default transparent-with-border justify-content-start">
                                <li><a href="#">
                                        <i class="feather-thumbs-up"></i>
                                    </a>
                                </li>
                                <li><a href="#">
                                        <i class="feather-thumbs-down"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rbt-show-more-btn">Show all reviews</div>
        @empty
            <p class="text-muted">No reviews yet. Be the first to review this course!</p>
        @endforelse
    </div>

    @if($isReviewAllowed)
        <div class="comment-respond">
            <h4 class="title mt-3">Share Your Experience</h4>
            <p class="comment-notes">Your feedback helps others make informed decisions</p>
            <x-client.course-details.reviews.form
                :max="5"
                :selected="old('rating', 0)"
            />
        </div>
    @endif
</div>
