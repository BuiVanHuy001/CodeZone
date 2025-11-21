<?php

namespace App\Services\Cache;

use App\Models\ClassRoom;
use App\Models\Faculty;
use App\Models\Major;
use App\Services\Admin\Student\StudentPreparation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AcademicCache {
    private const FACULTIES_WITH_MAJORS = 'faculties_with_majors';
    private const FACULTIES_ONLY = 'faculties_only';
    private const MAJORS_ONLY = 'majors_only';
    private const CLASSROOM = 'classrooms';
    private const CLASSROOM_LIST = 'classrooms_list';

    protected static int $cacheTime = 86400; // 24 hours in seconds

    public static function getCachedFacultiesWithMajors(): Collection
    {
        return Cache::remember(self::FACULTIES_WITH_MAJORS, self::$cacheTime, function () {
            return Faculty::with(['majors' => function ($query) {
                $query->withCount(['studentProfiles', 'instructorProfiles']);
            }])->withCount(['studentProfiles', 'instructorProfiles', 'majors'])
                          ->latest()
                          ->get();
        });
    }

    public static function getCachedFacultiesOnly(): Collection
    {
        return Cache::remember(self::FACULTIES_ONLY, self::$cacheTime, function () {
            return Faculty::all();
        });
    }

    public static function getCachedMajorsOnly(): Collection
    {
        return Cache::remember(self::MAJORS_ONLY, self::$cacheTime, function () {
            return Major::with([
                'faculty',
                'classRooms' => function ($query) {
                    $query->withCount('studentProfiles');
                }])->withCount(['studentProfiles', 'instructorProfiles', 'classRooms'])
                        ->latest()
                        ->get();
        });
    }

    public static function getCachedClassroom()
    {
        return Cache::remember(self::CLASSROOM, self::$cacheTime, function () {
            return ClassRoom::with(['major.faculty'])
                            ->withCount('studentProfiles')
                            ->latest()->get();
        });
    }

    public static function getCachedClassroomDetail(int $id): ?ClassRoom
    {
        $key = "classroom_detail_{$id}";

        return Cache::remember($key, self::$cacheTime, function () use ($id) {

            $classroom = ClassRoom::with([
                'major.faculty',
                'studentProfiles.user'
            ])->find($id);

            if (!$classroom) return null;

            $decorator = app(StudentPreparation::class);

            $studentsSummary = $classroom->studentProfiles->map(function ($profile) use ($decorator) {
                if ($profile->user) {
                    $profile->user->setRelation('studentProfile', $profile);
                    return $decorator->getSummaryData($profile->user);
                }
                return null;
            })->filter()->values()->toArray();

            $classroom->setAttribute('students_list', $studentsSummary);

            $classroom->unsetRelation('studentProfiles');

            return $classroom;
        });
    }

    public static function getCachedClassroomList(): Collection
    {
        return Cache::remember(self::CLASSROOM_LIST, self::$cacheTime, function () {
            return ClassRoom::with(['major.faculty'])
                            ->withCount('studentProfiles')
                            ->latest()
                            ->get();
        });
    }

    public static function clearClassroomCache(int $classroomId = null): void
    {
        Cache::forget(self::CLASSROOM_LIST);

        if ($classroomId) {
            Cache::forget("classroom_detail_{$classroomId}");
        }
    }

    public static function clearFacultyCache(): void
    {
        Cache::forget(self::FACULTIES_WITH_MAJORS);
        Cache::forget(self::FACULTIES_ONLY);
    }

    public static function clearMajorCache(): void
    {
        Cache::forget(self::FACULTIES_WITH_MAJORS);
        Cache::forget(self::MAJORS_ONLY);
    }

    public static function clearCache(): void
    {
        self::clearFacultyCache();
        self::clearMajorCache();
        self::clearClassroomCache();
    }
}
