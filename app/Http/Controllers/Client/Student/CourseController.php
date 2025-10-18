<?php

namespace App\Http\Controllers\Client\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\Course\CourseService;
use App\Services\Course\LearningService;
use App\Support\CourseFilter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    protected LearningService $learningService;
    protected CourseService $courseService;

    public function __construct()
    {
        $this->learningService = app(LearningService::class);
        $this->courseService = app(CourseService::class);
    }

    public function show(string $slug): View|Application|Factory
    {
        $course = $this->courseService->prepareDataForCourseDetails($slug);

        if (!$course) {
            return view('client.errors.404');
        }

        return view('client.pages.course-details', [
            'course' => $course,
            'canAccess' => Gate::allows('access', $course),
        ]);
    }

    public function index(Request $request): View|Application|Factory
    {
        $data = $this->courseService->prepareDataForCourseList($request);

        return view('client.pages.course-list', [
            'courses' => $data['courses'],
            'instructors' => $data['instructors'],
            'categories' => $data['categories'],
            'shortByOptions' => CourseFilter::$shortByOptions,
            'offsetOptions' => CourseFilter::$offerOptions,
        ]);
    }

    public function learn(string $slug): View|RedirectResponse
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        if (!$course) {
            return view('client.errors.404');
        }
        if (Gate::allows('access', $course)) {
            return redirect()->route('course.learn.lesson', [
                'slug' => $course->slug,
                'id' => $this->learningService->getLesson($course)
            ]);
        }

        return redirect()->route('page.course_detail', ['slug' => $course->slug]);
    }

    public function showLesson(string $slug, string $id)
    {
        $course = Course::where('slug', $slug)
            ->with([
                'modules' => fn($q) => $q->orderBy('position'),
                'modules.lessons' => function ($query) {
                    $query->orderBy('position')
                        ->with([
                            'assessment',
                            'trackingProgresses' => fn($q) => $q->where('user_id', auth()->id())
                        ]);
                },
                'modules.lessons.assessment',
                'modules.lessons.trackingProgresses' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->first();

        $lesson = Lesson::find($id);

        if (!$course || !$lesson) {
            return view('client.errors.404');
        }

        if (Gate::allows('access', $course)) {
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
