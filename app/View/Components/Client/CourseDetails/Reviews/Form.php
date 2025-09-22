<?php

namespace App\View\Components\Client\CourseDetails\Reviews;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Form extends Component
{

    public function __construct(
        public int  $max = 5,
        public ?int $selected = null
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-details.reviews.form');
    }
}
