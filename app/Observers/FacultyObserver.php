<?php

namespace App\Observers;

use App\Models\Faculty;
use App\Repositories\AcademicRepository;

class FacultyObserver {
    public function created(Faculty $faculty): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Faculty "updated" event.
     */
    public function updated(Faculty $faculty): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Faculty "deleted" event.
     */
    public function deleted(Faculty $faculty): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Faculty "restored" event.
     */
    public function restored(Faculty $faculty): void
    {
        AcademicRepository::clearCache();
    }

    /**
     * Handle the Faculty "force deleted" event.
     */
    public function forceDeleted(Faculty $faculty): void
    {
        AcademicRepository::clearCache();
    }
}
