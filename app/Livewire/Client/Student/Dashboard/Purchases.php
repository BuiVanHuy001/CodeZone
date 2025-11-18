<?php

namespace App\Livewire\Client\Student\Dashboard;

use App\Services\Client\Student\StudentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Purchases extends Component
{
    public Collection $purchases;

    public function mount(StudentService $studentService): void
    {
        $this->purchases = $studentService->getPurchases();
    }

	#[Layout('components.layouts.dashboard')]
    public function render(): Factory|Application|View
    {
        return view('livewire.client.student.dashboard.purchases');
    }
}
