    <div class="rbt-course-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--55 g-5 align-items-end">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">Top Trending Courses</span>
                        <h2 class="title">Most <span class="color-primary">Popular Courses</span></h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="load-more-btn text-start text-md-end">
                        <a class="rbt-btn rbt-switch-btn bg-primary-opacity" href="">
                            <span data-text="View all Khóa học">View all courses</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                @foreach($courses as $course)
                    <x-client.share-ui.course-card
                        :$course
                    />
                @endforeach
            </div>
        </div>
    </div>
