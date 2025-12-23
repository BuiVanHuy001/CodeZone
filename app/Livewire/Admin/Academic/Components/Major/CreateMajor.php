<?php

namespace App\Livewire\Admin\Academic\Components\Major;

use App\Services\Admin\Major\MajorService;
use App\Services\Cache\AcademicCache;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateMajor extends Component {
    use WithSwal;
    #[Rule('required|string|max:255|unique:majors,name')]
    public string $name = '';

    #[Rule('required|string|max:10|unique:majors,code')]
    public string $code = '';

    #[Rule('required|exists:faculties,id')]
    public string $faculty_id = '';

    public Collection $faculties;


    public function mount(): void
    {
        $this->loadFaculties();
    }

    #[On('faculty-created')]
    #[On('faculty-updated')]
    public function loadFaculties(): void
    {
        $this->faculties = AcademicCache::getCachedFacultiesOnly();
    }

    public function storeMajor(): void
    {
        $this->validate();

        try {
            app(MajorService::class)->store([
                'name' => $this->name,
                'code' => $this->code,
                'faculty_id' => $this->faculty_id,
                'slug' => Str::slug($this->name),
            ]);

            $this->reset(['name', 'code', 'faculty_id']);

            $this->dispatch('major-created');
            $this->dispatch('close-modal', modalId: '#create-major-modal');

            $this->swal('Thành công!', 'Đã thêm chuyên ngành mới.');
        } catch (\Exception $e) {
            $this->swalError('Lỗi!', 'Đã xảy ra lỗi khi thêm chuyên ngành mới.');
            report($e);
        }
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên ngành.',
            'name.unique' => 'Tên ngành này đã tồn tại.',
            'code.required' => 'Vui lòng nhập mã ngành.',
            'code.max' => 'Mã ngành không được vượt quá 10 ký tự.',
            'code.unique' => 'Mã ngành này đã tồn tại.',
            'faculty_id.required' => 'Vui lòng chọn Khoa trực thuộc.',
            'faculty_id.exists' => 'Khoa đã chọn không hợp lệ.',
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.major.create-major');
    }
}
