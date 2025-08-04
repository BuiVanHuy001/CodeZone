<?php

namespace App\Livewire\Client\Student\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Courses extends Component
{
    public $courses = [];

    public function mount(): void
    {
        foreach (auth()->user()->batchEnrollments as $enrollment) {
            $this->courses[] = $enrollment->batch->course;
        }
    }

	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.dashboard.courses');
    }
}
