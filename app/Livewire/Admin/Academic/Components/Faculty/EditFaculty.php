<?php

namespace App\Livewire\Admin\Academic\Components\Faculty;

use App\Models\Faculty;
use App\Services\Admin\Faculty\FacultyService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditFaculty extends Component {
    public ?int $facultyId = null;
    public string $name = '';
    public string $code = '';

    protected function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên khoa.',
            'name.string' => 'Tên khoa phải là một chuỗi ký tự.',
            'name.max' => 'Tên khoa không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên khoa này đã tồn tại trong hệ thống.',

            'code.required' => 'Vui lòng nhập mã khoa.',
            'code.string' => 'Mã khoa phải là một chuỗi ký tự.',
            'code.max' => 'Mã khoa không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã khoa này đã tồn tại.',
        ];
    }

    #[On('edit-faculty')]
    public function setEditFaculty(int $id): void
    {
        $faculty = Faculty::find($id);

        if ($faculty) {
            $this->facultyId = $faculty->id;
            $this->name = $faculty->name;
            $this->code = $faculty->code;

            $this->resetValidation();

            $this->dispatch('open-edit-modal');
        }
    }

    public function updateFaculty(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('faculties')->ignore($this->facultyId)],
            'code' => ['required', 'string', 'max:50', Rule::unique('faculties')->ignore($this->facultyId)],
        ]);

        try {
            app(FacultyService::class)->update($this->facultyId, [
                'name' => $this->name,
                'code' => strtoupper($this->code),
                'slug' => Str::slug($this->name),
            ]);
            $this->dispatch('faculty-updated');

            $this->dispatch('close-modal', modalId: '#edit-faculty-modal');
            $this->dispatch('swal', [
                'title' => 'Thành công!',
                'text' => 'Cập nhật khoa thành công.',
                'icon' => 'success'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'title' => 'Lỗi!',
                'text' => 'Có lỗi xảy ra: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.faculty.edit-faculty');
    }
}
