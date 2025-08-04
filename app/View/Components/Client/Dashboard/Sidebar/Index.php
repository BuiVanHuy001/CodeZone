<?php

namespace App\View\Components\Client\Dashboard\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Index extends Component
{
	/**
     * Create a new components instance.
	 */
	public function __construct()
	{
		//
	}

	/**
     * Get the view / contents that represent the components.
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
