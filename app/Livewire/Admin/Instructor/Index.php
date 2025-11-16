<?php

namespace App\Livewire\Admin\Instructor;

use App\Models\User;
use App\Services\Admin\Instructor\InstructorService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Index extends Component {
    use WithSwal;

    public array $instructors = [];
    private InstructorService $adminInstructorService;

    public function boot(): void
    {
        $this->adminInstructorService = app(InstructorService::class);
        foreach (User::$STATUSES as $status) {
            $this->instructors[$status] = $this->adminInstructorService->getInstructorsByStatus($status);
        }
    }

    public function loadInstructors(): void
    {
        foreach (User::$STATUSES as $status) {
            $this->instructors[$status] = $this->adminInstructorService->getInstructorsByStatus($status);
        }
        $this->dispatch('instructor-updated');
    }

    public function suspend(string|int $instructorId): void
    {
        $this->loadInstructors();
        if ($this->adminInstructorService->suspendInstructor($instructorId)) {
            $this->swal('Instructor suspended successfully.');
        } else {
            $this->swalError('Failed to suspend instructor. Please try again.');
        }
    }

    public function approve(string|int $instructorId): void
    {
        $this->loadInstructors();
        if ($this->adminInstructorService->approveInstructor($instructorId)) {
            $this->swal('Instructor approved successfully.');
        } else {
            $this->swalError('Failed to approve instructor. Please try again.');
        }
    }

    public function reject(string|int $instructorId): void
    {
        $this->loadInstructors();
        if ($this->adminInstructorService->rejectInstructor($instructorId)) {
            $this->swal('Instructor rejected successfully.');
        } else {
            $this->swalError('Failed to reject instructor. Please try again.');
        }
    }

    public function restore(string|int $instructorId): void
    {
        $this->loadInstructors();
        if ($this->adminInstructorService->restoreInstructor($instructorId)) {
            $this->swal('Instructor restored successfully.');
        } else {
            $this->swalError('Failed to restore instructor. Please try again.');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.instructor.index')->layout('components.layouts.admin-dashboard');
    }
}
