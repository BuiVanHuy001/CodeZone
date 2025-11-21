<div class="row">
    {{--    <div wire:loading wire:target="approve, reject, suspend">--}}
    {{--        <x-client.share-ui.loading-effect/>--}}
    {{--    </div>--}}
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Students</h4>
        </div>
    </div>

    <x-admin.shared-ui.charts.pie
        id="total_students_chart" :title="$totalStudentsChart['title']"
    />

    <x-admin.shared-ui.charts.pie
        id="internal_dist_chart" :title="$internalDistributionChart['title']"
    />

    <x-admin.shared-ui.charts.pie
        id="external_dist_chart" :title="$externalDistributionChart['title']"
    />

    <div class="col-12">
        <button type="button"
                class="btn btn-primary btn-label waves-effect waves-light mb-3 float-end"
                data-bs-toggle="modal"
                data-bs-target="#import-student-modal"
        >
            <i class="ri-upload-cloud-2-line label-icon align-middle fs-16 me-2"></i> Import Student
        </button>
    </div>

    <x-admin.shared-ui.data-table-card tableTitle="Internal Students" tableId="internalStudentsTable">
        <x-slot:tableHeader>
            <th>Student code</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date of birth</th>
            <th>Gender</th>
            <th>Faculty - Major</th>
            <th>Classroom</th>
            <th>Enrolled Courses</th>
            <th>Enrollment year</th>
            <th>Action</th>
        </x-slot:tableHeader>

        <x-slot:tableBody>
            @foreach($internalStudentTable as $index => $student)
                <tr>
                    <td>{{ $student->studentCodeText }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->dobText }}</td>
                    <td>{{ $student->genderText }}</td>
                    <td>
                        <p class="fw-bold cursor-pointer text-primary">
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  data-bs-title="{{ $student->facultyNameText }}"
                            >{{ $student->facultyCodeText }}</span> -
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  data-bs-title="Ngành {{ $student->majorNameText }}"
                            >{{ $student->majorCodeText }}</span>
                        </p>
                    </td>
                    <td>
                        <p class="fw-bold cursor-pointer text-primary">
                            <span data-bs-toggle="tooltip"
                                  data-bs-placement="top"
                                  data-bs-title="{{ $student->classRoomNameText }}"
                            >{{ $student->classRoomCodeText }}</span>
                        </p>
                    </td>
                    <td>{{ $student->enrolledCountText }}</td>
                    <td>{{ $student->enrollmentYearText }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button onclick="" class="btn btn-xl text-secondary dropdown-item">
                                        <i class="ri-checkbox-circle-line align-bottom me-2"></i>Show Details
                                    </button>
                                </li>
                                <li>
                                    <button onclick="" class="btn btn-xl text-danger dropdown-item">
                                        <i class="ri-close-circle-fill align-bottom me-2"></i>Banned
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:tableBody>
    </x-admin.shared-ui.data-table-card>

    <x-admin.shared-ui.data-table-card tableTitle="External Students" tableId="externalStudentsTable">
        <x-slot:tableHeader>
            <th>Name</th>
            <th>Email</th>
            <th>Enrolled Courses</th>
            <th>Action</th>
        </x-slot:tableHeader>

        <x-slot:tableBody>
            @foreach($externalStudentTable as $index => $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->enrolledCountText }}</td>
                    <td>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill align-middle"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <button onclick="" class="btn btn-xl text-secondary dropdown-item">
                                        <i class="ri-checkbox-circle-line align-bottom me-2"></i>Show Details
                                    </button>
                                </li>
                                <li>
                                    <button onclick="" class="btn btn-xl text-danger dropdown-item">
                                        <i class="ri-close-circle-fill align-bottom me-2"></i>Banned
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:tableBody>
    </x-admin.shared-ui.data-table-card>

    <livewire:admin.student.components.import-modal/>
</div>

@assets
<link rel="stylesheet" href="{{ Vite::asset('resources/assets/admin/libs/dropzone/dropzone.css') }}"/>
@endassets

