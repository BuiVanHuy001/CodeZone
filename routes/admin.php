<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Admin\{
        HandleViewController,
        InstructorController,
        CourseController,
        StudentController,
        BlogController
    };

    Route::prefix('/admin')->middleware('check.user.is.admin')->group(function(){
        Route::get('/', [HandleViewController::class, 'dashboard'])->name('admin.dashboard');
        Route::resources([
            '/instructor' => InstructorController::class,
            '/student' => StudentController::class,
            '/course' => CourseController::class,
            '/blog' => BlogController::class
        ], ['as' => 'admin']);
        Route::post('/update-course-status/{id}', [CourseController::class, 'updateStatus'])->name('admin.update-course-status');
        Route::post('/update-blog-status/{id}', [BlogController::class, 'updateStatus'])->name('admin.update-blog-status');
        Route::post('/update-instructor-status/{id}', [InstructorController::class, 'updateStatus'])->name('admin.update-instructor-status');
        Route::post('/update-student-status/{id}', [StudentController::class, 'updateStatus'])->name('admin.update-student-status');
    });
//    Route::middleware('check.user.is.admin')->group(function(){
//    });

