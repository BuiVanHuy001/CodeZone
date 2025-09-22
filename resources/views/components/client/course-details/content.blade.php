<div class="course-content rbt-shadow-box coursecontent-wrapper mt--30" id="coursecontent">
    <div class="rbt-course-feature-inner">
        <div class="section-title">
            <h4 class="rbt-title-style-3">Course content</h4>
        </div>
        <div class="rbt-accordion-style rbt-accordion-02 accordion">
            <div class="accordion" id="accordionExampleb2">
                @foreach($course->modules->sortBy('position') as $module)
                    <div class="accordion-item card">
                        <h2 class="accordion-header card-header" id="module-{{ $loop->iteration }}">
                            <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseModule-{{ $loop->iteration }}"
                                    aria-expanded="false" aria-controls="collapseModule-{{ $loop->iteration }}">
                                {{ $module->title }}
                                <span class="rbt-badge-5 ml--10">{{ $module->convertDurationToString() }}</span>
                            </button>
                        </h2>
                        <div id="collapseModule-{{ $loop->iteration }}" class="accordion-collapse collapse"
                             aria-labelledby="module-{{ $loop->iteration }}" data-bs-parent="#accordionExampleb2">
                            <div class="accordion-body card-body pr--0">
                                <ul class="rbt-course-main-content liststyle">
                                    @foreach($module->lessons as $lesson)
                                        <li>
                                            <a href="javascript:void(0);">
                                                <div class="course-content-left">
                                                    <i class="feather-{{ $lesson->getIcon() }}"></i> <span
                                                        class="text">{{ $lesson->title }}</span>
                                                </div>
                                                <div class="course-content-right">
                                                    @if($lesson->preview)
                                                        <span class="course-eye">
                                                            <i class="feather-eye"></i>
                                                        </span>
                                                    @endif
                                                    @if($lesson->type === 'video')
                                                        <span>
                                                            {{ $lesson->convertDurationToTime() }}
                                                        </span>
                                                    @endif
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
