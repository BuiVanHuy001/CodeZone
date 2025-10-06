<?php

namespace App\View\Components\Client\ShareUi;

use App\Models\Course;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InstructorCourseCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Course $course,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.share-ui.instructor-course-card');
    }
}
