<?php

namespace App\View\Components\Client\CourseDetails\Reviews;

use App\Models\Course;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Summary extends Component
{
    public array $percentages = [];

    public function __construct(
        public Course     $course,
        public Collection $reviews,
    )
    {
        $totalReviews = $this->reviews->count();

        for ($i = 1; $i <= 5; $i++) {
            $count = $this->reviews->where('rating', $i)->count();
            $this->percentages[$i] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }
    }

    public function render(): View|Closure|string
    {
        return view('components.client.course-details.reviews.summary');
    }
}
