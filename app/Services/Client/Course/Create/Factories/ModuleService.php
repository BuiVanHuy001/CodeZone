<?php

namespace App\Services\Client\Course\Create\Factories;

use App\Models\Course;
use App\Models\Module;

readonly class ModuleService
{
    public function __construct(
        private LessonService $lessonService,
    )
    {
    }

    public function create(Course $course, array $modules): void
    {
        $lessonCount = 0;
        foreach ($modules as $moduleIndex => $moduleData) {
            $moduleLessonCount = count($moduleData['lessons']);
            $lessonCount += $moduleLessonCount;

            $module = Module::create([
                'title' => $moduleData['title'],
                'lesson_count' => $moduleLessonCount,
                'position' => $moduleIndex + 1,
                'duration' => 0,
                'course_id' => $course->id,
            ]);

            $this->lessonService->create($course, $module, $moduleData['lessons']);
        }

        $course->update(['lesson_count' => $lessonCount,]);
    }
}
