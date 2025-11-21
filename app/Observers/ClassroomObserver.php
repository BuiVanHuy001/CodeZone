<?php

namespace App\Observers;

use App\Models\ClassRoom;
use App\Services\Cache\AcademicCache;

class ClassroomObserver {
    /**
     * Handle the ClassRoom "created" event.
     */
    public function created(ClassRoom $classRoom): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the ClassRoom "updated" event.
     */
    public function updated(ClassRoom $classRoom): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the ClassRoom "deleted" event.
     */
    public function deleted(ClassRoom $classRoom): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the ClassRoom "restored" event.
     */
    public function restored(ClassRoom $classRoom): void
    {
        AcademicCache::clearCache();
    }

    /**
     * Handle the ClassRoom "force deleted" event.
     */
    public function forceDeleted(ClassRoom $classRoom): void
    {
        AcademicCache::clearCache();
    }
}
