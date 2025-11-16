<?php

namespace App\Repositories;

use App\Models\Faculty;
use App\Models\Major;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AcademicRepository {
    public const CACHE_KEY_ALL = 'faculties_with_majors';
    public const CACHE_KEY_FACULTIES_ONLY = 'faculties_only';
    public const CACHE_KEY_MAJORS_ONLY = 'majors_only';

    protected int $cacheTime = 86400;

    public function getCachedFacultiesWithMajors(): Collection
    {
        return Cache::remember(self::CACHE_KEY_ALL, $this->cacheTime, function () {
            return Faculty::with('majors')->get();
        });
    }

    public function getCachedFacultiesOnly(): Collection
    {
        return Cache::remember(self::CACHE_KEY_FACULTIES_ONLY, $this->cacheTime, function () {
            return Faculty::all();
        });
    }

    public function getCachedMajorsOnly(): Collection
    {
        return Cache::remember(self::CACHE_KEY_MAJORS_ONLY, $this->cacheTime, function () {
            return Major::all();
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
