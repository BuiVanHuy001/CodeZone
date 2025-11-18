<?php

namespace App\Services\Admin\Course;

use App\Events\Course\ApprovedEvent;
use App\Events\Course\RejectedEvent;
use App\Events\Course\RestoredEvent;
use App\Models\Course;
use App\Notifications\Course\CourseApprovedNotification;
use App\Notifications\Course\CourseRejectedNotification;
use App\Notifications\Course\CourseRestoredNotification;
use App\Services\Client\Course\Catalog\CatalogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

readonly class CourseService
{
    private CatalogService $catalogService;

    public function __construct()
    {
        $this->catalogService = app(CatalogService::class);
    }

    public function prepareDataForCourseList(): array
    {
        $result = [];

        if (auth()->check() && auth()->user()->hasRole('admin')) {
            foreach (Course::$STATUSES as $status) {
                $courses = $this->catalogService->getCoursesByStatus($status);
                $result[$status] = $courses;
            }
        }

        return $result;
    }

    public function approveCourse(string|int $courseId): bool
    {
        $course = Course::find($courseId);
        if ($course) {
            $course->update([
                'status' => 'published',
            ]);
            ApprovedEvent::dispatch($course);
            return true;
        }
        return false;
    }

    public function rejectCourse(string|int $courseId): bool
    {
        try {
            return DB::transaction(function () use ($courseId) {
                $course = Course::findOrFail($courseId);
                $course->update(['status' => 'rejected']);
                RejectedEvent::dispatch($course);
                return true;
            });
        } catch (\Throwable $e) {
            report($e);
            return false;
        }
    }

    public function restoreCourse(string|int $courseId): bool
    {
        $course = Course::find($courseId);
        if ($course) {
            $course->update([
                'status' => 'published',
            ]);
            RestoredEvent::dispatch($course);
            return true;
        }
        return false;
    }

    public function suspendCourse(string|int $courseId): bool
    {
        $course = Course::find($courseId);
        if ($course) {
            $course->update([
                'status' => 'suspended',
            ]);
            return true;
        }
        return false;
    }
}
