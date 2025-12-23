<?php

namespace App\Services\Client\Course\Create\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Services\Client\Course\Create\Builders\LessonTypes\VideoService;

readonly class LessonService
{
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

            if ($lesson->type === 'video' && isset($lessonData['video_file_name'])) {
                app(VideoService::class)->storePendingVideo($lessonData['video_file_name']);
            }

            if (isset($lessonData['assessment'])) {
                app(AssessmentService::class)->create($lessonData['assessment'], $lesson->id);
            }
        }

        $module->update(['duration' => $moduleDuration]);
        $course->increment('duration', $moduleDuration);
    }

}
