<?php

namespace App\Livewire\Admin\Overview;

use App\Services\Admin\Dashboard\DashboardService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Admin Overview')]
class Index extends Component
{
    private DashboardService $adminService;

    // Metrics
    public array $totalRevenue;
    public array $totalOrders;
    public array $totalStudents;
    public array $totalCourses;

    // Charts
    public array $topEnrolledCourses;
    public array $topRatingCourses;
    public array $courseCategoryDistribution;
    public array $revenueCategoryDistribution;
    public array $platformPerformanceTrends;

    public function boot(): void
    {
        $this->adminService = app(DashboardService::class);
    }

    public function mount(): void
    {
        $this->loadData();
    }

    private function loadData(): void
    {
        $this->loadMetrics();
        $this->loadCharts();
    }

    private function loadMetrics(): void
    {
        $metrics = $this->adminService->getMetrics();
        $this->totalRevenue = $metrics['totalRevenue'];
        $this->totalOrders = $metrics['totalOrders'];
        $this->totalStudents = $metrics['totalStudents'];
        $this->totalCourses = $metrics['totalCourses'];
    }

    private function loadCharts(): void
    {
        $charts = $this->adminService->getCharts();
        $this->topEnrolledCourses = $charts['top_enrolled_courses'];
        $this->topRatingCourses = $charts['top_rating_courses'];
        $this->courseCategoryDistribution = $charts['course_category_distribution'];
        $this->revenueCategoryDistribution = $charts['revenue_category_distribution'];
        $this->platformPerformanceTrends = $charts['platform_performance_trends'];
    }

    public function render(): View
    {
        return view('livewire.admin.overview.index')
            ->layout('components.layouts.admin-dashboard');
    }
}
