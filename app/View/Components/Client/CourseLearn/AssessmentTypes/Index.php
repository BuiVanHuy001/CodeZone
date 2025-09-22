<?php

namespace App\View\Components\Client\CourseLearn\AssessmentTypes;

use App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes\Assessment;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Index extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Assessment $assessment,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-learn.assessment-types.index');
    }
}
