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
            <div class="accordion">
                @foreach($modules->sortBy('position') as $key => $module)
                    @php
                        $isOpen = $module->lessons->pluck('id')->map(fn($id) => (string)$id)->contains((string)$currentLesson);
                    @endphp
                    <div class="accordion-item card">
                        <h2 class="accordion-header card-header" id="headingTwo{{ $key }}">
                            <button class="accordion-button"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    aria-expanded="{{ $isOpen ? 'true' : 'false' }}"
                                    data-bs-target="#collapseTwo{{ $key }}"
                                    aria-controls="collapseTwo{{ $key }}">{{ $module->title }}
                                <span class="rbt-badge-5 ml--10">{{ "$module->lesson_count | " . $module->convertDurationToString() }}</span>
                            </button>
                        </h2>
                        <div id="collapseTwo{{ $key }}"
                             @class([
                                'accordion-collapse collapse',
                                'show' => $isOpen
                            ])
                             aria-labelledby="headingTwo{{ $key }}">
                            <div class="accordion-body card-body">
                                <ul class="rbt-course-main-content liststyle">
                                    @foreach($module->lessons->sortBy('position') as $lesson)
                                        <li class="d-flex justify-content-between align-items-center">
                                            <div class="course-content-left">
                                                <a @class(['active' => $currentLesson === $lesson->id])
                                                   href="{{ route('course.learn.lesson', [$courseSlug, $lesson->id]) }}"
                                                >
                                                    <i class="feather-{{ $lesson->getIcon() }}"></i>
                                                    <span class="text">{{ $lesson->title }}</span>
                                                </a>
                                            </div>
                                            <div class="course-content-right">
                                                <span class="min-lable">
                                                    @if($lesson->getIcon() === 'video')
                                                        {{ $lesson->convertDurationToString() }}
                                                    @elseif($lesson->getIcon() === 'help-circle')
                                                        {{ $lesson->assessment->question_count . ' ' .\Illuminate\Support\Str::plural('question', $lesson->assessment->question_count) }}
                                                    @endif
                                                </span>
                                                <input
                                                    type="checkbox"
                                                    class="position-relative"
                                                    @checked($lesson->trackingProgresses->first()?->is_completed ?? false)
                                                    style="opacity: 1; width: 13px; height: 13px"
                                                >
                                            </div>
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
