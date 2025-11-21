<?php

namespace App\Livewire\Admin\Academic\Components\Major;

use App\Services\Admin\Major\MajorService;
use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class EditMajor extends Component {
    public ?int $majorId = null;
    public string $name = '';
    public string $code = '';
    public string $faculty_id = '';

    public Collection $faculties;

    public function mount(): void
    {
        $this->faculties = AcademicCache::getCachedFacultiesOnly();
    }

    #[On('edit-major')]
    public function setEditMajor(int $id): void
    {
        $major = app(MajorService::class)->getById($id);

        if ($major) {
            $this->majorId = $major->id;
            $this->name = $major->name;
            $this->code = $major->code;
            $this->faculty_id = (string)$major->faculty_id;

            $this->resetValidation();

            $this->dispatch('open-edit-major-modal');
        } else {
            $this->swalError('Lỗi', 'Không tìm thấy ngành này.');
        }
    }

    public function updateMajor(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('majors')->ignore($this->majorId)],
            'code' => ['required', 'string', 'max:10', Rule::unique('majors')->ignore($this->majorId)],
            'faculty_id' => ['required', 'exists:faculties,id'],
        ]);

        try {
            app(MajorService::class)->update($this->majorId, [
                'name' => $this->name,
                'code' => $this->code,
                'slug' => Str::slug($this->name),
                'faculty_id' => $this->faculty_id,
            ]);

            $this->dispatch('faculty-updated');

            $this->dispatch('close-modal', modalId: '#edit-major-modal');
            $this->swal('Thành công!', 'Cập nhật chuyên ngành thành công.');

        } catch (\Exception $e) {
            $this->swalError('Lỗi!', 'Đã có lỗi xảy ra khi cập nhật chuyên ngành.');
        }
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên ngành.',
            'name.unique' => 'Tên ngành này đã tồn tại.',
            'code.unique' => 'Mã ngành này đã tồn tại.',
            'code.required' => 'Vui lòng nhập mã ngành.',
            'code.max' => 'Mã ngành không được vượt quá 10 ký tự.',
            'faculty_id.required' => 'Vui lòng chọn Khoa trực thuộc.',
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.major.edit-major');
    }
}
