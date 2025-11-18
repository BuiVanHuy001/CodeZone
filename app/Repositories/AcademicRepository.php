<?php

namespace App\Repositories;

use App\Models\ClassRoom;
use App\Models\Faculty;
use App\Models\Major;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AcademicRepository {
    private const CACHE_KEY_ALL = 'faculties_with_majors';
    private const CACHE_KEY_FACULTIES_ONLY = 'faculties_only';
    private const CACHE_KEY_MAJORS_ONLY = 'majors_only';
    private const CACHE_KEY_CLASSROOM = 'classrooms';

    protected static int $cacheTime = 86400;

    public static function getCachedFacultiesWithMajors(): Collection
    {
        return Cache::remember(self::CACHE_KEY_ALL, self::$cacheTime, function () {
            return Faculty::with('majors')->get();
        });
    }

    public static function getCachedFacultiesOnly(): Collection
    {
        return Cache::remember(self::CACHE_KEY_FACULTIES_ONLY, self::$cacheTime, function () {
            return Faculty::all();
        });
    }

    public static function getCachedMajorsOnly(): Collection
    {
        return Cache::remember(self::CACHE_KEY_MAJORS_ONLY, self::$cacheTime, function () {
            return Major::all();
        });
    }

    public static function getCachedClassroom()
    {
        return Cache::remember(self::CACHE_KEY_CLASSROOM, self::$cacheTime, function () {
            return ClassRoom::all();
        });
    }

    public static function clearFacultyCache(): void
    {
        Cache::forget(self::CACHE_KEY_ALL);
        Cache::forget(self::CACHE_KEY_FACULTIES_ONLY);
    }

    public static function clearMajorCache(): void
    {
        Cache::forget(self::CACHE_KEY_ALL);
        Cache::forget(self::CACHE_KEY_MAJORS_ONLY);
    }

    public static function clearCache(): void
    {
        self::clearFacultyCache();
        self::clearMajorCache();
    }
}
