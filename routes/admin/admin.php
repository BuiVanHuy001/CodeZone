<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Livewire\Admin\Academic\Classroom\Index as ClassroomIndex;
use App\Livewire\Admin\Academic\Faculty\Index as FacultyIndex;
use App\Livewire\Admin\Academic\Major\Index as MajorIndex;
use App\Livewire\Admin\Courses\Index as CoursesIndex;
use App\Livewire\Admin\Overview\Index as OverviewIndex;
use App\Livewire\Admin\Instructor\Index as InstructorIndex;
use App\Livewire\Admin\Student\Index as StudentsIndex;
use \Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsAdmin::class)->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/overview', OverviewIndex::class)->name('admin.overview.index');
        Route::get('/courses', CoursesIndex::class)->name('admin.courses.index');
        Route::get('/instructors', InstructorIndex::class)->name('admin.instructors.index');
        Route::get('/students', StudentsIndex::class)->name('admin.students.index');
        Route::get('/faculties', FacultyIndex::class)->name('admin.faculties.index');
        Route::get('/majors', MajorIndex::class)->name('admin.majors.index');
        Route::get('/classrooms', ClassroomIndex::class)->name('admin.classrooms.index');
    });
});
