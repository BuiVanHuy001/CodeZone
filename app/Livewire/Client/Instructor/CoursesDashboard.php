<?php

namespace App\Livewire\Client\Instructor;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Courses')]
class CoursesDashboard extends Component
{
    public $courses;

    public function mount()
    {
        $this->courses = auth()->user()->courses()->with('category')->get();
    }

    public function render()
    {
        return view('livewire.client.instructor.courses-dashboard');
    }
}
