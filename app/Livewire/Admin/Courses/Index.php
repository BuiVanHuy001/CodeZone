<?php

namespace App\Livewire\Admin\Courses;

use App\Services\Course\AdminCourseService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Courses')]
class Index extends Component
{
    private AdminCourseService $adminCourseService;

    public array $gridData = [];

    public function boot(): void
    {
        $this->adminCourseService = app(AdminCourseService::class);
    }

    public function mount(): void
    {
        $this->gridData = $this->adminCourseService->prepareDataForCourseList();
    }

    public function render(): View
    {
        return view('livewire.admin.courses.index')->layout('components.layouts.admin-dashboard');
    }
}
