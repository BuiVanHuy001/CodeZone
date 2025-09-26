<?php

namespace App\View\Components\Client\CourseDetails\Reviews;

use App\Models\Course;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Summary extends Component
{
    public function __construct(
        public Course $course,
    )
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.client.course-details.reviews.summary');
    }
}
