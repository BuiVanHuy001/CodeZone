<?php

namespace App\View\Components\Client\CourseLearn\LessonTypes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Video extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $videoUrl,
    )
    {
        $this->videoUrl = Storage::url('course/videos/' . $this->videoUrl);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-learn.lesson-types.video');
    }
}
