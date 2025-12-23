<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Assessment;

use App\Traits\WithSwal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Assignment extends Component {
    use WithSwal;

    #[Modelable]
    public array $assignment = [];
    public bool $showDetails = true;

    // Cấu hình mặc định nếu dữ liệu rỗng
    public function mount(): void
    {
        if (empty($this->assignment)) {
            $this->assignment = [
                'title' => '',
                'description' => '',
                'allowed_file_types' => ['zip', 'pdf', 'docx'], // Mặc định
                'max_file_size' => 10, // MB
                'passing_grade' => 50,
            ];
        }

        // Đảm bảo các key con luôn tồn tại để tránh lỗi undefined
        $this->assignment['allowed_file_types'] = $this->assignment['allowed_file_types'] ?? [];
        $this->assignment['max_file_size'] = $this->assignment['max_file_size'] ?? 10;
    }

    public function rules(): array
    {
        return [
            'assignment.title' => 'required|min:3|max:255',
            'assignment.description' => 'required|min:10',
        ];
    }

    public function messages(): array
    {
        return [
            'assignment.title.required' => 'Vui lòng nhập tiêu đề bài tập.',
            'assignment.description.required' => 'Vui lòng nhập mô tả yêu cầu bài tập.',
        ];
    }

    public function save(): void
    {
        $this->validate();
        $this->showDetails = false;

        $this->dispatch('assessment-saved', id: $this->assignment['title']);
        $this->dispatch('assessment-updated', isValid: true);

        $this->swal(
            title: 'Thành công',
            text: 'Cấu hình bài tập đã được lưu.',
            toast: true,
            showConfirmButton: false,
            position: 'top-end',
            timer: 2000
        );
    }

    public function remove(): void
    {
        if (!empty($this->assignment['title'])) {
            $this->dispatch('assessment-deleted', title: $this->assignment['title']);
        }
        $this->reset('assignment');
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.assessment.assignment');
    }
}
