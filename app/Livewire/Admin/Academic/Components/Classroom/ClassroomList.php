<?php

namespace App\Livewire\Admin\Academic\Components\Classroom;

use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ClassroomList extends Component {
    use WithPagination;

    public string $search = '';
    public string $sortDirection = 'desc';

    #[On('classroom-created')]
    #[On('classroom-updated')]
    #[On('classroom-deleted')]
    public function refresh() {}

    public function toggleSort(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    private function paginateCollection(Collection $items, int $perPage = 10): LengthAwarePaginator
    {
        $page = Paginator::resolveCurrentPage('page');

        $currentItems = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
    }

    public function render(): View
    {
        $classrooms = AcademicCache::getCachedClassroom();

        if ($this->search) {
            $keyword = Str::lower(Str::ascii($this->search));

            $classrooms = $classrooms->filter(function ($class) use ($keyword) {
                $name = Str::lower(Str::ascii($class->name));
                $code = Str::lower(Str::ascii($class->code));

                return str_contains($name, $keyword) || str_contains($code, $keyword);
            });
        }

        // 3. Sort Logic
        if ($this->sortDirection === 'asc') {
            $classrooms = $classrooms->sortBy('created_at');
        } else {
            $classrooms = $classrooms->sortByDesc('created_at');
        }

        // 4. Phân trang (Tùy chọn: Nếu muốn scrollable thì bỏ dòng này và trả về values())
        // Ở đây mình dùng phân trang 10 item/trang theo yêu cầu "pagination" của bạn
        $paginatedClassrooms = $this->paginateCollection($classrooms, 10);

        return view('livewire.admin.academic.components.classroom.classroom-list', [
            'classrooms' => $paginatedClassrooms
        ]);
    }

    // Reset page khi search thay đổi để tránh lỗi đang ở trang 5 mà search ra có 2 trang
    public function updatedSearch()
    {
        $this->resetPage();
    }
}
