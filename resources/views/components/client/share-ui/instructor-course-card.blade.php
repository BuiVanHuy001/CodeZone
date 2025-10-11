<div class="col-lg-4 col-md-6 col-12" wire:ignore>
    <div class="rbt-card variation-01 rbt-hover">
        <div class="rbt-card-img">
            <a href="">
                <img src="{{ $course->thumbnail }}" alt="Card image">
            </a>
        </div>
        <div class="rbt-card-body">
            @if($course->status === 'published')
                <div class="rbt-card-top">
                    <div class="rbt-review">
                        <x-client.course-details.reviews.components.star
                            :starNumber="$course->rating"
                            class="rating"
                        />
                        <span class="rating-count"> ({{ $course->reviewCountText }})</span>
                    </div>
                    <div class="rbt-bookmark-btn">
                        <a class="rbt-round-btn" title="Bookmark" href="#"><i class="feather-bookmark"></i></a>
                    </div>
                </div>
            @endif
            <h4 class="rbt-card-title">
                <a href="{{ route('page.course_detail', $course->slug) }}">{{ $course->title }}</a>
            </h4>
            @if($course->status === 'published')
                <ul class="rbt-meta">
                    <li><i class="feather-book"></i>{{ $course->studentCountText }}</li>
                    <li><i class="feather-clock"></i>{{ $course->durationText }}</li>
                </ul>

                <div class="rbt-card-bottom">
                    <div class="rbt-price">
                        <span class="current-price">{{ $course->priceFormatted }}</span>
                    </div>
                    <a class="rbt-btn-link left-icon cursor-pointer" wire:click.prevent="editCourse"><i class="feather-edit"></i>
                        Edit</a>
                </div>
            @elseif($course->status === 'pending')
                <div class="alert alert-warning text-center mb-0">
                    <strong>Pending Approval</strong>
                </div>
            @elseif($course->status === 'draft')
                <div class="alert alert-secondary text-center mb-0">
                    <strong>Draft</strong>
                </div>
            @elseif($course->status === 'rejected')
                <div class="alert alert-danger text-center mb-0">
                    <strong>Rejected</strong>
                </div>
            @endif
        </div>
    </div>
</div>
