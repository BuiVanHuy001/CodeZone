<div class="rbt-instructor rbt-shadow-box intructor-wrapper mt--30" id="instructor">
    <div class="about-author border-0 pb--0 pt--0">
        <div class="section-title mb--30">
            <h4 class="rbt-title-style-3">Instructor</h4>
        </div>
        <div class="media align-items-center">
            <div class="thumbnail">
                <a href="">
                    <img src="{{ $avatar }}"
                         alt="Instructor Avatar">
                </a>
            </div>
            <div class="media-body">
                <div class="author-info">
                    <h5 class="title">
                        <a class="hover-flip-item-wrapper" href="./profile">{{ $name }}</a>
                    </h5>
                    <span class="b3 subtitle">{{ $jobTitle }}</span>
                    <ul class="rbt-meta mb--20 mt--10">
                        <li><i class="fa fa-star color-warning"></i>{{ $reviewCount }}<span
                                class="rbt-badge-5 ml--5">{{ $rating }} Rating</span></li>
                        <li><i class="feather-users"></i>{{ $studentCount }}</li>
                        <li><i class="feather-video"></i>{{ $courseCount }}</li>
                    </ul>
                </div>
                <div class="content has-show-more">
                    @if($aboutMe)
                        <div class="has-show-more-inner-content" style="max-height: 200px">
                            {!! $aboutMe !!}
                        </div>
                        <div class="rbt-show-more-btn">Show more</div>
                    @endif

                    @if($socials)
                        <x-client.share-ui.social-link-list
                            :socials="$socials"
                        />
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
