<div class="col-lg-4 col-md-6 col-12">
    <div class="rbt-card variation-01 rbt-hover">
        <div class="rbt-card-img">
            <a href="{{ route('page.course_detail', $course->slug) }}">
                <img src="{{ $course->thumbnail }}" alt="Card image">
            </a>
        </div>
        <div class="rbt-card-body">
            <h4 class="rbt-card-title">
                <a href="{{ route('page.course_detail', $course->slug) }}">{{ $course->title }}</a>
            </h4>
            <ul class="rbt-meta">
                <li><i class="feather-book"></i>{{ $course->lessonCountText }}</li>
                <li><i class="feather-clock"></i>{{ $course->durationText }}</li>
            </ul>
        </div>

        @if($status !== 'not_started')
            <div class="rbt-progress-style-1 mb--20 mt--10">
                <div class="single-progress">
                    <h6 class="rbt-title-style-2 mb--10">Complete</h6>
                    <div class="progress">
                        <div class="progress-bar wow fadeInLeft bar-color-primary"
                             data-wow-duration="0.5s" data-wow-delay=".3s" role="progressbar"
                             style="width: {{ $course->progressPercentage }}%" aria-valuenow="{{ $course->progressPercentage }}" aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                        <span class="rbt-title-style-2 progress-number">{{ $course->progressPercentage }}%</span>
                    </div>
                </div>
            </div>
        @endif

        @if($status === 'completed')
            <div class="rbt-card-bottom">
                <a class="rbt-btn btn-sm bg-primary-opacity w-100 text-center"
                   href="">View Certificate</a>
            </div>
        @elseif($status === 'in_progress')
            <div class="rbt-card-bottom">
                <a class="rbt-btn btn-sm bg-color-warning-opacity text-dark w-100 text-center"
                   href="{{ route('course.learn', $course->slug) }}">Continue learning</a>
            </div>
        @else
            <div class="rbt-card-bottom">
                <a class="rbt-btn btn-sm bg-color-coral-opacity text-dark w-100 text-center"
                   href="{{ route('course.learn', $course->slug) }}">Start course</a>
            </div>
        @endif
    </div>
</div>
