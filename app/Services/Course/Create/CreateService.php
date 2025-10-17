<?php

namespace App\Services\Course\Create;

use App\Models\Batch;
use App\Models\BatchEnrollments;
use App\Models\Course;
use App\Models\User;
use App\Services\Course\Create\Factories\ModuleService;

readonly class CreateService
{
    public function __construct(
        private ModuleService $moduleService,
    )
    {
    }

    public function storeCourse(User $author, array $courseData): void
    {
        $course = $this->storeCourseInfo($courseData, $author->id);

        $this->moduleService->create($course, $courseData['modules']);

        if ($author->isOrganization()) {
            $batch = Batch::create([
                'start_at' => $courseData['startDate'],
                'end_at' => $courseData['endDate'],
                'course_id' => $course->id
            ]);
            $course->update(['enrollment_count' => count($courseData['membersAssigned'])]);

            foreach ($courseData['membersAssigned'] as $employeeId) {
                BatchEnrollments::create([
                    'batch_id' => $batch->id,
                    'user_id' => $employeeId,
                    'status' => 'not_started'
                ]);
            }
        }
        $author->getProfile->increment('course_count');
    }

    private function storeCourseInfo(array $info, string $authorId): Course
    {
        return Course::create([
            'title' => $info['title'],
            'heading' => $info['heading'],
            'description' => $info['description'],
            'thumbnail' => $info['thumbnail'],
            'price' => $info['price'] ?? 0,
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
                fn($item) => ['name' => $item], $lines),
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
