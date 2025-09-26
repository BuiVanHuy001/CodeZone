<?php

namespace App\View\Components\Client\CourseDetails;

use App\Models\Course;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RelatedCourse extends Component
{
    public User $author;
    public Collection $relatedCourses;

    public function __construct(string $authorId, string $currentCourseId)
    {
        $this->author = User::find($authorId);

        $this->relatedCourses = Course::where('id', '!=', $currentCourseId)
            ->orderByDesc('rating')
            ->limit(2)
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.client.course-details.related-course', [
            'relatedCourses' => $this->relatedCourses,
        ]);
    }
}
