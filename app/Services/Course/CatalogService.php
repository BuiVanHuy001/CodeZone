<?php

namespace App\Services\Course;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CatalogService
{
    public function prepareDetails(Course $course): Course
    {
        $course->load([
            'category:id,name',
            'reviews' => fn($q) => $q->with('user'),
            'modules.lessons.assessment'
        ]);

        $course->category_name = $course->category?->name;
        $course->thumbnail = $course->getThumbnailPath();
        $course->review_count_text = $this->formatCount($course->reviews->count(), 'review');
        $course->enrollment_count_text = $this->formatCount($course->enrollment_count, 'student');
        $course->lesson_count_text = $this->formatCount($course->lesson_count, 'lesson');
        $course->price_formatted = $course->getFormattedPrice();
        $course->introVideo = $this->getIntroductionVideo($course->modules);
        $course->quiz_count = $this->getQuizCount($course->modules);
        $course->reviews = $course->reviews->sortByDesc('created_at')->values();
        $course->updated_at_human = $course->updated_at->diffForHumans();
        $course->duration_text = $course->convertDurationToString();
        $course->authorInfo = [
            'name' => $course->author->name,
            'slug' => $course->author->slug,
            'avatar' => $course->author->getAvatarPath(),
            'profile_url' => route('instructor.details', $course->author->slug)
        ];

        return $course;
    }

    public function getPopularCourses(int $amount = 10): Collection
    {
        $order = [
            ['enrollment_count', 'desc'],
            ['review_count', 'desc'],
            ['rating', 'desc'],
        ];

        return $this->fetchCourses($amount, $order);
    }

    public function getHotCourses(int $amount = 5): Collection
    {
        $order = [
            ['rating', 'desc'],
            ['review_count', 'desc'],
            ['enrollment_count', 'desc'],
        ];

        return $this->fetchCourses($amount, $order);
    }

    public function getRelatedCourses(User $author, string $currentCourseId, int $amount = 2): Collection
    {
        $order = [
            ['rating', 'desc'],
            ['review_count', 'desc'],
        ];

        $query = $author->courses()
            ->where('status', 'published')
            ->where('id', '!=', $currentCourseId);

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        return $query->take($amount)->get()->map(fn(Course $course) => $this->decorateCourseCard($course));
    }

    public function getAllCourse(User $author): Collection
    {
        $order = [
            ['enrollment_count', 'desc'],
            ['review_count', 'desc'],
            ['rating', 'desc'],
        ];

        $query = Course::query()
            ->where('user_id', $author->id)
            ->where('status', 'published');

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        return $query->get()->map(fn(Course $course) => $this->decorateCourseCard($course));
    }

    private function fetchCourses(int $amount, array $order): Collection
    {
        $query = Course::query()
            ->where('status', 'published')
            ->with(['author', 'reviews', 'category']);

        foreach ($order as [$col, $dir]) {
            $query->orderBy($col, $dir);
        }

        return $query->take($amount)->get()->map(fn(Course $course) => $this->decorateCourseCard($course));
    }

    private function decorateCourseCard(Course $course): Course
    {
        $course->lessonCountText = $this->formatCount($course->lesson_count, 'lesson');
        $course->studentCountText = $this->formatCount($course->enrollment_count, 'student');
        $course->reviewCountText = $this->formatCount($course->review_count, 'review');
        $course->priceFormatted = $course->getFormattedPrice();
        $course->thumbnail = $course->getThumbnailPath();
        $course->detailsPageUrl = route('page.course_detail', $course->slug);
        $course->authorInfo = [
            'name' => $course->author->name,
            'slug' => $course->author->slug,
            'avatar' => $course->author->getAvatarPath(),
            'profile_url' => route('instructor.details', $course->author->slug)
        ];
        return $course;
    }

    private function formatCount(int $count, string $word): string
    {
        return $count . ' ' . str($word)->plural($count);
    }

    private function getIntroductionVideo(Collection $modules): string
    {
        $lesson = $modules
            ->flatMap(fn($m) => $m->lessons)
            ->first(fn($l) => (bool)$l->preview);

        if (!$lesson) {
            return '';
        }

        return Storage::url('course/videos/' . $lesson->video_file_name);
    }

    private function getQuizCount(Collection $modules): int
    {
        return $modules
            ->flatMap(fn($m) => $m->lessons)
            ->filter(fn($l) => $l->type === 'assessment'
                && $l->assessment
                && $l->assessment->type === 'quiz')
            ->count();
    }
}
