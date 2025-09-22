<div class="rbt-course-feature-box overview-wrapper rbt-shadow-box mt--30 has-show-more" id="overview">
    <div class="rbt-course-feature-inner has-show-more-inner-content">
        <div class="section-title">
            <h4 class="rbt-title-style-3">{{ $title }}</h4>
        </div>
        <div class="row g-5 mb--30">
            @foreach($chunks as $chunk)
                <div class="col-lg-6">
                    <ul class="rbt-list-style-1">
                        @foreach($chunk as $item)
                            <li>
                                <i class="feather-check"></i>
                                {{ is_array($item) ? ($item['name'] ?? '') : $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    @if(count($features) > 4)
        <div class="rbt-show-more-btn">Show more</div>
    @endif
</div>
