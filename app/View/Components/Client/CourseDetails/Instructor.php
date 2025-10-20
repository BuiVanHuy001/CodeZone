<?php

namespace App\View\Components\Client\CourseDetails;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Instructor extends Component
{
    public function __construct(
	    public User $instructor,
    )
    {
    }

    public function render(): View|Closure|string
    {
        return view('components.client.course-details.instructor');
    }
}
