<?php

namespace App\Observers;

use App\Models\StudentProfile;
use App\Services\Cache\AcademicCache;

class StudentProfileObserver {
    /**
     * Handle the StudentProfile "created" event.
     */
    public function created(StudentProfile $studentProfile): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the StudentProfile "updated" event.
     */
    public function updated(StudentProfile $studentProfile): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the StudentProfile "deleted" event.
     */
    public function deleted(StudentProfile $studentProfile): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the StudentProfile "restored" event.
     */
    public function restored(StudentProfile $studentProfile): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the StudentProfile "force deleted" event.
     */
    public function forceDeleted(StudentProfile $studentProfile): void
    {
        AcademicCache::clearCache();
    }
}

