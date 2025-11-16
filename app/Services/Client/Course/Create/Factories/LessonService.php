<?php

namespace App\Services\Client\Course\Create\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;

readonly class LessonService
{
    public function __construct(
        private AssessmentService $assessmentService,
    )
    {
    }

    public function create(Course $course, Module $module, array $lessons): void
    {
        $moduleDuration = 0;
        foreach ($lessons as $lessonKey => $lessonData) {
            $moduleDuration += $lessonData['duration'] ?? 0;
            $lesson = Lesson::create([
                'title' => $lessonData['title'],
                'type' => $lessonData['type'],
                'duration' => $lessonData['duration'] ?? 0,
                'video_file_name' => $lessonData['video_file_name'],
                'document' => $lessonData['document'],
                'preview' => $lessonData['preview'],
                'position' => $lessonKey + 1,
                'module_id' => $module->id
            ]);

            if (isset($lessonData['assessment'])) {
                $this->assessmentService->create($lessonData['assessment'], $lesson->id);
            }
        }

        $module->update(['duration' => $moduleDuration]);
        $course->increment('duration', $moduleDuration);
    }
}
