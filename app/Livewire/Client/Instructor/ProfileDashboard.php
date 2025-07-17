<?php

namespace App\Livewire\Client\Instructor;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Profile')]
class ProfileDashboard extends Component
{
    #[Layout('components.layouts.instructor-dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.instructor.profile-dashboard');
    }
}
