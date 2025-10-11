<?php

namespace App\Services\Course;

use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\ProgrammingAttempt;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\TrackingProgress;
use App\Models\User;

class LearningService
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
        $isLastLesson = $this->isLastLesson($course, $currentLesson->id);
        $allCompleted = $nextId === null && $this->areAllLessonsCompleted($course);

        $nextRoute = null;
        if ($nextId) {
            $nextRoute = route('course.learn.lesson', ['slug' => $course->slug, 'id' => $nextId]);
        } elseif ($isLastLesson && $allCompleted) {
            $nextRoute = route('course.learn.lesson', ['slug' => $course->slug, 'id' => $currentLesson->id, 'completed' => 1]);
        }

        return [
            'prev' => $prevId ? route('course.learn.lesson', ['slug' => $course->slug, 'id' => $prevId]) : null,
            'next' => $nextRoute,
            'prevId' => $prevId,
            'nextId' => $nextId,
            'isLastLesson' => $isLastLesson,
            'allLessonsCompleted' => $allCompleted,
        ];
    }

    private function isLastLesson(Course $course, string $lessonId): bool
    {
        $lessons = $this->getOrderedLessons($course);
        $lastLesson = $lessons->last();

        return $lastLesson && (string)$lastLesson->id === $lessonId;
    }

    public function areAllLessonsCompleted(Course $course): bool
    {
        $userId = auth()->id();
        $lessons = $this->getOrderedLessons($course);
        $lessonIds = $lessons->pluck('id')->toArray();

        $completedCount = TrackingProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $lessonIds)
            ->where('is_completed', true)
            ->count();

        return $completedCount === count($lessonIds);
    }

    public function getAdjacentLessonId(Course $course, string $currentLessonId, string $direction = 'next'): ?string
    {
        $lessons = $this->getOrderedLessons($course);
        $index = $lessons->search(fn($l) => (string)$l->id === $currentLessonId);
        if ($index === false) {
            return $lessons->first()->id;
        }

        $adjIndex = $direction === 'next' ? $index + 1 : $index - 1;

        if ($direction === 'next' && $adjIndex >= $lessons->count()) {
            return $this->handleLastLessonNavigation($lessons);
        }

        return $lessons->get($adjIndex)?->id ?? $lessons->first()->id;
    }

    private function handleLastLessonNavigation($lessons): ?string
    {
        $userId = auth()->id();

        $lessonIds = $lessons->pluck('id')->toArray();

        $completedLessonIds = TrackingProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $lessonIds)
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        foreach ($lessonIds as $lessonId) {
            if (!in_array($lessonId, $completedLessonIds)) {
                return $lessonId;
            }
        }

        return $lessons->first()->id;
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
        if (auth()->user()->isStudent()) {
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
    }

    public function calculateCourseProgressPercentage(User $user, Course $course): float|int
    {
        $totalLessons = $course->lesson_count;

        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = $user
            ->progressTracking()
            ->whereHas('lesson', function ($query) use ($course) {
                $query->whereIn('module_id', $course->modules->pluck('id'));
            })
            ->where('is_completed', true)
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }

}
