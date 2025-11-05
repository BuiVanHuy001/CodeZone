<?php

namespace App\Livewire\Admin\Instructor;

use App\Models\User;
use App\Services\Instructor\AdminInstructorService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component
{
    public array $instructors;
    private AdminInstructorService $adminInstructorService;

    public function boot(): void
    {
        $this->adminInstructorService = app(AdminInstructorService::class);
    }

    public function mount(): void
    {
        foreach (User::$STATUSES as $status) {
            $this->instructors[$status] = $this->adminInstructorService->getInstructorsByStatus($status);
        }
    }

    public function render(): View
    {
        return view('livewire.admin.instructor.index')->layout('components.layouts.admin-dashboard');
    }
}
