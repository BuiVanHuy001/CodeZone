<div class="rbt-lesson-area bg-color-white">
    <div class="rbt-lesson-content-wrapper">
        <livewire:client.lesson.components.sidebar :modules="$course->modules" :courseSlug="$course->slug" :currentLesson="$lesson->id"/>

        <div class="rbt-lesson-rightsidebar overflow-hidden lesson-video">
            <div class="lesson-top-bar">
                <div class="lesson-top-left">
                    <div class="rbt-lesson-toggle">
                        <button class="lesson-toggle-active btn-round-white-opacity" title="Toggle Sidebar"><i
                                class="feather-arrow-left"></i></button>
                    </div>
                    <h5>{{ $lesson->title }}</h5>
                </div>
                <div class="lesson-top-right">
                    <div class="rbt-btn-close">
                        <a href="{{ route('page.course_detail', $course->slug) }}" title="Go Back to Course" class="rbt-round-btn"><i class="feather-x"></i></a>
                    </div>
                </div>
            </div>

            <div class="inner">
                @if($lesson->type === 'video')
                    <livewire:client.lesson.components.lesson-types.video :videoUrl="$lesson->video_file_name" :key="'video-' . $lesson->id"/>
                @elseif($lesson->type === 'document')
                    <livewire:client.lesson.components.lesson-types.document :documentContent="$lesson->document" :key="'document-' . $lesson->id"/>
                @elseif($lesson->type === 'assessment')
                    @if($lesson->assessment->type === 'quiz')
                        <livewire:client.lesson.components.assessment-types.quiz :quiz="$lesson->assessment"/>
                    @elseif($lesson->assessment->type === 'assignment')
                        <livewire:client.lesson.components.assessment-types.assignment :assignment="$lesson->assessment"/>
                    @elseif($lesson->assessment->type === 'programming')
                        <livewire:client.lesson.components.assessment-types.programming-practice :programming-practice="$lesson->assessment"/>
                    @endif
                @endif
            </div>

            <div class="bg-color-extra2 ptb--15 overflow-hidden">
                <div class="rbt-button-group">
                    <button @class(['rbt-btn icon-hover icon-hover-left btn-md bg-primary-opacity', 'disabled cursor-not-allowed' => $isDisabledPrevious])
                            wire:click="previousLesson">
                        <span class="btn-icon"><i class="feather-arrow-left"></i></span>
                        <span class="btn-text">Previous</span>
                    </button>

                    <button @class(['rbt-btn icon-hover btn-md', 'disabled cursor-not-allowed' => $isDisabledNext]) wire:click="nextLesson">
                        <span class="btn-text">Next</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('lessonChanged', function (event) {
            const url = event.detail;
            window.history.pushState({}, '', url);
        });
    </script>
@endpush
