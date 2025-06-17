<?php

namespace App\Livewire\Client\Instructor;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Reviews')]
class ReviewsDashboard extends Component
{
    public function render()
    {
        return view('livewire.client.instructor.reviews-dashboard');
    }
}
