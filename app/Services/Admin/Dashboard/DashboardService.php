<?php

namespace App\Services\Admin\Dashboard;

use App\Services\Admin\Dashboard\Chart\ChartService;
use App\Services\Admin\Dashboard\Metric\MetricService;
use App\Traits\HasNumberFormat;

class DashboardService
{
    use HasNumberFormat;

    private MetricService $metricService;
    private ChartService $chartService;

    public function __construct()
    {
        $this->metricService = app(MetricService::class);
        $this->chartService = app(ChartService::class);
    }

    public function getMetrics(): array
    {
        return $this->metricService->getMetrics();
    }

    public function getCharts(): array
    {
        return $this->chartService->getCharts();
    }
}
