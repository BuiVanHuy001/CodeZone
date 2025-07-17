<?php

namespace App\Livewire\Client\Business;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CoursesDashboard extends Component {
	public $courses;

	public function mount()
	{
		$this->courses = auth()
			->user()->courses()
			->with(['batches', 'category'])
			->orderBy('created_at', 'desc')
			->get();
	}

	#[Layout('components.layouts.client-dashboard')]
	public function render(): View|Application|Factory
	{
		return view('livewire.client.business.courses-dashboard');
	}
}
