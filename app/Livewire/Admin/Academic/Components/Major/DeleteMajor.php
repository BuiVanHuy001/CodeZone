<?php

namespace App\Livewire\Admin\Academic\Components\Major;

use App\Models\Major;
use App\Services\Admin\Major\MajorService;
use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class DeleteMajor extends Component {
    public ?Major $major = null;
    public Collection $targetMajors;

    public int $classCount = 0;
    public int $studentCount = 0;
    public int $instructorCount = 0;

    #[Rule('required|exists:majors,id')]
    public ?int $targetMajorId = null;

    public function mount(): void
    {
        $this->targetMajors = collect();
    }

    #[On('init-delete-major')]
    public function initDelete(int $id): void
    {
        $this->reset();
        $this->targetMajors = collect();

        $this->major = app(MajorService::class)->getById($id);

        if (!$this->major) {
            $this->swalError('Lỗi', 'Ngành không tồn tại.');
            return;
        }

        $this->classCount = $this->major->class_rooms_count;
        $this->studentCount = $this->major->student_profiles_count;
        $this->instructorCount = $this->major->instructor_profiles_count;

        $totalRelated = $this->classCount + $this->studentCount + $this->instructorCount;

        if ($totalRelated === 0) {
            $this->dispatch('swal-confirm-delete-empty-major', id: $id);
            return;
        }

        $this->targetMajors = AcademicCache::getCachedMajorsOnly()
                                           ->where('id', '!=', $id)
                                           ->values();

        if ($this->targetMajors->isEmpty()) {
            $this->swalError('Không thể xóa!', 'Đây là chuyên ngành duy nhất. Bạn không thể chuyển dữ liệu đi đâu cả.');
            return;
        }

        $this->dispatch('open-delete-major-modal');
    }

    public function confirmDeleteWithMigration(): void
    {
        $this->validate();

        try {
            app(MajorService::class)->transferAndDelete($this->major->id, $this->targetMajorId);

            $this->dispatch('close-modal', modalId: '#delete-major-modal');
            $this->dispatch('faculty-updated');

            $this->swal('Thành công!', 'Đã chuyển dữ liệu và xóa ngành cũ.');

            $this->reset();

        } catch (\Exception $e) {
            $this->swalError('Lỗi', 'Không thể xóa ngành. Vui lòng thử lại sau.');
            report($e);
        }
    }

    #[On('delete-empty-major-confirmed')]
    public function deleteEmptyMajor(int $id): void
    {
        if (app(MajorService::class)->delete($id)) {
            $this->reset();
            $this->dispatch('faculty-updated');
            $this->swal('Đã xóa!', 'Ngành đã được xóa thành công.');
        } else {
            $this->swalError('Lỗi', 'Không thể xóa.');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.academic.components.major.delete-major');
    }
}
