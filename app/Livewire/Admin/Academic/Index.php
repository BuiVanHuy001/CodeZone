<?php

namespace App\Livewire\Admin\Academic;

use App\Services\Admin\Classroom\ClassroomService;
use App\Services\Cache\AcademicCache;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component {
    public Collection $faculties;
    public Collection $majors;
    public Collection $classrooms;

    public function mount(): void
    {
        $this->loadFaculties();
    }

    #[On('faculty-created')]
    #[On('faculty-updated')]
    public function loadFaculties(): void
    {
        $this->faculties = AcademicCache::getCachedFacultiesWithMajors();
        $this->majors = AcademicCache::getCachedMajorsOnly();
        $this->classrooms = app(ClassroomService::class)->getAll();
    }

    public function render(): View
    {
        return view('livewire.admin.academic.index')
            ->layout('components.layouts.admin-dashboard');
    }
}
