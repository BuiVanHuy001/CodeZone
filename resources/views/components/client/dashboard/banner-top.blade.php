<div class="rbt-dashboard-content-wrapper">
    <div class="tutor-bg-photo bg_image height-350 {{ $backgroundClass }}"></div>
    <div class="rbt-tutor-information">
        <div class="rbt-tutor-information-left">
            <div wire:ignore class="thumbnail rbt-avatars size-lg">
                <img src="{{ auth()->user()->getAvatarPath() }}" alt="Instructor">
            </div>
            <div class="tutor-content">
                <h5 class="title">{{ auth()->user()->name }}</h5>
                <div class="rbt-review">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="rating-count"> (15 Reviews)</span>
                </div>
            </div>
        </div>
        @if($courseCreateRoute && !auth()->user()->isStudent())
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
