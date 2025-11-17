<?php

namespace App\Livewire\Admin\Student;

use App\Services\Admin\Student\StudentService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    public array $totalStudentsChart;
    public array $internalDistributionChart;
    public array $externalDistributionChart;

    public Collection $internalStudentTable;
    public Collection $externalStudentTable;

    public function mount(): void
    {
        $charts = app(StudentService::class)->getCharts();
        $this->totalStudentsChart = $charts['totalStudents'];
        $this->internalDistributionChart = $charts['internalDistribution'];
        $this->externalDistributionChart = $charts['externalDistribution'];

        $students = app(StudentService::class)->getStudentsData();
        $this->internalStudentTable = $students['internal'];
        $this->externalStudentTable = $students['external'];
    }

    public function render(): View
    {
        return view('livewire.admin.student.index')
            ->layout('components.layouts.admin-dashboard');
    }
}
