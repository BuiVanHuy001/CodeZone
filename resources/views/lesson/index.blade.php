<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, follow"/>
    <meta name="description"
          content="CodeZone is a platform for developers to learn, share, and grow their coding skills.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('swal::index')
    @stack('styles')
    <title>{{ $title ?? 'CodeZone' }}</title>
</head>

<body class="rbt-header-sticky">
<div class="rbt-lesson-area bg-color-white">
    <div class="rbt-lesson-content-wrapper">
        <x-client.course-learn.side-bar :modules="$course->modules" :currentLesson="$lesson->id" :courseSlug="$course->slug"/>

        <div class="rbt-lesson-rightsidebar overflow-hidden lesson-video">
            <div class="lesson-top-bar">
                <div class="lesson-top-left">
                    <div class="rbt-lesson-toggle">
                        <button class="lesson-toggle-active btn-round-white-opacity" title="Toggle Sidebar">
                            <i class="feather-arrow-left"></i>
                        </button>
                    </div>
                    <h5>{{ $lesson->title }}</h5>
                </div>
                <div class="lesson-top-right">
                    <div class="rbt-btn-close">
                        <a href="{{ route('page.course_detail', $course->slug) }}" title="Go Back to Course"
                           class="rbt-round-btn"><i class="feather-x"></i></a>
                    </div>
                </div>
            </div>

            <div class="inner">
                @if ($lesson->type === 'video')
                    <x-client.course-learn.lesson-types.video :video-url="$lesson->video_file_name"/>
                @elseif($lesson->type === 'document')
                    <x-client.course-learn.lesson-types.document :document-content="$lesson->document"/>
                @elseif($lesson->type === 'assessment')
                    <x-client.course-learn.assessment-types :assessment="$lesson->assessment"/>
                @endif
                    <div class="d-flex align-items-end justify-content-center gap-3 mt-4 mb-3">
                        <livewire:client.shared.reaction-box :model="$lesson"/>
                    <livewire:client.lesson.components.comment.comment-area :$lesson/>
                    </div>

            </div>
            <livewire:client.lesson.components.lesson-navigator :current-lesson="$lesson"/>

        </div>
        <div class="rbt-progress-parent">
            <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
            </svg>
        </div>
    </div>
</div>
@stack('scripts')
<script src="{{ asset('js/vendor/isotop.js') }}"></script>
<script src="{{ asset('js/vendor/imageloaded.js') }}"></script>
<script src="{{ asset('js/vendor/wow.js') }}"></script>
</body>

</html>
