<?php

namespace App\Livewire\Client\Instructor\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Courses')]
class Courses extends Component
{
    public $courses;

    public function mount(): void
    {
        $this->courses = auth()->user()->courses;
    }

	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
	    return view('livewire.client.instructor.dashboard.courses');
    }
}
