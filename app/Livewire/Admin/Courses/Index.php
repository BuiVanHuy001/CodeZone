<?php

namespace App\Livewire\Admin\Courses;

use App\DTOs\Course\CourseSummary;
use App\Models\Category;
use App\Models\Course;
use App\Services\Admin\Course\CourseService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Quản lý Khóa học')]
class Index extends Component {
    use WithSwal, WithPagination;

    private CourseService $adminCourseService;

    public string $currentTab = 'published';
    public string $search = '';
    public string $selectedCategory = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    public function boot(CourseService $service): void
    {
        $this->adminCourseService = $service;
    }

    public function updatedCurrentTab(): void
    {
        $this->resetPage();
        $this->search = '';
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedCategory(): void
    {
        $this->resetPage();
    }

    public function setTab($tab): void
    {
        $this->currentTab = $tab;
    }

    public function suspend(string $courseId): void
    {
        if ($this->adminCourseService->suspendCourse($courseId)) {
            $this->swal('Thành công', 'Khóa học đã bị đình chỉ.');
            $this->dispatch('course-updated');
        } else {
            $this->swalError('Lỗi', 'Không thể đình chỉ khóa học này.');
        }
    }

    public function approve(string $courseId): void
    {
        if ($this->adminCourseService->approveCourse($courseId)) {
            $this->swal('Thành công', 'Khóa học đã được duyệt và công khai.');
            $this->dispatch('course-updated');
        } else {
            $this->swalError('Lỗi', 'Đã có lỗi xảy ra.');
        }
    }

    public function reject(string $courseId): void
    {
        if ($this->adminCourseService->rejectCourse($courseId)) {
            $this->swal('Thành công', 'Khóa học đã bị từ chối.');
            $this->dispatch('course-updated');
        } else {
            $this->swalError('Lỗi', 'Đã có lỗi xảy ra.');
        }
    }

    public function restore(string $courseId): void
    {
        if ($this->adminCourseService->restoreCourse($courseId)) {
            $this->swal('Thành công', 'Khóa học đã được khôi phục.');
            $this->dispatch('course-updated');
        } else {
            $this->swalError('Lỗi', 'Không thể khôi phục khóa học.');
        }
    }

    public function render(): View
    {

        $query = Course::query()
                       ->with(['author', 'category', 'enrollments'])
                       ->where('status', $this->currentTab);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q
                    ->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('author', fn($a) => $a->where('name', 'like', '%' . $this->search . '%'));
            });
        }

        if (!empty($this->selectedCategory)) {
            $query->where('category_id', $this->selectedCategory);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $courses = $query->paginate(10);

        $courses->getCollection()->transform(function ($course) {
            return CourseSummary::fromModel($course, includeAuthor: true)->toLivewire();
        });

        $counts = [
            'published' => Course::where('status', 'published')->count(),
            'pending' => Course::where('status', 'pending')->count(),
            'suspended' => Course::where('status', 'suspended')->count(),
        ];

        $categories = Category::all();

        return view('livewire.admin.courses.index', [
            'courses' => $courses,
            'counts' => $counts,
            'categories' => $categories
        ])->layout('components.layouts.admin-dashboard');
    }
}
