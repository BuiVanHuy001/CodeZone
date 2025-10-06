<?php

namespace App\Livewire\Client\Student\Dashboard;

use App\Services\Student\StudentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Profile extends Component {
    public array $infos;

    public function mount(StudentService $studentService): void
    {
        $this->infos = $studentService->prepareProfile(auth()->user());
    }


    #[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.dashboard.profile');
    }
}
