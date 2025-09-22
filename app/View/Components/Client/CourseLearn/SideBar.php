<?php

namespace App\View\Components\Client\CourseLearn;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SideBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public array|Collection $modules,
        public string           $currentLesson,
        public string           $courseSlug,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-learn.side-bar');
    }
}
