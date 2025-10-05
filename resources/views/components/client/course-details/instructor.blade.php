<div class="rbt-instructor rbt-shadow-box intructor-wrapper mt--30" id="instructor">
    <div class="about-author border-0 pb--0 pt--0">
        <div class="section-title mb--30">
            <h4 class="rbt-title-style-3">Instructor</h4>
        </div>
        <div class="media align-items-center">
            <div class="thumbnail">
                <a href="{{ $instructor->profileUrl }}">
                    <img src="{{ $instructor->avatar }}"
                         alt="Instructor Avatar">
                </a>
            </div>
            <div class="media-body">
                <div class="author-info">
                    <h5 class="title">
                        <a class="hover-flip-item-wrapper" href="{{ $instructor->profileUrl }}">{{ $instructor->name }}</a>
                    </h5>
                    <span class="b3 subtitle">{{ $instructor->currentJob }}</span>
                    <ul class="rbt-meta mb--20 mt--10">
                        <li><i class="fa fa-star color-warning"></i>{{ $instructor->rating }} rating<span
                                class="rbt-badge-5 ml--5">{{ $instructor->reviewCountText }}</span></li>
                        <li><i class="feather-users"></i>{{ $instructor->studentCountText }}</li>
                        <li><i class="feather-video"></i>{{ $instructor->courseCountText }}</li>
                    </ul>
                </div>
                <div class="content has-show-more">
                    @if($instructor->aboutMe)
                        <div class="has-show-more-inner-content" style="max-height: 200px">
                            {!! $instructor->aboutMe !!}
                        </div>
                        <div class="rbt-show-more-btn">Show more</div>
                    @endif

                    @if($instructor->socialLinks)
                        <x-client.share-ui.social-link-list
                            :socials="$instructor->socialLinks"
                        />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
