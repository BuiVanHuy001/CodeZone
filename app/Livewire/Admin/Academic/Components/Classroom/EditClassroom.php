<?php

namespace App\Livewire\Admin\Academic\Components\Classroom;

use App\Models\ClassRoom;
use App\Services\Admin\Classroom\ClassroomService;
use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditClassroom extends Component {
    public ?int $classroomId = null;
    public string $name = '';
    public string $code = '';
    public string $major_id = '';

    public Collection $majors;

    public function mount(): void
    {
        $this->majors = AcademicCache::getCachedMajorsOnly();
    }

    #[On('edit-classroom')]
    public function setEditClassroom(int $id): void
    {
        $classroom = ClassRoom::find($id);

        if ($classroom) {
            $this->classroomId = $classroom->id;
            $this->name = $classroom->name;
            $this->code = $classroom->code;
            $this->major_id = (string)$classroom->major_id;

            $this->resetValidation();
            $this->dispatch('open-edit-classroom-modal');
        } else {
            $this->swalError('Lỗi!', 'Lớp học không tồn tại.');
        }
    }

    public function updateClassroom(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('class_rooms')->ignore($this->classroomId)],
            'code' => ['required', 'string', 'max:50', Rule::unique('class_rooms')->ignore($this->classroomId)],
            'major_id' => ['required', 'exists:majors,id'],
        ]);

        try {
            app(ClassroomService::class)->update($this->classroomId, [
                'name' => $this->name,
                'code' => $this->code,
                'slug' => Str::slug($this->name),
                'major_id' => $this->major_id,
            ]);

            $this->dispatch('faculty-updated');

            $this->dispatch('close-modal', modalId: '#edit-classroom-modal');
            $this->swal('Thành công!', 'Cập nhật lớp học thành công.');
        } catch (\Exception $e) {
            $this->swalError('Lỗi!', $e->getMessage());
        }
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên lớp.',
            'name.unique' => 'Tên lớp này đã tồn tại.',
            'code.required' => 'Vui lòng nhập mã lớp.',
            'code.unique' => 'Mã lớp này đã tồn tại.',
            'major_id.required' => 'Vui lòng chọn chuyên ngành.',
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.classroom.edit-classroom');
    }
}
