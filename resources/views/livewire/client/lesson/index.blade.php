<div class="rbt-lesson-area bg-color-white">
    <div class="rbt-lesson-content-wrapper">
        <livewire:client.lesson.components.sidebar :modules="$course->modules" :courseSlug="$course->slug"/>

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
                @if(!empty($lesson->video_url))
                    <div x-data="{ videoSrc: @entangle('currentVideo') }" class="video-wrapper">
                        <template x-if="videoSrc"
                                  x-init="document.getElementById('lessonVideo').addEventListener('ended', () => {$wire.markLessonAsCompleted({{ $lesson->id }});})">
                            <video
                                id="lessonVideo"
                                x-bind:key="videoSrc"
                                x-bind:src="videoSrc"
                                class="w-100 rounded-xl shadow-lg"
                                controls
                                autoplay
                            >
                                Your browser does not support the video tag.
                            </video>
                        </template>
                    </div>

                @elseif(!empty($lesson->content))
                    <div class="embed-responsive embed-responsive-16by9" style="margin: 60px">
                        @markdown($lesson->content)
                    </div>
                @elseif($lesson->type === 'assessment')
                    <livewire:client.lesson.components.assessment :assessment="$lesson->assessment"/>
                @endif
            </div>

            <div class="bg-color-extra2 ptb--15 overflow-hidden">
                <div class="rbt-button-group">
                    <button @class(['rbt-btn icon-hover icon-hover-left btn-md bg-primary-opacity', 'disabled cursor-not-allowed' => $isDisabledPrevious]) wire:click="previousLesson">
                        <span class="btn-icon"><i class="feather-arrow-left"></i></span>
                        <span class="btn-text">Previous</span>
                    </button>

                    <button class="rbt-btn icon-hover btn-md" wire:click="nextLesson">
                        <span class="btn-text">Next</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
