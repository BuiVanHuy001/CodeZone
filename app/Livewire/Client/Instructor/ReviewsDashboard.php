<?php

namespace App\Livewire\Client\Instructor;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Reviews')]
class ReviewsDashboard extends Component
{
    #[Layout('components.layouts.client-dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.instructor.reviews-dashboard');
    }
}
