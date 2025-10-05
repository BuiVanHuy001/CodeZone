<?php

namespace App\View\Components\Client\CourseDetails;

use App\Models\User;
use App\Services\Instructor\InstructorService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Instructor extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(
        public User              $instructor,
        public InstructorService $instructorService
    )
    {
        $this->instructorService = app(InstructorService::class);
        $this->instructor = $this->instructorService->prepareDetails($this->instructor);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-details.instructor');
    }
}
