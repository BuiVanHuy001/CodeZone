<div class="row">
    <div class="col">
        <div class="h-100">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">Good Morning, Anna!</h4>
                            <p class="text-muted mb-0">
                                Here's what's happening with your store today.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <x-admin.base.stat-card
                    title="{{ $totalRevenue['title'] }}"
                    change="{{ $totalRevenue['change'] }}"
                    mainValue="{{ $totalRevenue['mainValue'] }}"
                    linkText="{{ $totalRevenue['linkText'] }}"
                    mainIcon="{{ $totalRevenue['mainIcon'] }}"
                    color="{{ $totalRevenue['color'] }}"
                    prefix="{{ $totalRevenue['prefix'] }}"
                    suffix="{{ $totalRevenue['suffix'] }}"
                />

                <x-admin.base.stat-card
                    title="{{ $totalOrders['title'] }}"
                    change="{{ $totalOrders['change'] }}"
                    mainValue="{{ $totalOrders['mainValue'] }}"
                    linkText="{{ $totalOrders['linkText'] }}"
                    mainIcon="{{ $totalOrders['mainIcon'] }}"
                    color="{{ $totalOrders['color'] }}"
                />

                <x-admin.base.stat-card
                    title="{{ $totalStudents['title'] }}"
                    change="{{ $totalStudents['change'] }}"
                    mainValue="{{ $totalStudents['mainValue'] }}"
                    linkText="{{ $totalStudents['linkText'] }}"
                    mainIcon="{{ $totalStudents['mainIcon'] }}"
                    color="{{ $totalStudents['color'] }}"
                />

                <x-admin.base.stat-card
                    title="{{ $totalCourses['title'] }}"
                    change="{{ $totalCourses['change'] }}"
                    mainValue="{{ $totalCourses['mainValue'] }}"
                    linkText="{{ $totalCourses['linkText'] }}"
                    mainIcon="{{ $totalCourses['mainIcon'] }}"
                    color="{{ $totalCourses['color'] }}"
                />
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="platform_performance_trends"
                                 data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info","--vz-warning", "--vz-danger"]'
                                 class="apex-charts"
                                 dir="ltr">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div
                                id="course-category-distribution"
                                data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info","--vz-warning", "--vz-danger"]'
                                class="apex-charts"
                                dir="ltr"
                            ></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div
                                id="revenue-category-distribution"
                                data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info","--vz-warning", "--vz-danger"]'
                                class="apex-charts"
                                dir="ltr"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="top-enrolled-courses"
                                 data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info", "--vz-warning"]'
                                 class="apex-charts"
                                 dir="ltr"
                            ></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="top-rating-courses"
                                 data-colors='["--vz-primary", "--vz-secondary", "--vz-success", "--vz-info", "--vz-warning"]'
                                 class="apex-charts"
                                 dir="ltr"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ Vite::asset('resources/assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        (function () {
            const chartInstances = {};

            function getChartColorsArray(id) {
                const el = document.getElementById(id);
                if (!el) return null;

                const colors = JSON.parse(el.getAttribute("data-colors"));
                return colors.map(value => {
                    const color = value.replace(" ", "");
                    if (color.indexOf(",") === -1) {
                        return getComputedStyle(document.documentElement).getPropertyValue(color) || color;
                    }
                    const [base, opacity] = color.split(",");
                    return `rgba(${getComputedStyle(document.documentElement).getPropertyValue(base)}, ${opacity})`;
                });
            }

            function destroyChart(id) {
                if (chartInstances[id]) {
                    try {
                        chartInstances[id].destroy();
                    } catch (e) {
                        console.warn(`Error destroying chart ${id}:`, e);
                    }
                    delete chartInstances[id];
                }

                const element = document.querySelector(`#${id}`);
                if (element) {
                    element.innerHTML = '';
                }
            }

            function destroyAllCharts() {
                Object.keys(chartInstances).forEach(id => {
                    destroyChart(id);
                });
            }

            function initHorizontalBarChart(id, chartData) {
                if (typeof ApexCharts === 'undefined') {
                    console.warn('ApexCharts not loaded yet, skipping chart initialization');
                    return;
                }

                const chartColors = getChartColorsArray(id);
                const element = document.querySelector(`#${id}`);
                if (!chartColors || !element) return;

                if (!chartData || !chartData.data || !Array.isArray(chartData.data) || chartData.data.length === 0) {
                    console.warn(`Invalid chart data for ${id}`);
                    return;
                }

                destroyChart(id);

                const options = {
                series: [{data: chartData.data}],
                chart: {type: "bar", height: 350, toolbar: {show: false}},
                plotOptions: {
                    bar: {
                        horizontal: true,
                        distributed: true,
                        barHeight: "100%",
                        dataLabels: {position: "bottom"},
                    },
                },
                colors: chartColors,
                dataLabels: {
                    enabled: true,
                    textAnchor: "start",
                    style: {colors: ["#fff"]},
                    formatter: (val, opts) => `${opts.w.globals.labels[opts.dataPointIndex]}: ${val}`,
                    offsetX: 0,
                    dropShadow: {enabled: false},
                },
                stroke: {width: 1, colors: ["#fff"]},
                xaxis: {categories: chartData.categories},
                yaxis: {labels: {show: false}},
                title: {
                    text: chartData.title,
                    align: "center",
                    style: {fontWeight: 600},
                },
                subtitle: {
                    text: chartData.subtitle,
                    align: "center",
                },
                tooltip: {
                    theme: "dark",
                    x: {show: false},
                    y: {title: {formatter: () => ""}},
                },
            };

                chartInstances[id] = new ApexCharts(element, options);
                chartInstances[id].render();
        }

        function initTreemapChart(id, chartData) {
            if (typeof ApexCharts === 'undefined') {
                console.warn('ApexCharts not loaded yet, skipping chart initialization');
                return;
            }

            const chartColors = getChartColorsArray(id);
            const element = document.querySelector(`#${id}`);
            if (!chartColors || !element) return;

            if (!chartData || !chartData.data || !Array.isArray(chartData.data) || chartData.data.length === 0) {
                console.warn(`Invalid chart data for ${id}`);
                return;
            }

            destroyChart(id);

            const seriesData = chartData.data.map((value, index) => ({
                x: chartData.categories[index],
                y: value,
            }));

            const options = {
                series: [{data: seriesData}],
                chart: {
                    type: 'treemap',
                    height: 400,
                    toolbar: {show: false},
                },
                colors: chartColors,
                plotOptions: {
                    treemap: {
                        distributed: true,
                        enableShades: false,
                    },
                },
                legend: {show: false},
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '13px',
                        fontWeight: 500,
                    },
                    formatter: function (text, opts) {
                        const value = opts.value;
                        if (chartData.isRevenue) {
                            return `${text}\n₫${new Intl.NumberFormat('vi-VN').format(value)}`;
                        }
                        return `${text}\n${value}`;
                    },
                },
                title: {
                    text: chartData.title || "Treemap Chart",
                    align: 'center',
                    style: {
                        fontWeight: 600,
                    },
                },
                subtitle: {
                    text: chartData.subtitle || "",
                    align: 'center',
                },
                tooltip: {
                    y: {
                        formatter: val => chartData.isRevenue
                            ? '₫' + new Intl.NumberFormat('vi-VN').format(val)
                            : val + ' courses',
                    },
                },
            };

            chartInstances[id] = new ApexCharts(element, options);
            chartInstances[id].render();
        }

        function initPlatformPerformanceChart(id, chartData) {
            if (typeof ApexCharts === 'undefined') {
                console.warn('ApexCharts not loaded yet, skipping chart initialization');
                return;
            }

            const colors = getChartColorsArray(id);
            const element = document.querySelector(`#${id}`);
            if (!colors || !element) return;

            if (!chartData || !chartData.revenue || !chartData.orders || !chartData.students) {
                console.warn(`Invalid chart data for ${id}`);
                return;
            }

            destroyChart(id);

            const options = {
                series: [
                    {name: "Revenue", type: "column", data: chartData.revenue},
                    {name: "Orders", type: "line", data: chartData.orders},
                    {name: "Students", type: "line", data: chartData.students},
                    {name: "Instructors", type: "line", data: chartData.instructors},
                    {name: "Approved Courses", type: "line", data: chartData.courses},
                ],
                chart: {
                    height: 420,
                    type: "line",
                    stacked: false,
                    toolbar: {show: false},
                },
                stroke: {
                    width: [0, 3, 3, 3, 3],
                    curve: "smooth",
                },
                fill: {
                    opacity: [1, 0.3, 1, 1, 1],
                },
                labels: chartData.months,
                markers: {size: 0, hover: {size: 6}},
                yaxis: [
                    {
                        title: {text: "Revenue (₫)"},
                        labels: {
                            formatter: val => new Intl.NumberFormat('vi-VN').format(val),
                        },
                    },
                    {
                        opposite: true,
                        title: {text: "Count"},
                        labels: {
                            formatter: val => Math.round(val),
                        },
                    },
                ],
                colors: colors,
                legend: {
                    position: "top",
                    horizontalAlign: "center",
                    fontSize: "13px",
                    markers: {width: 10, height: 10, radius: 12},
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (val, {seriesIndex}) {
                            switch (seriesIndex) {
                                case 0:
                                    return "₫" + new Intl.NumberFormat("vi-VN").format(val);
                                case 1:
                                    return Math.round(val) + " orders";
                                case 2:
                                    return Math.round(val) + " students";
                                case 3:
                                    return Math.round(val) + " instructors";
                                case 4:
                                    return Math.round(val) + " courses";
                                default:
                                    return val;
                            }
                        },
                    },
                },
                title: {
                    text: chartData.title,
                    align: "center",
                    style: {fontWeight: 600},
                },
                subtitle: {
                    text: chartData.subtitle,
                    align: "center",
                },
                grid: {
                    borderColor: "#f1f1f1",
                    strokeDashArray: 4,
                },
            };

            chartInstances[id] = new ApexCharts(element, options);
            chartInstances[id].render();
        }

            function initCharts() {
                setTimeout(() => {
                    if (typeof ApexCharts === 'undefined') {
                        console.error('ApexCharts library not loaded');
                        return;
                    }

                    destroyAllCharts();

                    initHorizontalBarChart("top-enrolled-courses", @json($topEnrolledCourses, JSON_THROW_ON_ERROR));
                    initHorizontalBarChart("top-rating-courses", @json($topRatingCourses, JSON_THROW_ON_ERROR));
                    initTreemapChart("course-category-distribution", @json($courseCategoryDistribution, JSON_THROW_ON_ERROR));
                    initTreemapChart("revenue-category-distribution", @json($revenueCategoryDistribution, JSON_THROW_ON_ERROR));
                    initPlatformPerformanceChart("platform_performance_trends", @json($platformPerformanceTrends, JSON_THROW_ON_ERROR));
                }, 100);
            }

            document.addEventListener("DOMContentLoaded", initCharts);

            document.addEventListener('livewire:navigated', initCharts);
        })();
    </script>
@endpush

