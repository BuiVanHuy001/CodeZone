<?php

namespace App\Services\CourseLearn;

use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\AttemptProgramming;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\TrackingProgress;

class CourseService
{
    public function getLesson(Course $course): string|null
    {
        if (auth()->user()->role === 'student') {
            return $this->getCurrentLessonForStudent($course);
        }

        return $course->modules->first()->lessons->first()->id;
    }

    private function getCurrentLessonForStudent(Course $course): ?string
    {
        $userId = auth()->id();

        $lessons = $this->getOrderedLessons($course);

        $lessonIds = $lessons->pluck('id');

        $progress = TrackingProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $lessonIds)
            ->orderByDesc('updated_at')
            ->first();


        if (!$progress) {
            return $lessonIds->first();
        }

        if (!$progress->is_completed) {
            return $progress->lesson_id;
        }

        $lessonIndex = $lessonIds->search($progress->lesson_id);

        if ($lessonIndex !== false && isset($lessonIds[$lessonIndex + 1])) {
            return $lessonIds[$lessonIndex + 1];
        }
        return $lessonIds->last();
    }

    public function getNavigationRoutes(Course $course, Lesson $currentLesson): array
    {
        $prevId = $this->getAdjacentLessonId($course, $currentLesson->id, 'previous');
        $nextId = $this->getAdjacentLessonId($course, $currentLesson->id);

        return [
            'prev' => $prevId ? route('course.learn.lesson', ['course' => $course->slug, 'id' => $prevId]) : null,
            'next' => $nextId ? route('course.learn.lesson', ['course' => $course->slug, 'id' => $nextId]) : null,
            'prevId' => $prevId,
            'nextId' => $nextId,
        ];
    }

    public function getAdjacentLessonId(Course $course, string $currentLessonId, string $direction = 'next'): ?string
    {
        $lessons = $this->getOrderedLessons($course);

        $index = $lessons->search(fn($l) => (string)$l->id === $currentLessonId);
        if ($index === false) {
            return null;
        }
        $adjIndex = $direction === 'next' ? $index + 1 : $index - 1;
        return $lessons->get($adjIndex)?->id ?? null;
    }

    private function getOrderedLessons(Course $course)
    {
        return $course->modules
            ->sortBy('position')
            ->flatMap(fn($module) => $module->lessons->sortBy('position')->values())
            ->values();
    }

    public function markLessonComplete(string $lessonId): void
    {
        $userId = auth()->id();

        $progress = TrackingProgress::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->first();

        if ($progress) {
            if (!$progress->is_completed) {
                $progress->update(['is_completed' => true]);
            }
            return;
        }

        TrackingProgress::create([
            'user_id' => $userId,
            'lesson_id' => $lessonId,
            'is_completed' => true,
        ]);
    }

    public function saveProgrammingAttempt(string|int $total_score, Assessment $assessment, bool $is_passed, string $user_code, string $language): void
    {
        $assessmentAttempt = AssessmentAttempt::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'assessment_id' => $assessment->id,
            ],
            [
                'total_score' => $total_score,
                'is_passed' => $is_passed,
            ]
        );

        $existing = AttemptProgramming::where('assessment_attempt_id', $assessmentAttempt->id)
            ->where('language', $language)
            ->first();

        if ($existing) {
            $existing->update([
                'user_code' => $user_code,
                'language' => $language,
            ]);
        } else {
            AttemptProgramming::create([
                'assessment_attempt_id' => $assessmentAttempt->id,
                'user_code' => $user_code,
                'language' => $language,
            ]);
        }
    }

    public function canAccess(Course $course): bool
    {
        if (auth()->check()) {
            if ($course->author->id === auth()->user()->id ||
                $course->enrollments()->where('user_id', auth()->id())->exists()) {
                return true;
            }
        }
        return false;
    }
}
