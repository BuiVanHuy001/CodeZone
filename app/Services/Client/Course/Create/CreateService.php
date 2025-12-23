<?php

namespace App\Services\Client\Course\Create;

use App\Models\Course;
use App\Models\User;
use App\Services\Client\Course\Create\Factories\ModuleService;

readonly class CreateService
{
    public function storeCourse(User $author, array $courseData): void
    {
        $course = $this->storeCourseInfo($courseData, $author->id);

        app(ModuleService::class)->create($course, $courseData['modules']);

        $author->instructorProfile->increment('course_count');
    }

    private function storeCourseInfo(array $info, string $authorId): Course
    {
        return Course::create([
            'title' => $info['title'],
            'heading' => $info['heading'],
            'description' => $info['description'],
            'thumbnail' => $info['thumbnail'],
            'type' => $info['courseType'],
            'price' => $info['courseType'] !== 'internal' ? $info['price'] : 0,
            'review_count' => 0,
            'lesson_count' => 0,
            'level' => $info['level'],
            'duration' => 0,
            'status' => 'pending',
            'category_id' => $info['category'],
            'requirements' => $this->normalizeJsonField($info['requirements']),
            'skills' => $this->normalizeJsonField($info['skills']),
            'target_audiences' => $this->normalizeJsonField($info['targetAudiences']),
            'user_id' => $authorId,
        ]);
    }

    private function normalizeJsonField(string $field): ?string
    {
        $lines = array_filter(array_map(
                'trim',
                explode("\n", $field)
            )
        );
        if (empty($lines)) {
            return null;
        }

        return json_encode(
            array_map(
                static fn($item) => ['name' => $item], $lines),
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
