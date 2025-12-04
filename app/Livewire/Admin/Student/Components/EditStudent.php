<?php

namespace App\Livewire\Admin\Student\Components;

use App\Models\ClassRoom;
use App\Models\User;
use App\Services\Admin\Student\StudentService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class EditStudent extends Component {
    #[Locked]
    public ?string $studentId = null;

    public string $name = '';
    public ?string $dob = null;
    public ?string $gender = '';
    public ?string $classRoomId = '';
    public string $studentCode = '';
    public string $status;


    public $statusOptions = [];
    public ?string $currentAvatarUrl = null;
    public bool $hasAvatar = false;

    #[On('show-edit-modal')]
    public function loadStudent(string $id): void
    {
        $this->dispatch('open-modal', id: 'editStudentModal');
        $this->resetErrorBag();
        $this->resetValidation();

        $student = User::find($id);

        if (!$student) {
            $this->swalError('Lỗi!', 'Không tìm thấy sinh viên!');
            return;
        }

        $this->statusOptions = $student->getAvailableStatuses();

        $allStatuses = $student->getAvailableStatuses();
        $this->statusOptions = collect($allStatuses)
            ->filter(function ($label, $statusKey) use ($student) {
                if ($student->status === $statusKey) {
                    return true;
                }
                return $student->studentProfile?->canTransitionTo($statusKey) ?? false;
            })
            ->toArray();

        $this->studentId = $student->id;
        $this->name = $student->name;
        $this->status = $student->status;
        $this->dob = $student->studentProfile->dob?->format('Y-m-d');
        $this->studentCode = $student->studentProfile->student_code;
        $this->classRoomId = $student->studentProfile->class_room_id;
        $this->gender = $student->studentProfile->gender === 1 ? 'female' : 'male';

        $this->currentAvatarUrl = $student->avatar;
        $this->hasAvatar = $this->currentAvatarUrl !== asset('images/team/temp-avatar.webp');
    }

    public function updateStudent(StudentService $studentService): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'dob' => ['nullable', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'classRoomId' => ['nullable', 'exists:class_rooms,id'],
            'status' => ['required', Rule::in(array_keys(User::getStatusesByRole('student')))],
            'studentCode' => ['required', Rule::unique('student_profiles', 'student_code')->ignore($this->studentId, 'user_id')]
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'classRoomId.exists' => 'Lớp học không hợp lệ.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'dob.before' => 'Ngày sinh phải là ngày trong quá khứ.',
            'studentCode.unique' => 'MSSV này đã tồn tại trên hệ thống.',
            'studentCode.required' => 'Vui lòng nhập mã số sinh viên.',
        ]);

        $serviceData = [
            'name' => $this->name,
            'status' => $this->status,
            'student_code' => $this->studentCode,
            'gender' => $this->parseGenderInput(),
            'dob' => $this->dob,
            'class_room_id' => $this->classRoomId,
        ];

        try {
            $studentService->updateStudent($this->studentId, $serviceData);
            $this->swal('Thành công!', 'Cập nhật thông tin sinh viên thành công.');
            $this->dispatch('close-modal', id: 'editStudentModal');
        } catch (\Exception $e) {
            $this->addError('root', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    private function parseGenderInput(): ?int
    {
        return match ($this->gender) {
            'female' => 1,
            'male' => 0,
            'other' => null
        };
    }

    #[On('delete-student-avatar')]
    public function deleteCurrentAvatar(): void
    {
        if (!$this->studentId) return;
        $student = User::find($this->studentId);
        if (app(StudentService::class)->deleteStudentAvatar($student)) {
            $this->currentAvatarUrl = null;
            $this->hasAvatar = false;
            $this->swal('Thành công!', 'Đã xóa ảnh đại diện.');
        } else {
            $this->swalError('Lỗi!', 'Xóa ảnh đại diện thất bại.');
        }
        $this->resetErrorBag();
        $this->dispatch('close-modal', id: 'editStudentModal');
    }

    public function render(): View
    {
        return view('livewire.admin.student.components.edit-student', [
            'classRooms' => ClassRoom::with('major')->get()
        ]);
    }
}
