<?php

namespace App\Livewire\Admin\Academic\Components\Classroom;

use App\Models\ClassRoom;
use App\Services\Admin\Classroom\ClassroomService;
use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class ClassroomDetail extends Component {
    public ?ClassRoom $classroom = null;
    public bool $isLoading = true;

    public array $transferableClasses = [];

    public bool $isAddingMode = false;
    public array $availableStudents = [];
    public array $selectedStudents = [];

    protected ClassroomService $classroomService;

    public function boot(ClassroomService $classroomService): void
    {
        $this->classroomService = $classroomService;
    }

    #[On('view-classroom-details')]
    public function loadClassroom(int|string $id): void
    {
        $this->isLoading = true;
        $this->resetAddingMode();

        $this->classroom = $this->classroomService->getById($id);

        if ($this->classroom) {
            $this->transferableClasses = $this->classroomService
                ->getTransferableClasses($this->classroom->id, $this->classroom->major_id)
                ->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'code' => $c->code])
                ->values()
                ->toArray();
        }

        $this->isLoading = false;
        $this->dispatch('open-classroom-detail-modal');
    }

    public function toggleAddMode(): void
    {
        $this->isAddingMode = !$this->isAddingMode;

        if ($this->isAddingMode && $this->classroom) {
            $this->availableStudents = $this->classroomService
                ->getStudentsForEnrollment($this->classroom->major_id, $this->classroom->id)
                ->toArray();
        }
    }

    public function addSelectedStudents(): void
    {
        if (empty($this->selectedStudents)) {
            $this->swal('Lỗi!', 'Vui lòng chọn ít nhất một sinh viên.', 'warning');
            return;
        }

        try {
            $this->classroomService->assignStudents($this->classroom->id, $this->selectedStudents);

            $this->refreshData();
            $this->resetAddingMode();

            $this->swal('Thành công!', 'Đã thêm sinh viên vào lớp.');
        } catch (\Exception $e) {
            $this->swalError('Lỗi', $e->getMessage());
        }
    }

    private function resetAddingMode(): void
    {
        $this->isAddingMode = false;
        $this->availableStudents = [];
        $this->selectedStudents = [];
    }

    public function removeStudent(string|int $studentProfileId): void
    {
        try {
            $this->classroomService->removeStudentFromClass($studentProfileId);
            $this->refreshData();

            $this->swal('Đã xóa khỏi lớp!');
        } catch (\Exception $e) {
            $this->swalError('Lỗi', $e->getMessage());
        }
    }

    public function transferStudent(string|int $studentProfileId, int $targetClassId): void
    {
        try {
            $this->classroomService->transferStudent($studentProfileId, $targetClassId);
            $this->refreshData();
            $this->swal('Thành công!', 'Đã chuyển sinh viên sang lớp khác.');
        } catch (\Exception $e) {
            $this->swalError('Lỗi!', $e->getMessage());
        }
    }

    private function refreshData(): void
    {
        AcademicCache::clearClassroomCache($this->classroom->id);
        $this->classroom = $this->classroomService->getById($this->classroom->id);
        $this->dispatch('faculty-updated');
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.classroom.classroom-detail');
    }
}
