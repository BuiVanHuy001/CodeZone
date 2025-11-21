<?php

namespace App\Livewire\Admin\Academic\Components\Faculty;

use App\Models\Faculty;
use App\Services\Admin\Faculty\FacultyService;
use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Rule;

class DeleteFaculty extends Component {
    public ?Faculty $faculty = null;
    public Collection $targetFaculties;
    public int $majorsCount = 0;

    #[Rule('required|exists:faculties,id')]
    public ?int $targetFacultyId = null;

    public function mount(): void
    {
        $this->targetFaculties = collect();
    }

    #[On('init-delete-faculty')]
    public function initDelete(string|int $id): void
    {
        $this->reset(['faculty', 'targetFaculties', 'majorsCount', 'targetFacultyId']);
        $this->faculty = app(FacultyService::class)->getById($id);

        if (!$this->faculty) {
            $this->swalError('Lỗi', 'Khoa không tồn tại hoặc đã bị xóa.');
            return;
        }


        $this->majorsCount = $this->faculty->majors_count;

        if ($this->majorsCount === 0) {
            $this->dispatch('swal-confirm-delete-empty', id: $id);
            return;
        }

        $this->targetFaculties = AcademicCache::getCachedFacultiesOnly()
                                              ->where('id', '!=', $id)
                                              ->values();

        if ($this->targetFaculties->isEmpty()) {
            $this->swalError('Không thể xóa!', 'Đây là khoa duy nhất. Bạn không thể chuyển ngành đi đâu cả.');
            return;
        }

        $this->dispatch('open-delete-faculty-modal');
    }

    public function confirmDeleteWithMigration(): void
    {
        $this->validate();

        try {
            app(FacultyService::class)->transferAndDelete($this->faculty->id, $this->targetFacultyId);
            $this->dispatch('close-modal', modalId: '#delete-faculty-modal');
            $this->dispatch('faculty-updated');

            $this->swal('Thành công!',
                "Đã chuyển {$this->majorsCount} ngành sang khoa mới và xóa khoa cũ.");
            $this->reset(['faculty', 'targetFaculties', 'majorsCount', 'targetFacultyId']);
        } catch (\Exception $e) {
            $this->swal('Lỗi!', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    #[On('delete-empty-faculty-confirmed')]
    public function deleteEmptyFaculty(int $id): void
    {
        $deleted = $this->facultyService->delete($id);
        if ($deleted) {
            $this->reset(['faculty', 'targetFaculties', 'majorsCount', 'targetFacultyId']);
            $this->dispatch('faculty-updated');
            $this->swal('Thành công', 'Khoa đã được xóa thành công.');
        } else {
            $this->swalError('Lỗi', 'Xóa khoa không thành công. Vui lòng thử lại.');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.faculty.delete-faculty');
    }
}
