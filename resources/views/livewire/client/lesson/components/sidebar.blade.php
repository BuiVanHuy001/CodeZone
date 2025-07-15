<div class="rbt-lesson-leftsidebar">
    <div class="rbt-course-feature-inner rbt-search-activation">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Course Content</h4>
        </div>

        <div class="lesson-search-wrapper">
            <form action="#" class="rbt-search-style-1">
                <input class="rbt-search-active" type="text" placeholder="Search Lesson">
                <button class="search-btn disabled"><i class="feather-search"></i></button>
            </form>
        </div>

        <hr class="mt--10">

        <div class="rbt-accordion-style rbt-accordion-02 for-right-content accordion">
            <div class="accordion" id="accordionExampleb2">
                @foreach($modules->sortBy('position') as $key => $module)
                    <div class="accordion-item card">
                        <h2 class="accordion-header card-header" id="headingTwo{{ $key }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" aria-expanded="true" data-bs-target="#collapseTwo{{ $key }}" aria-controls="collapseTwo{{ $key }}">{{ $module->title }}
                                <span class="rbt-badge-5 ml--10">{{ "$module->lesson_count | " . $module->convertDurationToString() }}</span>
                            </button>
                        </h2>
                        <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="headingTwo{{ $key }}">
                            <div class="accordion-body card-body">
                                <ul class="rbt-course-main-content liststyle">
                                    @foreach($module->lessons->sortBy('position') as $lesson)
                                        <li>
                                            <a href="{{ route('course.learn', [$courseSlug, $module->id, $lesson->id]) }}" wire:navigate wire:current="active">
                                                <div class="course-content-left">
                                                    <i class="feather-{{ $lesson->getIcon() }}"></i>
                                                    <span class="text">{{ $lesson->title }}</span>
                                                </div>
                                                <div class="course-content-right">
                                                    <span class="min-lable">{{ $lesson->convertDurationToString() }}</span>
                                                    <span class="rbt-check"><i class="feather-check"></i></span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
