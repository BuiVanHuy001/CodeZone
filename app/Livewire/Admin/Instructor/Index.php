<?php

namespace App\Livewire\Admin\Instructor;

use App\Models\User;
use App\Models\Faculty;

// Giả sử bạn có model này
use App\Models\Major;

// Giả sử bạn có model này
use App\Services\Admin\Instructor\InstructorService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Quản lý giảng viên')]
class Index extends Component {
    use WithSwal, WithPagination;

    public int $perPage = 10;
    public $searchActive = '';
    public $selectedFaculty = '';
    public $selectedMajor = '';
    public $sortField = 'created_at';

    public $searchPending = '';
    public $searchSuspended = '';

    private InstructorService $adminInstructorService;

    public function boot(InstructorService $service): void
    {
        $this->adminInstructorService = $service;
    }

    public function updatedSearchActive(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedFaculty(): void
    {
        $this->selectedMajor = '';
        $this->resetPage();
    }

    public function updatedSelectedMajor(): void
    {
        $this->resetPage();
    }

    public function suspend(string|int $instructorId): void
    {
        if ($this->adminInstructorService->suspendInstructor($instructorId)) {
            $this->swal('Instructor suspended successfully.');
            $this->dispatch('instructor-updated');
        } else {
            $this->swalError('Failed to suspend instructor.');
        }
    }

    public function approve(string|int $instructorId): void
    {
        if ($this->adminInstructorService->approveInstructor($instructorId)) {
            $this->swal('Instructor approved successfully.');
            $this->dispatch('instructor-updated');
        } else {
            $this->swalError('Failed to approve instructor.');
        }
    }

    public function reject(string|int $instructorId): void
    {
        if ($this->adminInstructorService->rejectInstructor($instructorId)) {
            $this->swal('Instructor rejected successfully.');
            $this->dispatch('instructor-updated');
        } else {
            $this->swalError('Failed to reject instructor.');
        }
    }

    public function restore(string|int $instructorId): void
    {
        if ($this->adminInstructorService->restoreInstructor($instructorId)) {
            $this->swal('Instructor restored successfully.');
            $this->dispatch('instructor-updated');
        } else {
            $this->swalError('Failed to restore instructor.');
        }
    }

    public function render(): View
    {
        $activeFilters = [
            'search' => $this->searchActive,
            'faculty_id' => $this->selectedFaculty,
            'major_id' => $this->selectedMajor,
            'sort' => $this->sortField
        ];

        $instructors = [
            'active' => $this->adminInstructorService->getInstructorsByStatus('active', $activeFilters),
            'pending' => $this->adminInstructorService->getInstructorsByStatus('pending', ['search' => $this->searchPending]),
            'suspended' => $this->adminInstructorService->getInstructorsByStatus('suspended', ['search' => $this->searchSuspended]),
        ];

        $stats = [
            'active' => User::role('instructor')->where('status', 'active')->count(),
            'pending' => User::role('instructor')->where('status', 'pending')->count(),
            'suspended' => User::role('instructor')->where('status', 'suspended')->count(),
        ];

        $faculties = class_exists(Faculty::class) ? Faculty::all() : [];
        $majors = (!empty($this->selectedFaculty) && class_exists(Major::class))
            ? Major::where('faculty_id', $this->selectedFaculty)->get()
            : [];

        return view('livewire.admin.instructor.index', compact('instructors', 'stats', 'faculties', 'majors'))
            ->layout('components.layouts.admin-dashboard');
    }
}