@push('scripts')
    <script src="{{ Vite::asset('resources/assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        window.__studentCharts = window.__studentCharts || {};

        function getChartColorsArray(id) {
            const el = document.getElementById(id);
            if (!el) return null;
            const colorsAttr = el.getAttribute("data-colors");
            if (!colorsAttr) return null;
            let colors;
            try {
                colors = JSON.parse(colorsAttr);
            } catch (e) {
                return null;
            }
            return colors.map(value => {
                const color = value.replace(" ", "");
                if (color.indexOf(",") === -1) {
                    return getComputedStyle(document.documentElement).getPropertyValue(color) || color;
                }
                const [base, opacity] = color.split(",");
                const baseVal = getComputedStyle(document.documentElement).getPropertyValue(base);
                return `rgba(${baseVal}, ${opacity})`;
            });
        }

        function initPieChart(elementId, seriesData, labelsData) {
            const el = document.getElementById(elementId);
            if (!el) {
                return;
            }
            if (window.__studentCharts[elementId]) {
                try {
                    window.__studentCharts[elementId].destroy();
                } catch (e) {
                }
                delete window.__studentCharts[elementId];
            }
            const colors = getChartColorsArray(elementId);
            const options = {
                series: Array.isArray(seriesData) ? seriesData : [],
                labels: Array.isArray(labelsData) ? labelsData : [],
                legend: {position: "bottom"},
                colors: colors || undefined,
                chart: {width: "100%", type: "pie"},
            };
            const chart = new ApexCharts(el, options);
            chart.render();
            window.__studentCharts[elementId] = chart;
        }

        function initializeStudentDataTables() {
            const tableDefinitions = [
                {
                    selector: '#internalStudentsTable', opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-fill me-1 align-bottom"></i>Export to Excel',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Excel',
                                filename: 'Active_Student_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-fill me-1 align-bottom"></i>Export to PDF',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'PDF',
                                filename: 'Active_Student_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-fill me-1 align-bottom"></i>Print',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Print',
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            }
                        ]
                    }
                },
                {
                    selector: '#externalStudentsTable',
                    opts: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                text: '<i class="ri-file-excel-2-fill me-1 align-bottom"></i>Export to Excel',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Excel',
                                filename: 'Active_Student_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="ri-file-pdf-fill me-1 align-bottom"></i>Export to PDF',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'PDF',
                                filename: 'Active_Student_' + new Date().toISOString().split('T')[0],
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="ri-printer-fill me-1 align-bottom"></i>Print',
                                className: 'btn btn-outline-secondary',
                                titleAttr: 'Print',
                                exportOptions: {
                                    columns: ':not(:last-child)'
                                }
                            }
                        ]
                    }
                }
            ];
            if (window.AppDataTableHelper && window.AppDataTableHelper.initializeDataTables) {
                window.AppDataTableHelper.initializeDataTables(tableDefinitions);
            } else {
                console.error('DataTable initializer (AppDataTableHelper) not found.');
            }
        }

        function renderStudentCharts(payload) {
            if (!payload) return;
            const {total, internal, external} = payload;
            if (total) initPieChart('total_students_chart', total.data, total.labels);
            if (internal) initPieChart('internal_dist_chart', internal.data, internal.labels);
            if (external) initPieChart('external_dist_chart', external.data, external.labels);
        }

        function initStudentPage() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            if (!$.fn.DataTable.isDataTable('#internalStudentsTable')) {
                initializeStudentDataTables();
            }
            renderStudentCharts({
                total: @json($totalStudentsChart),
                internal: @json($internalDistributionChart),
                external: @json($externalDistributionChart),
            });
        }

        document.addEventListener('livewire:initialized', function () {
            if (window.Livewire) {
                Livewire.on('students-charts-updated', (charts) => {
                    renderStudentCharts(charts);
                });
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            initStudentPage();
        });

        document.addEventListener('livewire:navigated', function () {
            initStudentPage();
        });
    </script>
@endpush
