<?php

namespace App\Livewire\Admin\Academic\Components\Faculty;

use App\Models\Faculty;
use App\Services\Admin\Faculty\FacultyService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateFaculty extends Component {
    #[Rule('required|string|max:255|unique:faculties,name')]
    public string $name = '';

    #[Rule('required|string|max:10|unique:faculties,code')]
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

    public function storeFaculty(): void
    {
        $this->validate();

        try {
            app(FacultyService::class)->store([
                'name' => $this->name,
                'code' => strtoupper($this->code),
                'slug' => Str::slug($this->name),
            ]);

            $this->reset(['name', 'code']);

            $this->dispatch('faculty-created');
            $this->dispatch('close-modal');
            $this->swal('Thành công!', 'Đã thêm khoa mới thành công.');

        } catch (\Exception $e) {
            $this->swalError('Lỗi!', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.faculty.create-faculty');
    }
}
