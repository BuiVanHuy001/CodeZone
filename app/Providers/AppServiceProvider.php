<?php

namespace App\Providers;

use App\Models\ClassRoom;
use App\Models\Faculty;
use App\Models\Major;
use App\Models\StudentProfile;
use App\Observers\ClassroomObserver;
use App\Observers\FacultyObserver;
use App\Observers\MajorObserver;
use App\Observers\StudentProfileObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Faculty::observe(FacultyObserver::class);
        Major::observe(MajorObserver::class);
        ClassRoom::observe(ClassroomObserver::class);
        StudentProfile::observe(StudentProfileObserver::class);
    }
}
