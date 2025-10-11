<?php

namespace App\View\Components\Client\Dashboard;

use App\Models\User;
use App\Services\Instructor\InstructorService;
use App\Services\Student\StudentService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BannerTop extends Component
{
    public User $user;
	public string $role;
	public string $backgroundClass;
	public ?string $courseCreateRoute = null;

	public function __construct()
	{
        $this->user = auth()->user();
        $this->role = $this->user->role;

        if ($this->role === 'student') {
            $studentService = app(StudentService::class);
            $this->user = $studentService->prepareDetails($this->user);
        } elseif ($this->role === 'instructor') {
            $instructorService = app(InstructorService::class);
            $this->user = $instructorService->prepareDetails($this->user);
        }

		$roleSettings = [
			'instructor' => [
				'background' => 'bg_image--14',
				'route' => 'instructor.courses.create',
			],
			'organization' => [
				'background' => 'bg_image--11',
				'route' => 'organization.courses.create',
			],
            'student' => [
                'background' => 'bg_image--12',
                'route' => null,
            ],
		];

        $settings = $roleSettings[$this->role];

		$this->backgroundClass = $settings['background'];
		$routeName = $settings['route'];
		$this->courseCreateRoute = $routeName ? route($routeName) : null;
	}

	public function render(): View|Closure|string
	{
		return view('components.client.dashboard.banner-top');
	}
}
