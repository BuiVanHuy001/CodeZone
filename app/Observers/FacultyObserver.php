<?php

namespace App\Observers;

use App\Models\Faculty;
use App\Services\Cache\AcademicCache;

class FacultyObserver {
    public function created(Faculty $faculty): void
    {
        AcademicCache::clearCache();
    }

    public function updated(Faculty $faculty): void
    {
        AcademicCache::clearCache();
    }

    public function deleted(Faculty $faculty): void
    {
        AcademicCache::clearCache();
    }

    public function restored(Faculty $faculty): void
    {
        AcademicCache::clearCache();
    }

    public function forceDeleted(Faculty $faculty): void
    {
        AcademicCache::clearCache();
    }
}
