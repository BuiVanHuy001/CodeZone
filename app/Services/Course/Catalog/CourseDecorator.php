<?php

namespace App\Services\Course\Catalog;

use App\Models\Course;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CourseDecorator
{
    use HasNumberFormat;

    public function decorateForCard(Course $course): Course
    {
        $course = $this->decorateBase($course);

        $course->loadMissing('reviews:id,course_id,rating');

        if ($course->status === 'published') {
            $course->reviewCountText = $this->formatCount($course->review_count, 'review');
            $course->enrollmentCountText = $this->formatCount($course->enrollment_count, 'student');
            $course->detailsPageUrl = route('page.course_detail', $course->slug);
        }


        return $course;
    }

    public function decorateForDetails(Course $course): Course
    {
        $course = $this->decorateBase($course);

        $course->loadMissing([
            'reviews.user',
            'modules.lessons.assessment',
        ]);

        $course->reviewCountText = $this->formatCount($course->reviews->count(), 'review');
        $course->enrollmentCountText = $this->formatCount($course->enrollment_count, 'student');
        $course->introVideo = $this->getIntroductionVideo($course->modules);
        $course->quizCount = $this->getQuizCount($course->modules);
        $course->reviews = $course->reviews->sortByDesc('created_at')->values();
        $course->updatedAtHuman = $course->updated_at->diffForHumans();

        return $course;
    }

    private function getThumbnailPath(Course $course): string
    {
        if ($course->thumbnail) {
            if (filter_var($course->thumbnail, FILTER_VALIDATE_URL)) {
                return $course->thumbnail;
            }

            if (str_starts_with($course->thumbnail, '/storage/')) {
                return $course->thumbnail;
            }

            if (str_starts_with($course->thumbnail, 'storage/')) {
                return '/' . $course->thumbnail;
            }

            return Storage::url('course/thumbnails/' . $course->thumbnail);
        }
        return asset('images/others/thumbnail-placeholder.svg');
    }

    private function decorateBase(Course $course): Course
    {
        $course->loadMissing('category:id,name', 'author');

        $course->thumbnail = $this->getThumbnailPath($course);
        $course->categoryName = $course->category?->name;
        $course->lessonCountText = $this->formatCount($course->lesson_count, 'lesson');
        $course->priceFormatted = $this->formatCurrency($course->price);
        $course->durationText = $course->convertDurationToString();

        $course->authorInfo = [
            'name' => $course->author->name,
            'slug' => $course->author->slug,
            'avatar' => $course->author->getAvatarPath(),
            'profileUrl' => route('instructor.details', $course->author->slug),
        ];

        return $course;
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
