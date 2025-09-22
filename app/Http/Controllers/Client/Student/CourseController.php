<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Base\BaseCourseController;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class CourseController extends BaseCourseController
{
    use AuthorizesRequests;

    public function index(Course $course): RedirectResponse
    {
        try {
            $this->authorize('access', $course);
            return redirect()->route('course.learn.lesson', [
                'course' => $course->slug,
                'id' => $this->courseService->getLesson($course)
            ]);
        } catch (AuthorizationException $e) {
            return redirect()->route('page.forbidden');
        }
    }

    public function showLesson(Course $course, string $id)
    {
        try {
            $this->authorize('access', $course);
            $lesson = Lesson::findOrFail($id);
            $routes = $this->courseService->getNavigationRoutes($course, $lesson);

            return view('lesson.index', [
                'course' => $course,
                'lesson' => $lesson,
                'prevRoute' => $routes['prev'],
                'nextRoute' => $routes['next'],
            ]);
        } catch (AuthorizationException $e) {
            return redirect()->route('page.forbidden');
        }
    }
}
