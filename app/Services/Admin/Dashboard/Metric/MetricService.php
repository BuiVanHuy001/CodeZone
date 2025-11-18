<?php

namespace App\Services\Admin\Dashboard\Metric;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use App\Traits\HasNumberFormat;
use Spatie\Permission\Models\Role;

class MetricService
{
    use HasNumberFormat;

    public function getMetrics(): array
    {
        return [
            'totalRevenue' => $this->getTotalRevenue(),
            'totalOrders' => $this->getTotalOrders(),
            'totalStudents' => $this->getActiveStudents(),
            'totalCourses' => $this->getPublishCourses(),
        ];
    }

    private function getTotalRevenue(): array
    {
        $revenueCurrentMonth = Order::whereBetween('created_at', [now()->startOfMonth(), now()])->sum('total_price');
        $revenuePrevMonth = Order::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->sum('total_price');

        $revenueChange = $this->calculateChange($revenueCurrentMonth, $revenuePrevMonth);

        $totalRevenueRaw = Order::sum('total_price');
        $formattedParts = $this->getFormattedParts($totalRevenueRaw);

        return $this->formatMetricResult(
            title: 'Total Revenue',
            mainValue: $formattedParts['number'],
            change: $revenueChange,
            mainIcon: 'ri-money-dollar-circle-line',
            color: 'success',
            linkText: 'View all revenues',
            prefix: '₫',
            suffix: $formattedParts['suffix']
        );
    }

    private function getTotalOrders(): array
    {
        $orderCurrentMonth = Order::whereBetween('created_at', [now()->startOfMonth(), now()])->count();
        $orderPrevMonth = Order::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();

        $orderChange = $this->calculateChange($orderCurrentMonth, $orderPrevMonth);
        $totalOrders = Order::count();
        $formattedParts = $this->getFormattedParts($totalOrders);

        return $this->formatMetricResult(
            title: 'Total Orders',
            mainValue: $formattedParts['number'],
            change: $orderChange,
            mainIcon: 'ri-shopping-cart-line',
            color: 'primary',
            linkText: 'View all orders',
            suffix: $formattedParts['suffix']
        );
    }

    private function getPublishCourses(): array
    {
        $courseCurrentMonth = Course::where('status', 'published')
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->count();

        $coursePrevMonth = Course::where('status', 'published')
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->count();

        $courseChange = $this->calculateChange($courseCurrentMonth, $coursePrevMonth);

        $publishedCourses = Course::where('status', 'published')->count();
        $draftCourses = Course::where('status', 'draft')->count();
        $formattedParts = $this->getFormattedParts($publishedCourses);

        return $this->formatMetricResult(
            title: 'Courses Published',
            mainValue: $formattedParts['number'],
            change: $courseChange,
            mainIcon: 'ri-book-open-line',
            color: 'info',
            linkText: 'View all courses',
            suffix: $formattedParts['suffix'],
            extra: "{$draftCourses} in draft"
        );
    }

    private function getActiveStudents(): array
    {
        $activeStudents = Role::findByName('student')->users()->where('status', 'active')->get();
        $studentCurrent = $activeStudents->whereBetween('created_at', [now()->startOfMonth(), now()])->count();

        $studentPrev = $activeStudents->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();

        $studentChange = $this->calculateChange($studentCurrent, $studentPrev);
        $totalStudents = $activeStudents->count();
        $formattedParts = $this->getFormattedParts($totalStudents);

        return $this->formatMetricResult(
            title: 'Active Students',
            mainValue: $formattedParts['number'],
            change: $studentChange,
            mainIcon: 'ri-user-3-line',
            color: 'warning',
            linkText: 'See all students',
            suffix: $formattedParts['suffix']
        );
    }

    private function calculateChange(float|int $current, float|int $previous): string
    {
        if ($previous === 0) {
            return $current > 0 ? '+100.00 %' : '0.00 %';
        }

        $pct = (($current - $previous) / $previous) * 100;
        $sign = $pct >= 0 ? '+' : '-';
        return $sign . number_format(abs($pct), 2) . ' %';
    }

    private function formatMetricResult(
        string           $title,
        float|int|string $mainValue,
        string           $change,
        string           $mainIcon,
        string           $color,
        string           $linkText,
        ?string          $prefix = null,
        ?string          $suffix = null,
        ?string          $extra = null,
    ): array
    {
        return array_filter([
            'title' => $title,
            'mainValue' => $mainValue,
            'change' => $change,
            'mainIcon' => $mainIcon,
            'color' => $color,
            'linkText' => $linkText,
            'prefix' => $prefix,
            'suffix' => $suffix,
            'extra' => $extra,
        ]);
    }
}
