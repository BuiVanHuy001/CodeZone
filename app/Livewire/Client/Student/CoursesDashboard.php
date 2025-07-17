<?php

namespace App\Livewire\Client\Student;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CoursesDashboard extends Component {
    public $courses = [];

    public function mount()
    {
        foreach (auth()->user()->batchEnrollments as $enrollment) {
            $this->courses[] = $enrollment->batch->course;
        }
    }

    #[Layout('components.layouts.client-dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.courses-dashboard');
    }
}
