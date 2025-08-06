<?php

namespace App\View\Components\Client\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BannerTop extends Component
{
	public string $role;
	public string $backgroundClass;
	public ?string $courseCreateRoute = null;

	public function __construct()
	{
		$this->role = auth()->user()->role;

		$roleSettings = [
			'instructor' => [
				'background' => 'bg_image--14',
				'route' => 'instructor.courses.create',
			],
			'organization' => [
				'background' => 'bg_image--11',
				'route' => 'business.courses.create',
			],
		];

		$defaultSettings = [
			'background' => 'bg_image--12',
			'route' => null
		];

		$settings = $roleSettings[$this->role] ?? $defaultSettings;

		$this->backgroundClass = $settings['background'];
		$routeName = $settings['route'];
		$this->courseCreateRoute = $routeName ? route($routeName) : null;
	}

	public function render(): View|Closure|string
	{
		return view('components.client.dashboard.banner-top');
	}
}
