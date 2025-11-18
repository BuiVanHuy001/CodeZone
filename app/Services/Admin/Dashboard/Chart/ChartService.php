<?php

namespace App\Services\Admin\Dashboard\Chart;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ChartService {
    public function getCharts(): array
    {
        return [
            'top_enrolled_courses' => $this->getTopEnrolledCourses(),
            'top_rating_courses' => $this->getTopRatingCourses(),
            'course_category_distribution' => $this->getCourseCategoryDistribution(),
            'revenue_category_distribution' => $this->getRevenueCategoryDistribution(),
            'platform_performance_trends' => $this->getPlatformPerformanceTrends()
        ];
    }

    private function getTopEnrolledCourses(): array
    {
        $courses = Course::select('title', 'enrollment_count')
            ->where('status', 'published')
            ->orderByDesc('enrollment_count')
            ->limit(5)
            ->get();

        return [
            'title' => 'Top Enrolled Courses',
            'subtitle' => 'Courses with the highest number of enrollments',
            'categories' => $courses->pluck('title')->toArray(),
            'data' => $courses->pluck('enrollment_count')->toArray(),
        ];
    }

    private function getTopRatingCourses(): array
    {
        $courses = Course::query()
            ->select('title', 'rating', 'review_count')
            ->where('status', 'published')
            ->where('review_count', '>', 0)
            ->orderByDesc(\DB::raw('rating * LOG(review_count + 1)'))
            ->limit(5)
            ->get();

        return [
            'title' => 'Top Rated Courses',
            'subtitle' => 'Courses with the highest ratings weighted by review count',
            'categories' => $courses->pluck('title')->toArray(),
            'data' => $courses->pluck('rating')->map(fn($v) => round($v, 1))->toArray(),
            'review_counts' => $courses->pluck('review_count')->toArray(),
        ];
    }

    private function getCourseCategoryDistribution(): array
    {
        $data = Category::query()
            ->select('name')
            ->withCount(['courses' => fn($q) => $q->where('status', 'published')])
            ->orderByDesc('courses_count')
            ->limit(10)
            ->get();

        return [
            'title' => 'Course Distribution by Category',
            'subtitle' => 'Number of published courses by category',
            'categories' => $data->pluck('name')->toArray(),
            'data' => $data->pluck('courses_count')->toArray(),
        ];
    }

    private function getRevenueCategoryDistribution(): array
    {
        $data = DB::table('categories')
            ->join('courses', 'categories.id', '=', 'courses.category_id')
            ->join('order_items', 'order_items.course_id', '=', 'courses.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->select('categories.name', DB::raw('SUM(order_items.current_price) as total_revenue'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        return [
            'title' => 'Revenue Share by Category',
            'subtitle' => 'Total revenue generated per category',
            'categories' => $data->pluck('name')->toArray(),
            'data' => $data->pluck('total_revenue')->map(fn($v) => round($v))->toArray(),
            'isRevenue' => true,
        ];
    }

    private function getPlatformPerformanceTrends(): array
    {
        $months = collect(range(0, 11))
            ->map(fn($i) => now()->subMonths($i)->format('M Y'))
            ->reverse()
            ->values();

        $revenues = DB::table('orders')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, SUM(total_price) as total')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month')
            ->pluck('total', 'month');

        $orders = DB::table('orders')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, COUNT(*) as total')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month')
            ->pluck('total', 'month');

        $students = User::selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, COUNT(*) as total')
                        ->where('created_at', '>=', now()->subYear())
                        ->role('student')
                        ->groupBy('month')
                        ->pluck('total', 'month');

        $instructors = User::selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, COUNT(*) as total')
                           ->where('created_at', '>=', now()->subYear())
                           ->role('instructor')
                           ->groupBy('month')
                           ->pluck('total', 'month');

        $approvedCourses = DB::table('courses')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month, COUNT(*) as total')
            ->where('status', 'published')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month')
            ->pluck('total', 'month');

        return [
            'title' => 'Platform Growth Overview',
            'subtitle' => 'Revenue, orders, students, instructors, and approved courses (last 12 months)',
            'months' => $months,
            'revenue' => $months->map(fn($m) => (float)($revenues[$m] ?? 0))->toArray(),
            'orders' => $months->map(fn($m) => (int)($orders[$m] ?? 0))->toArray(),
            'students' => $months->map(fn($m) => (int)($students[$m] ?? 0))->toArray(),
            'instructors' => $months->map(fn($m) => (int)($instructors[$m] ?? 0))->toArray(),
            'courses' => $months->map(fn($m) => (int)($approvedCourses[$m] ?? 0))->toArray(),
        ];
    }
}
