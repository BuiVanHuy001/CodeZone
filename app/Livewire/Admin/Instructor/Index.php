<?php

namespace App\Livewire\Admin\Instructor;

use App\Models\User;
use App\Services\Instructor\AdminInstructorService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class Index extends Component {
    use WithFileUploads;

    public array $instructors;
    public $avatar;

    public function boot(): void
    {
        $adminInstructorService = app(AdminInstructorService::class);
        foreach (User::$STATUSES as $status) {
            $this->instructors[$status] = $adminInstructorService->getInstructorsByStatus($status);
        }
    }

    public function suspend(string|int $instructorId): void
    {
        $instructor = Role::findByName('instructor')->users()->where([
            'id' => $instructorId,
            'status' => 'active',
        ])->firstOrFail();
        if ($instructor) {
            app(AdminInstructorService::class)->suspendInstructor($instructorId);
        } else {
            //            $this->dispatch('')
        }
    }

    public function render(): View
    {
        return view('livewire.admin.instructor.index')->layout('components.layouts.admin-dashboard');
    }
}
