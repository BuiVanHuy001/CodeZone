<?php

namespace App\Services\Course\Catalog;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use App\Services\Course\LearningService;
use App\Services\Instructor\InstructorService;
use App\Traits\HasNumberFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CatalogService
{
    use HasNumberFormat;

    private CourseFilter $courseFilter;
    private CourseDecorator $courseDecorator;

    public function __construct()
    {
        $this->courseFilter = app(CourseFilter::class);
        $this->courseDecorator = app(CourseDecorator::class);
    }

    public function prepareCatalogData(int $amount, Request $request): Collection
    {
        $instructorService = app(InstructorService::class);

        $coursesPaginated = $this->courseFilter->filterCourse($amount, $request);

        $coursesPaginated->getCollection()->transform(fn(Course $course) => $this->courseDecorator->decorateForCard($course));

        $categories = Category::fetchCategoriesWithChildren();

        return collect([
            'courses' => $coursesPaginated, // Keep as LengthAwarePaginator
            'categories' => $categories,
            'topInstructors' => $instructorService->getTopInstructors(),
        ]);
    }

    public function prepareDetails(Course $course): Course
    {
        return $this->courseDecorator->decorateForDetails($course);
    }

    public function getPopularCourses(int $amount = 10): Collection
    {
        $order = [
            ['enrollment_count', 'desc'],
            ['review_count', 'desc'],
            ['rating', 'desc'],
        ];

        return $this->fetchCourses($amount, $order);
    }

    public function getHotCourses(int $amount = 5): Collection
    {
        $order = [
            ['rating', 'desc'],
            ['review_count', 'desc'],
            ['enrollment_count', 'desc'],
        ];

        return $this->fetchCourses($amount, $order);
    }

    public function getRelatedCourses(User $author, string $currentCourseId, int $amount = 2): Collection
    {
        $order = [
            ['rating', 'desc'],
            ['review_count', 'desc'],
        ];

        $query = $author->courses()
            ->where('status', 'published')
            ->where('id', '!=', $currentCourseId);

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        return $query->take($amount)->get()->map(fn(Course $course) => $this->courseDecorator->decorateForCard($course));
    }

    public function getCoursesByAuthor(User $author, ?array $status = null): Collection
    {
        $order = [
            ['enrollment_count', 'desc'],
            ['review_count', 'desc'],
            ['rating', 'desc'],
        ];

        $statuses = $status ?? ['published'];

        $query = Course::query()
            ->whereIn('status', $statuses)
            ->with(['reviews', 'category'])
            ->where('user_id', $author->id);

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        return $query->get()->map(fn(Course $course) => $this->courseDecorator->decorateForCard($course));
    }

    public function getCoursesByStudent(User $student): Collection
    {
        $enrollments = $student->enrollments()
            ->with(['course' => fn($q) => $q->where('status', 'published')
                ->with(['author', 'reviews', 'category'])])->get();

        $courses = $enrollments
            ->map(function ($enrollment) use ($student) {
                if (!$enrollment->course) {
                    return null;
                }
                $course = $enrollment->course;
                $course->status = $enrollment->status;
                $course->progressPercentage = app(LearningService::class)
                    ->calculateCourseProgressPercentage($student, $course);
                return $course;
            })
            ->filter();

        return $courses->map(fn(Course $course) => $this->courseDecorator->decorateForCard($course));
    }

    private function fetchCourses(int $amount, array $order): Collection
    {
        $query = Course::query()
            ->where('status', 'published')
            ->with(['author', 'reviews', 'category']);

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        return $query->take($amount)->get()->map(fn(Course $course) => $this->courseDecorator->decorateForCard($course));
    }
}
