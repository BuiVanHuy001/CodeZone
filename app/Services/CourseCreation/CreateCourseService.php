<?php

namespace App\Services\CourseCreation;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\Batch;
use App\Models\BatchEnrollments;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\ProgrammingAssignmentDetails;

class CreateCourseService {
    public function storeCourse(array $courseData): void
    {
        $courseDuration = 0;
        $lessonCount = 0;
        $course = Course::create([
            'title' => $courseData['title'],
            'heading' => $courseData['heading'],
            'description' => $courseData['description'],
            'thumbnail_url' => $courseData['thumbnail'],
            'price' => $courseData['price'] ?? 0,
            'review_count' => 0,
            'lesson_count' => $lessonCount,
            'level' => $courseData['level'],
            'duration' => $courseDuration,
            'status' => 'pending',
            'category_id' => $courseData['category'],
            'requirements' => $this->normalizeJsonField($courseData['requirements']),
            'skills' => $this->normalizeJsonField($courseData['skills']),
            'user_id' => auth()->user()->id,
        ]);
        foreach ($courseData['modules'] as $moduleIndex => $moduleData) {
            $moduleDuration = 0;
            $moduleLessonCount = count($moduleData['lessons']);
            $lessonCount += $moduleLessonCount;

            $module = Module::create([
                'title' => $moduleData['title'],
                'lesson_count' => $moduleLessonCount,
                'position' => $moduleIndex,
                'duration' => 0,
                'course_id' => $course->id,
            ]);

            foreach ($moduleData['lessons'] as $lessonKey => $lessonData) {
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
                    $this->storeAssessment($lessonData['assessment'], $lesson->id);
                } elseif (isset($lessonData['practice_assessments'])) {
                    foreach ($lessonData['practice_assessments'] as $practiceAssessment) {
                        $this->storeAssessment($practiceAssessment, $lesson->id);
                    }
                }
            }
            $module->duration = $moduleDuration;
            $module->save();
            $courseDuration += $moduleDuration;
        }
        $course->duration = $courseDuration;
        $course->lesson_count = $lessonCount;

        if (auth()->user()->isOrganization()) {
            $batch = Batch::create([
                'start_at' => $courseData['startDate'],
                'end_at' => $courseData['endDate'],
                'course_id' => $course->id
            ]);
            $course->enrollment_count = count($courseData['membersAssigned']);
            foreach ($courseData['membersAssigned'] as $employeeId) {
                BatchEnrollments::create([
                    'batch_id' => $batch->id,
                    'user_id' => $employeeId,
                    'status' => 'not_started'
                ]);
            }
        }
        $course->save();
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
        } else {
            return json_encode(
                array_map(fn($item) => ['name' => $item], $lines),
                JSON_UNESCAPED_UNICODE
            );
        }
    }

    private function storeAssessment(array $assessmentData, string|int $lessonId): void
    {
        if ($assessmentData['type'] === 'quiz') {
            $questionCount = count($assessmentData['assessments_questions']);
        }

        $assessment = Assessment::create([
            'title' => $assessmentData['title'],
            'description' => $assessmentData['description'],
            'type' => $assessmentData['type'],
            'lesson_id' => $lessonId,
            'questions_count' => $questionCount ?? 1,
        ]);
        $assessment->save();

        match ($assessmentData['type']) {
            'quiz' => $this->storeQuiz($assessmentData['assessments_questions'], $assessment->id),
            'programming' => $this->storeProgrammingPractice($assessmentData, $assessment->id),
            default => null,
        };
    }

    private function storeProgrammingPractice(array $programmingPracticeData, string|int $assessmentId): void
    {
        ProgrammingAssignmentDetails::create([
            'assessment_id' => $assessmentId,
            'function_name' => $programmingPracticeData['problem_details']['function_name'],
            'code_templates' => $programmingPracticeData['problem_details']['code_templates'],
            'test_cases' => $programmingPracticeData['problem_details']['test_cases']
        ]);
    }

    private function storeQuiz(array $questions, string|int $assessmentId): void
    {
        foreach ($questions as $index => $question) {
            $assessmentQuestion = AssessmentQuestion::create([
                'content' => $question['content'],
                'type' => $question['type'],
                'position' => $index + 1,
                'assessment_id' => $assessmentId
            ]);
            foreach ($question['question_options'] as $optionIndex => $option) {
                $assessmentQuestion->options()->create([
                    'assessment_question_id' => $assessmentQuestion->id,
                    'content' => $option['content'],
                    'is_correct' => $option['is_correct'] ?? false,
                    'explanation' => $option['explanation'] ?? '',
                    'position' => $optionIndex + 1
                ]);
            }
        }
    }
}
