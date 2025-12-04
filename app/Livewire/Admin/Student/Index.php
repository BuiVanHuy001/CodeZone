<?php

namespace App\Livewire\Admin\Student;

use App\Services\Admin\Student\StudentService;
use App\Services\Cache\AcademicCache;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Quản lý sinh viên')]
class Index extends Component {
    use WithPagination, WithoutUrlPagination;

    public int $perPage = 10;
    public string $searchInternal = '';
    public string $searchExternal = '';
    public $selectedFaculty = '';
    public $selectedMajor = '';
    public $selectedClass = '';

    public array $totalStudentsChart;
    public array $internalDistributionChart;
    public array $externalDistributionChart;

    public function mount(): void
    {
        $this->loadCharts();
    }

    private function loadCharts(): void
    {
        $charts = app(StudentService::class)->getCharts();
        $this->totalStudentsChart = $charts['totalStudents'];
        $this->internalDistributionChart = $charts['internalDistribution'];
        $this->externalDistributionChart = $charts['externalDistribution'];
    }

    public function updatedSelectedFaculty(): void
    {
        $this->selectedMajor = '';
        $this->selectedClass = '';
        $this->resetPage('internalPage');
    }

    public function updatedSelectedMajor(): void
    {
        $this->selectedClass = '';
        $this->resetPage('internalPage');
    }

    public function updatedPerPage(): void
    {
        $this->resetPage('internalPage');
        $this->resetPage('externalPage');
    }

    public function updatedSelectedClass(): void
    {
        $this->resetPage('internalPage');
    }

    public function updatedSearchInternal(): void
    {
        $this->resetPage(pageName: 'internalPage');
    }

    public function updatedSearchExternal(): void
    {
        $this->resetPage(pageName: 'externalPage');
    }

    #[On('student-updated')]
    #[On('students-imported')]
    public function refreshData(): void
    {
        $this->loadCharts();

        $this->dispatch('students-charts-updated', [
            'total' => $this->totalStudentsChart,
            'internal' => $this->internalDistributionChart,
            'external' => $this->externalDistributionChart,
        ]);

        $this->dispatch('init-tooltip');
    }

    public function render(StudentService $studentService): View
    {
        $faculties = AcademicCache::getCachedFacultiesOnly();

        $majors = collect();
        if ($this->selectedFaculty) {
            $majors = AcademicCache::getCachedMajorsOnly()
                                   ->where('faculty_id', $this->selectedFaculty);
        }

        $classes = collect();
        if ($this->selectedMajor) {
            $classes = AcademicCache::getCachedClassroom()
                                    ->where('major_id', $this->selectedMajor);
        }

        $filters = [
            'faculty_id' => $this->selectedFaculty,
            'major_id' => $this->selectedMajor,
            'class_room_id' => $this->selectedClass,
        ];

        $internalQuery = $studentService->getInternalStudentsQuery($filters);

        if ($this->searchInternal) {
            $internalQuery->where(function ($q) {
                $searchTerm = '%' . $this->searchInternal . '%';
                $q
                    ->where('name', 'like', $searchTerm)
                    ->orWhere('email', 'like', $searchTerm)
                    ->orWhereHas('studentProfile', function ($sq) use ($searchTerm) {
                        $sq->where('student_code', 'like', $searchTerm);
                    });
            });
        }

        $internalStudents = $internalQuery
            ->latest()
            ->paginate($this->perPage, ['*'], 'internalPage');


        $externalQuery = $studentService->getExternalStudentsQuery();

        if ($this->searchExternal) {
            $externalQuery->where(function ($q) {
                $q
                    ->where('name', 'like', '%' . $this->searchExternal . '%')
                    ->orWhere('email', 'like', '%' . $this->searchExternal . '%');
            });
        }

        $externalStudents = $externalQuery->latest()->paginate($this->perPage, ['*'], 'externalPage');

        return view('livewire.admin.student.index', [
            'internalStudents' => $internalStudents,
            'externalStudents' => $externalStudents,
            'faculties' => $faculties,
            'majors' => $majors,
            'classes' => $classes,
        ])->layout('components.layouts.admin-dashboard');
    }
}
