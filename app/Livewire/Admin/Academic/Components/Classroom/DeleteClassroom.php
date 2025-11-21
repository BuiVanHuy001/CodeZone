<?php

namespace App\Livewire\Admin\Academic\Components\Classroom;

use App\Models\ClassRoom;
use App\Services\Admin\Classroom\ClassroomService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class DeleteClassroom extends Component {
    public ?ClassRoom $classroom = null;
    public Collection $targetClassrooms;
    public int $studentCount = 0;

    #[Rule('required|exists:class_rooms,id')]
    public ?int $targetClassId = null;

    protected ClassroomService $classroomService;

    public function boot(ClassroomService $classroomService): void
    {
        $this->classroomService = $classroomService;
    }

    public function mount(): void
    {
        $this->targetClassrooms = collect();
    }

    #[On('init-delete-classroom')]
    public function initDelete(int $id): void
    {
        $this->reset(['classroom', 'targetClassrooms', 'studentCount', 'targetClassId']);

        $this->classroom = ClassRoom::withCount('studentProfiles')->find($id);

        if (!$this->classroom) {
            $this->dispatch('swal', ['title' => 'Lỗi', 'text' => 'Lớp học không tồn tại.', 'icon' => 'error']);
            return;
        }

        $this->studentCount = $this->classroom->student_profiles_count;

        if ($this->studentCount === 0) {
            $this->dispatch('swal-confirm-delete-empty-classroom', id: $id);
            return;
        }

        $this->targetClassrooms = $this->classroomService
            ->getTransferableClasses($this->classroom->id, $this->classroom->major_id);

        if ($this->targetClassrooms->isEmpty()) {
            $this->dispatch('swal', [
                'title' => 'Không thể xóa!',
                'text' => 'Đây là lớp duy nhất của ngành này. Bạn không thể chuyển sinh viên đi đâu cả.',
                'icon' => 'error'
            ]);
            return;
        }

        $this->dispatch('open-delete-classroom-modal');
    }

    public function confirmDeleteWithMigration(): void
    {
        $this->validate();

        try {
            $this->classroomService->transferAndDelete($this->classroom->id, $this->targetClassId);
            $this->reset();

            $this->dispatch('close-modal', modalId: '#delete-classroom-modal');
            $this->dispatch('faculty-updated');
            $this->swal('Thành công', "Đã chuyển {$this->studentCount} sinh viên sang lớp mới và xóa lớp cũ.");
        } catch (\Exception $e) {
            $this->swalError('Lỗi', $e->getMessage());
        }
    }

    #[On('delete-empty-classroom-confirmed')]
    public function deleteEmptyClassroom(int $id): void
    {
        if ($this->classroomService->delete($id)) {
            $this->reset();
            $this->dispatch('faculty-updated');
            $this->swal('Thành công', 'Đã xóa.');
        } else {
            $this->swalError('Lỗi', 'Không thể xóa.');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.classroom.delete-classroom');
    }
}
