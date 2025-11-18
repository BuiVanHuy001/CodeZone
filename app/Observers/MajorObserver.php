<?php

namespace App\Observers;

use App\Models\Major;
use App\Repositories\AcademicRepository;

class MajorObserver {
    /**
     * Handle the Major "created" event.
     */
    public function created(Major $major): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Major "updated" event.
     */
    public function updated(Major $major): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Major "deleted" event.
     */
    public function deleted(Major $major): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Major "restored" event.
     */
    public function restored(Major $major): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Major "force deleted" event.
     */
    public function forceDeleted(Major $major): void
    {
        AcademicRepository::clearCache();
    }
}
