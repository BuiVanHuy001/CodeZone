<?php

namespace App\Services\Course\Catalog;

use App\Models\Course;
use App\Models\Reaction;
use App\Models\Review;
use App\Models\User;
use App\Services\Instructor\InstructorService;
use App\Support\CourseStatusMapping;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

readonly class CourseDecorator
{
    use HasNumberFormat;

    public function decorateForCard(Course $course, Collection $enrolledCourseIds): Course
    {
        $course = $this->decorateBase($course);

        $course->loadMissing(['reviews:id,rating', 'category:id,name', 'author:id,name,slug', 'author:instructorProfile']);

        if ($course->status === 'published') {
            $course->categoryName = $course->category?->name;
            $course->reviewCountText = $this->formatCount($course->review_count, 'review');
            $course->enrollmentCountText = $this->formatCount($course->enrollment_count, 'student');
            $course->detailsPageUrl = route('page.course_detail', $course->slug);
            if (!$enrolledCourseIds->isEmpty()) {
                $course->isEnrolled = $enrolledCourseIds->contains($course->id);
            } else {
                $course->isEnrolled = false;
            }
        }

        $course->authorInfo = [
            'name' => $course->author->name,
            'slug' => $course->author->slug,
            'avatar' => $course->author->getAvatarPath(),
            'profileUrl' => route('instructor.details', $course->author->slug),
        ];

        return $course;
    }

    public function decorateForDetails(Course $course): Course
    {
        if ($course->status === 'published') {
            $course->loadMissing([
                'author:id,name,slug',
                'category:id,name',
                'modules.lessons.assessment',
                'reviews' => function ($query) {
                    $query->with('user:id,name,avatar')
                        ->with('reactions')
                        ->orderBy('created_at', 'desc');
                }
            ]);

            if ($course->reviews->isNotEmpty() && auth()->check()) {
                $reviewIds = $course->reviews->pluck('id');
                $userId = auth()->id();

                $userReactions = Reaction::query()
                    ->where('user_id', $userId)
                    ->where('reactionable_type', Review::class)
                    ->whereIn('reactionable_id', $reviewIds)
                    ->get()
                    ->keyBy('reactionable_id');

                $course->reviews->each(function ($review) use ($userReactions) {
                    $reaction = $userReactions->get($review->id);
                    $review->userReaction = $reaction->action ?? null;
                });
            }

            $course = $this->decorateBase($course);

            $course->reviewCountText = $this->formatCount($course->reviews->count(), 'review');
            $course->categoryName = $course->category?->name;
            $course->enrollmentCountText = $this->formatCount($course->enrollment_count, 'student');
            $course->introVideo = $this->getIntroductionVideo($course->modules);
            $course->quizCount = $this->getQuizCount($course->modules);
            $course->reviews = $course->reviews->values();
            $course->updatedAtHuman = $course->updated_at->diffForHumans();

            $course->author = app(InstructorService::class)->prepareDetailForCourseDetail($course->author);

            $course->reviews = $course->reviews->values();
        } elseif ($course->status === 'pending') {
            $course->loadMissing([
                'author:id,name,slug',
                'category:id,name',
                'modules.lessons.assessment'
            ]);
            $course = $this->decorateBase($course);

            $course->reviewCountText = $this->formatCount(0, 'review');
            $course->categoryName = $course->category?->name;
            $course->introVideo = $this->getIntroductionVideo($course->modules);
            $course->quizCount = $this->getQuizCount($course->modules);
            $course->updatedAtHuman = $course->updated_at->diffForHumans();

            $course->author = app(InstructorService::class)->prepareDetailForCourseDetail($course->author);
        }
        return $course;
    }

    public function decorateForCartItem(Course $course): Course
    {
        $course = $this->decorateBase($course);
        $course->detailsPageUrl = route('page.course_detail', $course->slug);
        $course->authorInfo = [
            'name' => $course->author->name,
            'slug' => $course->author->slug,
            'avatar' => $course->author->getAvatarPath(),
            'profileUrl' => route('instructor.details', $course->author->slug),
        ];

        return $course;
    }

    public function decorateForInstructorDashboard(Course $course, User $author): Course
    {
        $course = $this->decorateBase($course);
        $course->detailsPageUrl = route('page.course_detail', $course->slug);
        $course->studentCountText = $this->formatCount($course->enrollment_count, 'student');
        $course->reviewCountText = $this->formatCount($course->review_count, 'review');
        $course->authorInfo = [
            'name' => $author->name,
            'slug' => $author->slug,
            'avatar' => $author->getAvatarPath(),
            'profileUrl' => route('instructor.details', $author->slug),
        ];

        return $course;
    }

    public function decorateForAdminList(Course $course, string $status = 'published'): Course
    {
        $course->categoryName = $course->category?->name ?? 'Uncategorized';
        $course->priceFormatted = $this->formatCurrency($course->price);
        $course->detailsPageUrl = route('page.course_detail', $course->slug);
        $course->authorInfo = [
            'name' => $course->author->name,
            'avatar' => $course->author->getAvatarPath(),
            'profileUrl' => route('instructor.details', $course->author->slug),
        ];

        if ($status === 'published') {
            $course->ratingText = number_format($course->rating) . "⭐ (" . $this->formatCount($course->reviews->count(), 'review)');
            $course->enrollmentCountText = $this->formatCount($course->enrollment_count, 'student');
        }
        if ($status === 'pending') {
            $course->durationText = $course->convertDurationToString();
        }

        $course->status = CourseStatusMapping::$statusLabels[$status];
        $course->createdAtText = $course->created_at->diffForHumans();
        return $course;
    }

    private function decorateBase(Course $course): Course
    {
        $course->thumbnail = $this->getThumbnailPath($course);
        $course->lessonCountText = $this->formatCount($course->lesson_count, 'lesson');
        $course->priceFormatted = $this->formatCurrency($course->price);
        $course->durationText = $course->convertDurationToString();

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
