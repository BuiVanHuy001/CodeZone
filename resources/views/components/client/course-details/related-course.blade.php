@if($relatedCourses)
    <div class="related-course mt--60">
        <div class="row g-5 align-items-end mb--40">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="section-title">
                    <h4 class="title">More Courses by <strong class="color-primary">{{ $author->name }}</strong>
                    </h4>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="read-more-btn text-start text-md-end">
                    <a class="rbt-btn rbt-switch-btn btn-border btn-sm" href="#">
                        <span data-text="Xem tất cả Khóa học">View all courses</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row g-5">
            @foreach($relatedCourses as $course)
                <x-client.share-ui.course-card
                    :course="$course"
                    class="col-lg-6 col-md-6 col-sm-6"
                />
            @endforeach
        </div>
    </div>
@endif
