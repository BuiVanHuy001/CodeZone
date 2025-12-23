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
                </div>
            </div>
            @if($courseCreateRoute)
                <div class="rbt-tutor-information-right">
                    <div class="tutor-btn">
                        <a class="rbt-btn btn-md hover-icon-reverse" wire:navigate href="{{ $courseCreateRoute }}">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Tạo khóa học mới</span>
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
