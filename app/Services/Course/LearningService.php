<?php

namespace App\Services\Course;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\TrackingProgress;
use App\Models\User;
use Illuminate\Support\Collection;

class LearningService
{
    private ?Collection $orderedLessonsCache = null;

    public function getLesson(Course $course): ?string
    {
        $user = auth()->user();

        if ($user->hasRole('student')) {
            return $this->getCurrentLessonForStudent($course, $user);
        }

        return $this->getFirstLessonId($course);
    }

    private function getCurrentLessonForStudent(Course $course, User $user): ?string
    {
        $lessons = $this->getOrderedLessons($course);
        $lessonIds = $lessons->pluck('id');

        $progress = TrackingProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->latest('updated_at')
            ->first();

        if (!$progress) {
            return $lessonIds->first();
        }

        if (!$progress->is_completed) {
            return $progress->lesson_id;
        }

        $nextLessonId = $this->getNextLessonId($lessons, $progress->lesson_id);
        return $nextLessonId ?? $lessonIds->last();
    }

    public function getNavigationRoutes(Course $course, Lesson $currentLesson): array
    {
        $prevId = $this->getAdjacentLessonId($course, $currentLesson->id, 'previous');
        $nextId = $this->getAdjacentLessonId($course, $currentLesson->id, 'next');

        $isLast = $this->isLastLesson($course, $currentLesson->id);
        $isAllCompleted = !$nextId && $this->areAllLessonsCompleted($course);

        return [
            'prev' => $this->buildLessonRoute($course, $prevId),
            'next' => $this->buildNextRoute($course, $currentLesson, $nextId, $isLast, $isAllCompleted),
            'prevId' => $prevId,
            'nextId' => $nextId,
            'isLastLesson' => $isLast,
            'allLessonsCompleted' => $isAllCompleted,
        ];
    }

    private function buildLessonRoute(Course $course, ?string $lessonId): ?string
    {
        return $lessonId
            ? route('course.learn.lesson', ['slug' => $course->slug, 'id' => $lessonId])
            : null;
    }

    private function buildNextRoute(Course $course, Lesson $currentLesson, ?string $nextId, bool $isLast, bool $isAllCompleted): ?string
    {
        if ($nextId) {
            return $this->buildLessonRoute($course, $nextId);
        }

        if ($isLast && $isAllCompleted) {
            return route('course.learn.lesson', [
                'slug' => $course->slug,
                'id' => $currentLesson->id,
                'completed' => 1,
            ]);
        }

        return null;
    }

    private function isLastLesson(Course $course, string $lessonId): bool
    {
        return $this->getOrderedLessons($course)->last()?->id === $lessonId;
    }

    public function areAllLessonsCompleted(Course $course): bool
    {
        $user = auth()->user();
        $lessonIds = $this->getOrderedLessons($course)->pluck('id');

        $completedCount = TrackingProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->where('is_completed', true)
            ->count();

        return $completedCount === $lessonIds->count();
    }

    public function getAdjacentLessonId(Course $course, string $currentId, string $direction = 'next'): ?string
    {
        $lessons = $this->getOrderedLessons($course);
        $index = $lessons->search(fn($l) => $l->id === $currentId);

        if ($index === false) {
            return $this->getFirstLessonId($course);
        }

        $targetIndex = $direction === 'previous' ? $index - 1 : $index + 1;

        return $lessons->get($targetIndex)?->id
            ?? ($direction === 'next' ? $this->getUncompletedLessonId($lessons) : $lessons->first()?->id);
    }

    private function getOrderedLessons(Course $course): Collection
    {
        if ($this->orderedLessonsCache !== null) {
            return $this->orderedLessonsCache;
        }

        $lessons = $course->modules
            ->sortBy('position')
            ->flatMap(fn($module) => $module->lessons->sortBy('position'))
            ->values();

        return $this->orderedLessonsCache = $lessons;
    }

    public function markLessonComplete(string $lessonId): void
    {
        $user = auth()->user();
        if (!$user->hasRole('student')) return;

        TrackingProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lessonId],
            ['is_completed' => true]
        );

        $lesson = Lesson::with('course')->find($lessonId);
        if (!$lesson || !$lesson->course) {
            return;
        }

        $enrollment = Enrollment::where('course_id', $lesson->course->id)
            ->where('user_id', $user->id)
            ->first();


        if ($this->areAllLessonsCompleted($lesson->course)) {
            $enrollment?->update(['status' => 'completed']);
            return;
        }

        if ($enrollment && $enrollment->status === 'not_started') {
            $enrollment->update(['status' => 'in_progress']);
        }
    }

    private function getFirstLessonId(Course $course): ?string
    {
        return $course->modules->first()?->lessons->first()?->id;
    }

    private function getNextLessonId(Collection $lessons, string $currentLessonId): ?string
    {
        $index = $lessons->search(fn($lesson) => $lesson->id === $currentLessonId);
        return $index !== false ? $lessons->get($index + 1)?->id : null;
    }

    private function getUncompletedLessonId(Collection $lessons): ?string
    {
        $userId = auth()->id();

        $completed = TrackingProgress::where('user_id', $userId)
            ->whereIn('lesson_id', $lessons->pluck('id'))
            ->where('is_completed', true)
            ->pluck('lesson_id')
            ->toArray();

        return $lessons->first(fn($l) => !in_array($l->id, $completed, true))?->id;
    }
}
