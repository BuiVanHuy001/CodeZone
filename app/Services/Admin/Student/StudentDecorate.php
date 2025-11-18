<?php

namespace App\Services\Admin\Student;

use App\Models\User;
use App\Traits\HasNumberFormat;

class StudentDecorate {
    use HasNumberFormat;

    public function decorateData(User $student): void
    {
        $student->createdAtText = $student->created_at?->diffForHumans() ?? 'N/A';
        $student->updatedAtText = $student->updated_at?->diffForHumans() ?? 'N/A';
        $student->avatar = $student->getAvatarPath();

        $profile = $student->studentProfile;

        $student->dobText = $profile?->dob?->format('d/m/Y') ?? 'N/A';
        $student->studentCodeText = $profile?->student_code ?? 'N/A';
        $student->genderText = $profile?->gender ? 'Female' : 'Male';
        $student->majorNameText = $profile?->major?->name ?? 'N/A';
        $student->majorCodeText = $profile?->major?->code ?? 'N/A';
        $student->facultyNameText = $profile?->major?->faculty?->name ?? 'N/A';
        $student->facultyCodeText = $profile?->major?->faculty?->code ?? 'N/A';
        $student->classRoomNameText = $profile?->classRoom?->name ?? 'N/A';
        $student->classRoomCodeText = $profile?->classRoom?->code ?? 'N/A';
        $student->enrollmentYearText = $profile?->enrollment_year
            ? date('Y', strtotime($profile->enrollment_year))
            : 'N/A';
        $student->enrolledCountText = $this->formatCount(
            $profile?->enrolled_count ?? 0,
            'course'
        );
    }
}
