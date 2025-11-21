<?php

namespace App\Livewire\Admin\Academic\Components\Classroom;

use App\Services\Admin\Classroom\ClassroomService;
use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateClassroom extends Component {
    #[Rule('required|string|max:255|unique:class_rooms,name')]
    public string $name = '';

    #[Rule('required|string|max:10|unique:class_rooms,code')]
    public string $code = '';

    #[Rule('required|exists:majors,id')]
    public string $major_id = '';

    public array $selectedStudents = [];

    public Collection $majors;
    public Collection $availableStudents;

    protected ClassroomService $classroomService;

    public function boot(ClassroomService $classroomService): void
    {
        $this->classroomService = $classroomService;
    }

    public function mount(): void
    {
        $this->majors = AcademicCache::getCachedMajorsOnly();
        $this->availableStudents = collect();
    }

    public function updatedMajorId($value): void
    {
        $this->selectedStudents = [];

        $this->availableStudents = $this->classroomService->getUnassignedStudents(
            $value ? (int)$value : null
        );
    }

    public function storeClassroom(): void
    {
        $this->validate();

        try {
            $this->classroomService->store([
                'name' => $this->name,
                'code' => $this->code,
                'major_id' => $this->major_id,
            ], $this->selectedStudents);

            $this->reset(['name', 'code', 'major_id', 'selectedStudents']);
            $this->availableStudents = collect();

            $this->dispatch('faculty-updated');
            $this->dispatch('close-modal', modalId: '#create-classroom-modal');
            $this->swal('Thành công!', 'Đã tạo lớp học và thêm sinh viên thành công.');
        } catch (\Exception $e) {
            $this->swalError('Lỗi!', $e->getMessage());
        }
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên lớp.',
            'code.required' => 'Vui lòng nhập mã lớp.',
            'major_id.required' => 'Vui lòng chọn chuyên ngành.',
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.classroom.create-classroom');
    }
}
