<?php

namespace App\DTOs\Course;

use App\Models\Course;
use Livewire\Wireable;

class CourseSummary implements Wireable {
    public function __construct(
        public string  $id,
        public string  $name,
        public string  $slug,
        public string  $thumbnail,
        public string  $detailUrl,
        public string  $priceFormatted,
        public string  $createdAt,
        public string  $categoryName,
        public int     $enrollmentCount,
        public float   $rating,
        public int     $reviewCount,
        public string  $durationFormatted,

        // Status Info (Đã xử lý logic màu/nhãn)
        public string  $statusLabel,
        public string  $statusClass,

        // Level Info (Đã xử lý logic màu/nhãn)
        public string  $levelLabel,
        public string  $levelClass,

        // Author Info
        public ?string $authorName = null,
        public ?string $authorProfileUrl = null,
        public ?string $authorAvatar = null,

        // Student Context
        public int     $progress = 0,
        public ?string $enrollmentStatus = null,
    ) {}

    public function toLivewire(): array
    {
        return get_object_vars($this);
    }

    public static function fromLivewire($value): CourseSummary
    {
        return new self(...$value);
    }

    public static function fromModel(
        Course  $course,
        bool    $includeAuthor = false,
        int     $progress = 0,
        ?string $enrollmentStatus = null,
    ): self
    {
        $defaultStatus = Course::$STATUSES[$course->status] ?? ['label' => 'N/A', 'class' => 'light'];
        $statusLabel = $defaultStatus['label'];
        $statusClass = $defaultStatus['class'];

        if ($enrollmentStatus) {
            $enrollmentMap = [
                'completed' => ['label' => 'Hoàn thành', 'class' => 'success'],
                'in_progress' => ['label' => 'Đang học', 'class' => 'primary'],
                'not_started' => ['label' => 'Chưa học', 'class' => 'warning'],
            ];

            if (isset($enrollmentMap[$enrollmentStatus])) {
                $statusLabel = $enrollmentMap[$enrollmentStatus]['label'];
                $statusClass = $enrollmentMap[$enrollmentStatus]['class'];
            }
        }

        $levelConfig = Course::$LEVELS[$course->level] ?? ['label' => 'N/A', 'class' => 'light'];

        $authorName = null;
        $profileUrl = null;
        $avatarUrl = null;

        if ($includeAuthor && $course->relationLoaded('author')) {
            $authorName = $course->author ? $course->author->name : 'Unknown';
            $profileUrl = method_exists($course->author, 'getProfileUrl') ? $course->author->getProfileUrl() : '#';
            $avatarUrl = method_exists($course->author, 'getAvatarPath') ? $course->author->getAvatarPath() : null;
        }

        return new self(
            id: $course->id,
            name: $course->title,
            slug: $course->slug,
            thumbnail: $course->getThumbnailPath(),
            detailUrl: route('page.course_detail', $course->slug),
            priceFormatted: number_format($course->price) . ' đ',
            createdAt: $course->created_at->format('d/m/Y'),
            categoryName: $course->category->name ?? 'Uncategorized',
            enrollmentCount: $course->enrollment_count ?? 0,
            rating: $course->rating ?? 0.0,
            reviewCount: $course->review_count ?? 0,
            durationFormatted: $course->convertDurationToString(),

            statusLabel: $statusLabel,
            statusClass: $statusClass,

            levelLabel: $levelConfig['label'],
            levelClass: $levelConfig['class'],

            authorName: $authorName,
            authorProfileUrl: $profileUrl,
            authorAvatar: $avatarUrl,

            progress: $progress,
            enrollmentStatus: $enrollmentStatus
        );
    }
}
