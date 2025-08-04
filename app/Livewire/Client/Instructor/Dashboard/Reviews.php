<?php

namespace App\Livewire\Client\Instructor\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Reviews')]
class Reviews extends Component
{
	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
	    return view('livewire.client.instructor.dashboard.reviews');
    }
}
