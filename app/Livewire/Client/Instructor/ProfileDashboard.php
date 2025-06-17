<?php

namespace App\Livewire\Client\Instructor;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Profile')]
class ProfileDashboard extends Component
{
    public function render()
    {
        return view('livewire.client.instructor.profile-dashboard');
    }
}
