<?php

namespace App\View\Components\Client\Dashboard\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
	/**
	 * Create a new component instance.
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string
	{
		$role = auth()->user()->role;
		return match ($role) {
			'instructor' => view('components.client.dashboard.sidebar.instructor'),
			'organization' => view('components.client.dashboard.sidebar.business'),
			default => view('components.client.dashboard.sidebar.student'),
		};
	}
}
