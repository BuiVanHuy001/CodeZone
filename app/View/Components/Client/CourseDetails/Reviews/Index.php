<?php

namespace App\View\Components\Client\CourseDetails\Reviews;

use App\Models\BatchEnrollments;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Index extends Component
{
    public bool $isReviewAllowed = false;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public array|Collection $reviews,
    )
    {
        $this->isReviewAllowed = $this->determineReviewPermission();
    }

    private function determineReviewPermission(): bool
    {
        if (!auth()->check()) {
            return false;
        }
        if (auth()->user()->isOrganization() || auth()->user()->isInstructor()) {
            return false;
        }
        return true;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.course-details.reviews.index');
    }
}
