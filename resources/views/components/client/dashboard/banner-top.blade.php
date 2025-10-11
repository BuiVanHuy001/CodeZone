<div class="rbt-dashboard-banner">
    <div class="rbt-dashboard-content-wrapper">
        <div class="tutor-bg-photo bg_image height-350 {{ $backgroundClass }}"></div>
        <div class="rbt-tutor-information">
            <div class="rbt-tutor-information-left">
                <div class="thumbnail rbt-avatars size-lg">
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                </div>
                <div class="tutor-content">
                    <h5 class="title">{{ $user->name }}</h5>
                    @if($role === 'instructor')
                        <div class="rbt-review">
                            <x-client.course-details.reviews.components.star
                                :star-number="$user->instructorProfile->rating"
                                class="rating"
                            />
                            <span class="rating-count"> ({{ $user->reviewCountText }})</span>
                        </div>
                    @else
                        <ul class="rbt-meta rbt-meta-white mt--5">
                            <li><i class="feather-book"></i>{{ $user->enrolledCountText }}</li>
                            <li><i class="feather-award"></i>{{ $user->completedCountText }}</li>
                        </ul>
                    @endif
                </div>
            </div>
            @if($courseCreateRoute && ($user->isOrganization() || $user->isInstructor()))
                <div class="rbt-tutor-information-right">
                    <div class="tutor-btn">
                        <a class="rbt-btn btn-md hover-icon-reverse" wire:navigate href="{{ $courseCreateRoute }}">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Create a New Course</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
