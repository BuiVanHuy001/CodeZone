<?php

namespace App\View\Components\Client\CourseLearn\LessonTypes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Document extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $documentContent,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-learn.lesson-types.document');
    }
}
