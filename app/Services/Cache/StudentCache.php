<?php

namespace App\Services\Cache;

use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class StudentCache {
    public static function getExistingEmails()
    {
        return Cache::remember('existing_student_emails', 86400, function () {
            return User::pluck('email')->flip()->all();
        });
    }

    public static function getExistingStudentCodes()
    {
        return Cache::remember('existing_student_codes', 86400, function () {
            return StudentProfile::whereNotNull('student_code')->pluck('student_code')->flip()->all();
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('existing_student_emails');
        Cache::forget('existing_student_codes');
    }

    public static function refreshCache(): void
    {
        self::clearCache();
        self::getExistingEmails();
        self::getExistingStudentCodes();
    }
}
