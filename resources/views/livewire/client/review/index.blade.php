<div @class([
        'about-author-list rbt-shadow-box featured-wrapper mt--30',
        'has-show-more' => count($reviews) >= 4,
    ])>
    <div class="section-title">
        <h4 class="rbt-title-style-3">Featured review</h4>
    </div>
    <div @class([
                'rbt-featured-review-list-wrapper',
                'has-show-more-inner-content' => count($reviews) >= 4,
            ])>
        @forelse($reviews as $review)
            <div class="rbt-course-review about-author">
                <div class="media">
                    <div class="thumbnail">
                        <div class="rbt-avatars me-3">
                            <img src="{{ $review->user->getAvatarPath() }}"
                                 alt="Author Image">
                        </div>
                    </div>
                    <div class="media-body">
                        <div class="author-info">
                            <h5 class="title">
                                <a class="hover-flip-item-wrapper" href="#">
                                    {{ $review->user->name }}
                                </a>
                            </h5>

                            <x-client.course-details.reviews.components.star
                                :starNumber="$review->rating"
                                class="rating"
                            />
                        </div>
                        <div class="content">
                            <p class="description">{{ $review->content }}</p>
                            <livewire:client.shared.reaction-box :model="$review" title-text="Helpful?"/>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">No reviews yet. Be the first to review this course!</p>
        @endforelse

    </div>
    @if(count($reviews) >= 4)
        <div class="rbt-show-more-btn">Show all reviews</div>
    @endif

    @if($canReview)
        <livewire:client.review.create :$model/>
    @endif
</div>
