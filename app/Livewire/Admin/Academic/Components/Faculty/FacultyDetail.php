<?php

namespace App\Livewire\Admin\Academic\Components\Faculty;

use App\Models\Faculty;
use App\Services\Admin\Faculty\FacultyService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class FacultyDetail extends Component {
    public ?Faculty $faculty = null;
    public Collection $instructors;

    #[On('view-details')]
    public function loadFaculty(int $id): void
    {
        $this->faculty = app(FacultyService::class)->getById($id);

        if ($this->faculty) {
            $this->instructors = $this->faculty->instructors->load(['instructor', 'major'])->map(
                function ($instructor) {
                    $instructor->name = $instructor->instructor->name;
                    $instructor->avatar = $instructor->instructor->getAvatarPath();
                    $instructor->email = $instructor->instructor->email;
                    $instructor->majorName = $instructor->major->name;
                    return $instructor;
                }
            );
            $this->dispatch('open-modal', id: 'facultyDetailModal');
        } else {
            $this->swalError('Lỗi', 'Khoa không tồn tại hoặc đã bị xóa.');
        }

    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.faculty.faculty-detail');
    }
}
