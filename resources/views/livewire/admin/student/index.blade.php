<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Quản lý Học viên</h4>
            <div class="page-title-right">
                <button type="button"
                        class="btn btn-primary btn-label waves-effect waves-light"
                        data-bs-toggle="modal"
                        data-bs-target="#importStudentModal">
                    <i class="ri-upload-cloud-2-line label-icon align-middle fs-16 me-2"></i> Import Student
                </button>
            </div>
        </div>
    </div>

    <x-admin.shared-ui.charts.pie id="total_students_chart" :title="$totalStudentsChart['title']"/>
    <x-admin.shared-ui.charts.pie id="internal_dist_chart" :title="$internalDistributionChart['title']"/>
    <x-admin.shared-ui.charts.pie id="external_dist_chart" :title="$externalDistributionChart['title']"/>

    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Danh sách học viên</h5>
                    <div class="flex-shrink-0">
                        <ul class="nav nav-tabs-custom card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#internal" role="tab">
                                    <i class="ri-building-line me-1 align-bottom"></i> Sinh viên trường
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#external" role="tab">
                                    <i class="ri-global-line me-1 align-bottom"></i> Vãng lai
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane active" id="internal" role="tabpanel">
                        <div class="p-3">
                            <div class="row g-3 mb-4">
                                <div class="col-lg-3 col-md-6">
                                    <div class="search-box">
                                        <input type="text" class="form-control" placeholder="Tìm tên, email, MSSV..."
                                               wire:model.live.debounce.300ms="searchInternal">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <select class="form-select" wire:model.live="selectedFaculty">
                                        <option value="">-- Tất cả Khoa --</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <select class="form-select" wire:model.live="selectedMajor" @disabled(empty($selectedFaculty))>
                                        <option value="">-- Tất cả Ngành --</option>
                                        @foreach($majors as $major)
                                            <option value="{{ $major->id }}">{{ $major->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <select class="form-select" wire:model.live="selectedClass" @disabled(empty($selectedMajor))>
                                        <option value="">-- Tất cả Lớp --</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->code }}
                                                - {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th class="ps-4">Sinh viên</th>
                                        <th>Mã SV</th>
                                        <th>Thông tin cá nhân</th>
                                        <th>Lớp/Ngành</th>
                                        <th>Học vụ</th>
                                        <th class="text-end pe-4">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($internalStudents as $student)
                                        <tr>
                                            <td>
                                                {{ ($internalStudents->currentPage() - 1) * $internalStudents->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="ps-4">
                                                <h5 class="fs-14 m-0 cursor-pointer">
                                                    <a wire:click="$dispatch('view-student-detail', { id: '{{ $student->id }}' })" class="text-reset">{{ $student->name }}</a>
                                                </h5>
                                                <small class="text-muted">{{ $student->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-body border border-light font-monospace">{{ $student->studentProfile->student_code }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span><i class="ri-calendar-event-line me-1 text-muted"></i> {{ $student->studentProfile->dobFormatted }}</span>
                                                    <span class="text-muted fs-12">
                                                        @if($student->studentProfile->gender === 1)
                                                            <i class="ri-women-line text-danger"></i>
                                                        @elseif($student->studentProfile->gender === 0)
                                                            <i class="ri-men-line text-info"></i>
                                                        @else
                                                            <i class="ri-user-line text-secondary"></i>
                                                        @endif
                                                        {{ $student->studentProfile->genderLabel }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-1 fs-13" data-bs-toggle="tooltip" title="{{ $student->studentProfile->classRoom->name }}">
                                                    Lớp: {{ $student->studentProfile->classRoom->code }}</h6>
                                                <p class="text-muted mb-0 fs-12" data-bs-toggle="tooltip" title="{{ $student->studentProfile->major->name }}">
                                                    Ngành: {{ $student->studentProfile->major->code }}</p>
                                                <p class="text-muted mb-0 fs-12" data-bs-toggle="tooltip" title="{{ $student->studentProfile->major->faculty->name }}">
                                                    Khoa: {{ $student->studentProfile->major->faculty->code }}</p>
                                            </td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success mb-1">{{ $student->studentProfile->enrollmentYearFormatted }}</span><br>
                                                <small class="text-muted">{{ $student->studentProfile->enrolled_count }}
                                                    khóa học</small>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown">
                                                        <i class="ri-more-fill align-middle"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <button class="dropdown-item text-info"
                                                                    wire:click="$dispatch('view-student-detail', { id: '{{ $student->id }}' }); $dispatch('open-details-modal')">
                                                                <i class="ri-eye-fill align-bottom me-2"></i> Xem hồ sơ
                                                                & Học vụ
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button type="button" class="dropdown-item text-primary"
                                                                    wire:click="$dispatch('show-edit-modal', { id: '{{ $student->id }}' })">
                                                                <i class="ri-pencil-fill align-bottom me-2"></i> Sửa
                                                                thông tin
                                                            </button>
                                                        </li>

                                                        <li class="dropdown-divider"></li>

                                                        @if($student->status === 'active')
                                                            <li>
                                                                <button class="dropdown-item text-warning"
                                                                        onclick="showConfirmAction(@this, '{{ $student->id }}', 'suspendStudent', {
                                                                                title: 'Đình chỉ sinh viên?',
                                                                                text: 'Sinh viên này sẽ không thể đăng nhập hệ thống.',
                                                                                confirmButtonText: 'Đình chỉ',
                                                                                confirmButtonColor: '#f1b44c'
                                                                            })">
                                                                    <i class="ri-prohibited-line align-bottom me-2"></i>
                                                                    Đình chỉ học
                                                                </button>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <button class="dropdown-item text-success"
                                                                        onclick="showConfirmAction(@this, '{{ $student->id }}', 'restoreStudent', {
                                                                                title: 'Kích hoạt lại?',
                                                                                text: 'Khôi phục quyền truy cập cho sinh viên này.',
                                                                                confirmButtonText: 'Kích hoạt',
                                                                                confirmButtonColor: '#0ab39c'
                                                                            })">
                                                                    <i class="ri-check-double-line align-bottom me-2"></i>
                                                                    Kích hoạt lại
                                                                </button>
                                                            </li>
                                                        @endif

                                                        <li>
                                                            <button class="dropdown-item text-danger"
                                                                    onclick="showConfirmAction(@this, '{{ $student->id }}', 'deleteStudent', {
                                                                        title: 'Xóa Sinh viên?',
                                                                        text: 'Cảnh báo: Hành động này không thể hoàn tác!',
                                                                        confirmButtonText: 'Xóa vĩnh viễn',
                                                                        confirmButtonColor: '#d33'
                                                                    })">
                                                                <i class="ri-delete-bin-fill align-bottom me-2"></i> Xóa
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Không tìm thấy dữ liệu
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3 align-items-center">
                                <div class="col-12">
                                    {{ $internalStudents->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="external" role="tabpanel">
                        <div class="p-3">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm..." wire:model.live.debounce.300ms="searchExternal">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>STT</th>
                                        <th class="ps-4">Học viên</th>
                                        <th>Thông tin</th>
                                        <th>Khóa học</th>
                                        <th class="text-end pe-4">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($externalStudents as $student)
                                        <tr>
                                            <td>
                                                {{ ($externalStudents->currentPage() - 1) * $externalStudents->perPage() + $loop->iteration }}
                                            </td>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-2">
                                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-warning-subtle text-warning">{{ substr($student->name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div><h5 class="fs-14 m-0">{{ $student->name }}</h5>
                                                        <small class="text-muted">{{ $student->email }}</small></div>
                                                </div>
                                            </td>
                                            <td>{{ $student->genderText }} / {{ $student->dobText }}</td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info">{{ $student->enrolledCountText }}</span>
                                            </td>
                                            <td class="text-end pe-4">...</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $externalStudents->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:admin.student.components.import-modal/>
    <livewire:admin.student.components.student-detail/>
    <livewire:admin.student.components.edit-student/>
</div>

@push('scripts')
    <script src="{{ Vite::asset('resources/assets/admin/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        window.__studentCharts = window.__studentCharts || {};

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

        function renderStudentCharts(payload) {
            if (!payload) return;
            const {total, internal, external} = payload;
            if (total) initPieChart('total_students_chart', total.data, total.labels);
            if (internal) initPieChart('internal_dist_chart', internal.data, internal.labels);
            if (external) initPieChart('external_dist_chart', external.data, external.labels);
        }

        function initTooltips() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(tooltipTriggerEl => {
                if (!bootstrap.Tooltip.getInstance(tooltipTriggerEl)) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                }
            });
        }

        document.addEventListener('livewire:initialized', function () {
            renderStudentCharts({
                total: @json($totalStudentsChart),
                internal: @json($internalDistributionChart),
                external: @json($externalDistributionChart),
            });

            initTooltips();

            Livewire.hook('morph.updated', () => {
                initTooltips();
            });
        });
    </script>
@endpush
