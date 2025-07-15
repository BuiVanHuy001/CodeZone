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
                    <h5>{{ $course->title }}</h5>
                </div>
                <div class="lesson-top-right">
                    <div class="rbt-btn-close">
                        <a href="" title="Go Back to Course" class="rbt-round-btn"><i class="feather-x"></i></a>
                    </div>
                </div>
            </div>
            <div class="inner">
                @if(!empty($lesson->video_url))
                    <video
                        controls
                        controlsList="nodownload"
                        class="w-100 rounded-xl shadow-lg"
                        autoplay
                    >
                        <source src="{{ $currentVideo }}" type="video/mp4">
                    </video>
                @elseif(!empty($lesson->content))
                    <div class="embed-responsive embed-responsive-16by9" style="margin: 60px">
                        @markdown($lesson->content)
                    </div>
                @elseif($lesson->type === 'assessment')
                    <livewire:client.lesson.components.assessment :assessment="$lesson->assessment"/>
                @endif

                {{--                <div class="content">--}}
                {{--                    <div class="section-title">--}}
                {{--                        <h4>About Lesson</h4>--}}
                {{--                        <p>Let us analyze the greatest hits of the past and learn what makes these tracks so special. </p>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>

            <div class="bg-color-extra2 ptb--15 overflow-hidden">
                <div class="rbt-button-group">
                    <a class="rbt-btn icon-hover icon-hover-left btn-md bg-primary-opacity" href="#">
                        <span class="btn-icon"><i class="feather-arrow-left"></i></span>
                        <span class="btn-text">Previous</span>
                    </a>

                    <a class="rbt-btn icon-hover btn-md" href="#">
                        <span class="btn-text">Next</span>
                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
