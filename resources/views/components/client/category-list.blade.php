<div class="swiper category-activation-three rbt-arrow-between icon-bg-gray gutter-swiper-30 ptb--20">
    <div class="swiper-wrapper">
        @foreach($categories->where('parent_id', null) as $category)
            <div class="swiper-slide">
                <div class="single-slide">
                    <div class="rbt-cat-box rbt-cat-box-1 variation-2 text-center">
                        <div class="inner">
                            <div class="thumbnail">
                                <a href="">
                                    <img src="{{ asset('assets/images/category/image') . "/$category->thumbnail_url" }}" alt="Category Images">
                                </a>
                            </div>
                            <div class="icons">
                                <img src="{{ asset('assets/images/category/') . "/$category->icon_url" }}" alt="Icons Images">
                            </div>
                            <div class="content">
                                <h5 class="title"><a href="">{{ $category->name  }}</a></h5>
                                <div class="read-more-btn">
                                    <a class="rbt-btn-link" href="">35 Courses<i
                                            class="feather-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>

    <div class="rbt-swiper-arrow rbt-arrow-left">
        <div class="custom-overfolow">
            <i class="rbt-icon feather-arrow-left"></i>
            <i class="rbt-icon-top feather-arrow-left"></i>
        </div>
    </div>

    <div class="rbt-swiper-arrow rbt-arrow-right">
        <div class="custom-overfolow">
            <i class="rbt-icon feather-arrow-right"></i>
            <i class="rbt-icon-top feather-arrow-right"></i>
        </div>
    </div>
</div>
