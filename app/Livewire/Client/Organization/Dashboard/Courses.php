<?php

namespace App\Livewire\Client\Organization\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Courses extends Component
{
	public $courses;

	public function mount(): void
	{
		$this->courses = auth()
			->user()->courses()
			->with(['batches', 'category'])
			->orderBy('created_at', 'desc')
			->get();
	}

	#[Layout('components.layouts.dashboard')]
	public function render(): View|Application|Factory
	{
		return view('livewire.client.organization.dashboard.courses');
	}
}
