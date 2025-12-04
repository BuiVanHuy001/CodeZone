<?php

namespace App\Services\Admin\Student;

use App\Models\User;
use App\Traits\HasNumberFormat;

class StudentPreparation {
    use HasNumberFormat;
    public function getSummaryData(User $student): array
    {
        $profile = $student->studentProfile;

        return [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'avatar' => $student->getAvatarPath(),

            'student_code' => $profile?->student_code ?? 'N/A',
            'gender_text' => match ($profile?->gender) {
                1, true => 'Nam',
                0, false => 'Nữ',
                default => '--'
            },
            'dob_text' => $profile?->dob?->format('d/m/Y') ?? 'N/A',
            'status' => $student->status,
        ];
    }
}
