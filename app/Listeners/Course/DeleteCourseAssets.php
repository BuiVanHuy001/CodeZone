<?php

namespace App\Listeners\Course;

use App\Events\Course\RestoredEvent;
use App\Models\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DeleteCourseAssets {
    public function __construct() {}

    public function handle(RestoredEvent $event): void
    {
        $this->deleteCourseAssets($event->course);
    }

    private function deleteCourseAssets(Course $course): void
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
}
