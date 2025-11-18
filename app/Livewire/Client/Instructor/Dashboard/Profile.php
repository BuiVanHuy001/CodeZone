<?php

namespace App\Livewire\Client\Instructor\Dashboard;

use App\Models\User;
use App\Services\Client\Instructor\InstructorService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Profile')]
class Profile extends Component
{
    private InstructorService $instructorService;
    public User $instructor;

    public function boot(): void
    {
        $this->instructorService = app(InstructorService::class);
    }

    public function mount(): void
    {
        $this->instructor = $this->instructorService->prepareDetails(auth()->user());
    }
	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
	    return view('livewire.client.instructor.dashboard.profile');
    }
}
