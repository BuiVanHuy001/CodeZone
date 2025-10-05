<?php

namespace App\View\Components\Client\CourseDetails;

use App\Models\User;
use App\Services\Course\CatalogService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RelatedCourse extends Component
{
    public Collection $relatedCourses;
    public User $author;

    public function __construct(User $author, string $currentCourseId)
    {
        $cateLogService = app(CatalogService::class);
        $this->author = $author;
        $this->relatedCourses = $cateLogService->getRelatedCourses($author, $currentCourseId);
    }

    public function render(): View|Closure|string
    {
        return view('components.client.course-details.related-course');
    }
}
