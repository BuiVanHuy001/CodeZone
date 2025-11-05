<?php

namespace App\Services\Course\Catalog;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
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

    public function prepareCourseList(int $amount, Request $request): Collection
    {
        $instructorService = app(InstructorService::class);

        $coursesPaginated = $this->courseFilter->filterCourse($amount, $request);

        $coursesPaginated->getCollection()->transform(fn(Course $course) => $this->courseDecorator->decorateForCard($course, collect()));

        $categories = Category::fetchCategoriesWithChildren();

        return collect([
            'courses' => $coursesPaginated,
            'categories' => $categories,
            'instructors' => $instructorService->getInstructors(),
        ]);
    }

    public function prepareCourseDetails(Course $course): Course
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

        return $query->take($amount)->get()->map(fn(Course $course) => $this->courseDecorator->decorateForCard($course, collect()));
    }

    public function getCoursesByAuthor(User $author): Collection
    {
        $order = [
            ['enrollment_count', 'desc'],
            ['review_count', 'desc'],
            ['rating', 'desc'],
        ];

        $query = Course::query()
            ->where('user_id', $author->id);

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        return $query->get()->map(fn(Course $course) => $this->courseDecorator->decorateForInstructorDashboard($course, $author));
    }

    public function getCoursesByStudent(User $student): Collection
    {
        $enrollmentsMap = $student->enrollments()
            ->get()
            ->keyBy('course_id');

        if ($enrollmentsMap->isEmpty()) {
            return collect();
        }

        $enrolledCourseIds = $enrollmentsMap->keys();

        $courses = Course::whereIn('id', $enrolledCourseIds)
            ->where('status', 'published')
            ->with(['author', 'reviews', 'category'])
            ->withCount([
                'modules as completed_lessons_count' => function ($query) use ($student) {
                    $query->selectRaw('count(distinct tracking_progresses.id)')
                        ->from('tracking_progresses')
                        ->join('lessons', 'lessons.id', '=', 'tracking_progresses.lesson_id')
                        ->join('modules', 'modules.id', '=', 'lessons.module_id')
                        ->whereColumn('modules.course_id', 'courses.id')
                        ->where('tracking_progresses.user_id', $student->id)
                        ->where('tracking_progresses.is_completed', true);
                }
            ])
            ->get();

        $courses->each(function ($course) use ($enrollmentsMap) {
            $course->enrollmentStatus = $enrollmentsMap[$course->id]->status;

            $totalLessons = max($course->lesson_count, 1);
            $completedCount = $course->completed_lessons_count;
            $course->progressPercentage = round(($completedCount / $totalLessons) * 100, 2);
        });

        return $courses->map(fn(Course $course) => $this->courseDecorator->decorateForCard($course, $enrolledCourseIds));
    }

    public function getCoursesByStatus(string $status): Collection
    {
        return match ($status) {
            'published' => $this->getPublishedCourses(),
            'draft' => $this->getDraftCourses(),
            'pending' => $this->getPendingCourses(),
            'rejected' => $this->getRejectedCourses(),
            'suspended' => $this->getSuspendedCourses(),
            default => collect(),
        };
    }

    private function getPublishedCourses(): Collection
    {
        $query = Course::query()
            ->where('status', 'published')
            ->with(['author', 'reviews', 'category']);

        return $query->get()->map(fn(Course $course) => $this->courseDecorator->decorateForAdminList($course));
    }

    private function getDraftCourses(): Collection
    {
        return collect();
    }

    private function getPendingCourses(): Collection
    {
        $query = Course::query()
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->with(['author', 'category']);

        return $query->get()->map(fn(Course $course) => $this->courseDecorator->decorateForAdminList($course, 'pending'));
    }

    private function getRejectedCourses(): Collection
    {
        $query = Course::query()
            ->where('status', 'rejected')
            ->with(['author', 'category']);

        return $query->get()->map(fn(Course $course) => $this->courseDecorator->decorateForAdminList($course, 'rejected'));
    }


    private function fetchCourses(int $amount, array $order): Collection
    {
        $query = Course::query()
            ->where('status', 'published')
            ->with(['author', 'reviews', 'category']);

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        $enrolledCourseIds = collect();
        if (auth()->check() && auth()->user()->isStudent()) {
            $enrolledCourseIds = auth()->user()->enrollments()->pluck('course_id');
        }

        return $query->take($amount)->get()->map(fn(Course $course) => $this->courseDecorator->decorateForCard($course, $enrolledCourseIds));
    }

    private function getSuspendedCourses(): Collection
    {
        $query = Course::query()
            ->where('status', 'suspended')
            ->with(['author', 'category']);

        return $query->get()->map(fn(Course $course) => $this->courseDecorator->decorateForAdminList($course, 'suspended'));
    }
}
