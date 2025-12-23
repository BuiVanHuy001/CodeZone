<?php

namespace App\DTOs\Student;

use App\Models\StudentProfile;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Wireable;

class StudentDetailDTO implements Wireable {
    public function __construct(
        public string  $id,
        public string  $name,
        public string  $email,
        public ?string $avatar,
        public string  $phone,
        public string  $studentType,
        public bool    $isInternalStudent,

        public string  $studentCode,
        public string  $genderLabel,
        public string  $dob,
        public string  $status,
        public string  $statusLabel,
        public string  $statusColor,
        public string  $enrollmentYear,

        public string  $classRoomCode,
        public string  $classRoomName,
        public string  $majorCode,
        public string  $majorName,
        public string  $facultyCode,
        public string  $facultyName,
        public string  $studentTypeLabel,

        public array   $stats = [],
    ) {}

    public static function fromModel(User $student): self
    {
        $profile = $student->studentProfile;

        $statusLabels = $student->getAvailableStatuses();
        $statusLabel = $statusLabels[$student->status] ?? ucfirst($student->status);

        $statusColor = match ($student->status) {
            User::STATUS_ACTIVE => 'success',
            User::STATUS_SUSPENDED => 'danger',
            StudentProfile::STATUS_PROBATION => 'warning',
            StudentProfile::STATUS_DROPPED => 'dark',
            StudentProfile::STATUS_GRADUATED => 'info',
            default => 'secondary'
        };

        return new self(
            id: $student->id,
            name: $student->name,
            email: $student->email,
            avatar: $student->getAvatarPath(),
            phone: $student->phone ?? 'N/A',
            studentType: $profile?->student_type ?? 'N/A',
            isInternalStudent: ($profile?->student_type === 'internal'),

            studentCode: $profile?->student_code ?? 'N/A',
            genderLabel: $profile->genderLabel,
            dob: $profile->dobFormatted,
            status: $student->status,
            statusLabel: $statusLabel,
            statusColor: $statusColor,
            enrollmentYear: $profile?->enrollment_year ? Carbon::parse($profile->enrollment_year)->format('Y') : 'N/A',

            classRoomCode: $profile?->classRoom?->code ?? 'N/A',
            classRoomName: $profile?->classRoom?->name ?? 'Chưa xếp lớp',
            majorCode: $profile?->major?->code ?? 'N/A',
            majorName: $profile?->major?->name ?? 'N/A',
            facultyCode: $profile?->major?->faculty?->code ?? 'N/A',
            facultyName: $profile?->major?->faculty?->name ?? 'N/A',
            studentTypeLabel: $profile?->student_type === 'internal' ? 'Chính quy' : 'Liên kết',

            stats: [
                'enrolled' => $profile?->enrolled_count ?? 0,
                'completed' => $profile?->completed_count ?? 0,
            ]
        );
    }

    public function toLivewire(): array
    {
        return get_object_vars($this);
    }

    public static function fromLivewire($value): StudentDetailDTO
    {
        return new self(...$value);
    }
}
