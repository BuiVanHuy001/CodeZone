<?php

namespace App\DTOs\Instructor;

use App\Models\User;
use Livewire\Wireable;

class InstructorDetailDTO implements Wireable {
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public string $avatarUrl,
        public string $joinedAt,

        public string $status,
        public string $statusLabel,
        public string $statusClass,

        public string $jobTitle,
        public string $bio,
        public string $aboutMe,
        public array  $socialLinks,

        public string $facultyName,
        public string $majorName,

        public int    $courseCount,
        public int    $studentCount,
        public float  $rating,
        public int    $reviewCount,
    ) {}

    public static function fromModel(User $user): self
    {
        $profile = $user->instructorProfile;

        $statusConfig = [
            'active' => ['class' => 'success', 'label' => 'Đang hoạt động'],
            'pending' => ['class' => 'warning', 'label' => 'Chờ duyệt'],
            'suspended' => ['class' => 'danger', 'label' => 'Đã đình chỉ'],
        ];
        $config = $statusConfig[$user->status] ?? ['class' => 'secondary', 'label' => 'N/A'];

        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            avatarUrl: $user->getAvatarPath(),
            joinedAt: $user->created_at->format('d/m/Y'),

            status: $user->status,
            statusLabel: $config['label'],
            statusClass: $config['class'],

            jobTitle: $profile?->current_job ?? 'Chưa cập nhật nghề nghiệp',
            bio: $profile?->bio ?? '',
            aboutMe: $profile?->about_me ?? '',
            socialLinks: $profile?->social_links ?? [],

            facultyName: $profile?->major?->faculty?->name ?? 'N/A',
            majorName: $profile?->major?->name ?? 'N/A',

            courseCount: $profile?->course_count ?? 0,
            studentCount: $profile?->student_count ?? 0,
            rating: $profile?->rating ?? 0.0,
            reviewCount: $profile?->review_count ?? 0,
        );
    }

    public function toLivewire(): array
    {
        return get_object_vars($this);
    }

    public static function fromLivewire($value): InstructorDetailDTO
    {
        return new self(...$value);
    }
}
