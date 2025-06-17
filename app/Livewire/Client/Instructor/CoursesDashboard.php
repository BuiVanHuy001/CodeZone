<?php

namespace App\Livewire\Client\Instructor;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Courses')]
class CoursesDashboard extends Component
{
    public function render()
    {
        return view('livewire.client.instructor.courses-dashboard');
    }
}
