<?php

namespace App\Services\Admin\Course;

use App\Models\Course;
use App\Notifications\CourseApprovedNotification;
use App\Notifications\CourseRejectedNotification;
use App\Services\Course\Catalog\CatalogService;
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
            $course->author->notify(new CourseApprovedNotification($course));
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

                $this->deleteCourseAssets($course);

                $course->author->notify(new CourseRejectedNotification($course));

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
                'status' => 'pending_approval',
            ]);
            return true;
        }
        return false;
    }

    public function deleteCourseAssets(Course $course): void
    {
        if ($course->thumbnail_url) {
            $this->deleteThumbnail($course->thumbnail_url);
        }
        $this->deleteModule($course);
    }

    private function deleteThumbnail(string $thumbnail_url): void
    {
        if (Storage::disk('public')->exists('course/thumbnails/' . $thumbnail_url)) {
            Storage::disk('public')->delete('course/thumbnails/' . $thumbnail_url);
        }
    }

    private function deleteModule(Course $course): void
    {
        $course->modules()->delete();
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
