<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Base\BaseCourseController;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class CourseController extends BaseCourseController
{
    use AuthorizesRequests;

    public function index(string $slug): View|RedirectResponse
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        if (!$course) {
            return view('client.errors.404');
        }
        if ($this->authorize('access', $course)->allowed()) {
            return redirect()->route('course.learn.lesson', [
                'slug' => $course->slug,
                'id' => $this->learningService->getLesson($course)
            ]);
        }

        return redirect()->route('page.course_detail', ['slug' => $course->slug]);
    }

    public function showLesson(string $slug, string $id)
    {
        $course = Course::where('slug', $slug)->first();
        $lesson = Lesson::find($id);

        if (!$course || !$lesson) {
            return view('client.errors.404');
        }

        if ($this->authorize('access', $course)->allowed()) {
            $routes = $this->learningService->getNavigationRoutes($course, $lesson);

            return view('lesson.index', [
                'course' => $course,
                'lesson' => $lesson,
                'prevRoute' => $routes['prev'],
                'nextRoute' => $routes['next'],
            ]);
        }

        return redirect()->route('page.course_detail', ['slug' => $course->slug]);
    }
}
