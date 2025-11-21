<?php

namespace App\Livewire\Admin\Academic\Components\Faculty;

use App\Models\Faculty;
use App\Services\Admin\Faculty\FacultyService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class FacultyDetail extends Component {
    public ?Faculty $faculty = null;

    #[On('view-faculty-details')]
    public function loadFaculty(int $id): void
    {

        $this->faculty = app(FacultyService::class)->getById($id);

        if ($this->faculty) {
            $this->dispatch('open-faculty-detail-modal');
        } else {
            $this->swalError('Lỗi', 'Khoa không tồn tại hoặc đã bị xóa.');
        }

    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.faculty.faculty-detail');
    }
}
