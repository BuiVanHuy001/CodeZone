<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Khoa/Ngành/Lớp</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card card-animate border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng số Khoa</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $faculties->count() }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                    <i class="ri-building-2-line text-primary"></i>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card card-animate border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng Chuyên Ngành</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $majors->count() }}</h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                    <i class="ri-git-branch-line text-info"></i>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card card-animate border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng Sinh viên</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                {{ number_format($majors->sum('student_profiles_count')) }}
                            </h4>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                    <i class="ri-user-star-line text-success"></i>
                                </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                    <h4 class="card-title mb-0 flex-grow-1">
                        <i class="ri-building-4-line align-middle me-1"></i> Danh sách Khoa
                    </h4>
                    <div class="flex-shrink-0">
                        <button type="button"
                                class="btn btn-soft-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#create-faculty-modal">
                            <i class="ri-add-line align-middle"></i> Thêm Khoa
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">Thông tin Khoa</th>
                                <th scope="col" class="text-center">Thống kê</th>
                                <th scope="col" style="width: 50px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($faculties as $faculty)
                                <tr>
                                    <td>
                                        <div class="fs-14 my-1">
                                            <a href="javascript:void(0);" class="text-reset fw-bold me-1" wire:click="$dispatch('view-faculty-details', { id: {{ $faculty->id }} })">
                                                {{ $faculty->name }}
                                            </a>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $faculty->code }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <div class="d-flex flex-column align-items-center" data-bs-toggle="tooltip" title="Tổng số Chuyên ngành">
                                            <span class="badge bg-info-subtle text-info badge-border fs-12 mb-1">
                                                <i class="ri-git-branch-line me-1 align-bottom"></i>{{ $faculty->majors->count() }}
                                            </span>
                                                <span class="text-muted fs-10">Ngành</span>
                                            </div>

                                            <div class="d-flex flex-column align-items-center" data-bs-toggle="tooltip" title="Tổng số Giảng viên">
                                            <span class="badge bg-warning-subtle text-warning badge-border fs-12 mb-1">
                                                <i class="ri-graduation-cap-line me-1 align-bottom"></i>{{ number_format($faculty->instructor_profiles_count) }}
                                            </span>
                                                <span class="text-muted fs-10">Giảng viên</span>
                                            </div>

                                            <div class="d-flex flex-column align-items-center" data-bs-toggle="tooltip" title="Tổng số Sinh viên">
                                            <span class="badge bg-success-subtle text-success badge-border fs-12 mb-1">
                                                <i class="ri-user-line me-1 align-bottom"></i>{{ number_format($faculty->student_profiles_count) }}
                                            </span>
                                                <span class="text-muted fs-10">Sinh viên</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button class="btn btn-xl text-secondary dropdown-item"
                                                            wire:click="$dispatch('view-faculty-details', { id: {{ $faculty->id }} })">
                                                        <i class="ri-eye-line align-bottom me-2"></i>Xem chi tiết
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="btn btn-xl text-warning dropdown-item"
                                                            wire:click="$dispatch('edit-faculty', { id: {{ $faculty->id }} })">
                                                        <i class="ri-edit-2-fill align-bottom me-2"></i> Sửa
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                            class="btn btn-xl text-danger dropdown-item"
                                                            wire:click="$dispatch('init-delete-faculty', { id: {{ $faculty->id }} })">
                                                        <i class="ri-delete-bin-fill align-bottom me-2"></i> Xóa
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                    <h4 class="card-title mb-0 flex-grow-1">
                        <i class="ri-git-branch-line align-middle me-1"></i> Chuyên ngành Đào tạo
                    </h4>
                    <div class="flex-shrink-0">
                        <button type="button"
                                class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#create-major-modal">
                            <i class="ri-add-line align-middle"></i> Thêm Ngành
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">Thông tin Ngành</th>
                                <th scope="col">Khoa</th>
                                <th scope="col" class="text-center">Thống kê</th>
                                <th scope="col" style="width: 50px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($majors as $major)
                                <tr>
                                    <td>
                                        <h5 class="fs-14 my-1">
                                            <a href="javascript:void(0);" class="text-reset fw-bold"
                                               wire:click="$dispatch('view-major-details', { id: {{ $major->id }} })">
                                                {{ $major->name }}
                                            </a>
                                        </h5>
                                        <span class="text-muted fs-12">{{ $major->code }}</span>
                                    </td>

                                    <td>
                                        @if($major->faculty)
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $major->faculty->name }}
                                    </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Chưa gán</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <div class="d-flex flex-column align-items-center" data-bs-toggle="tooltip" title="Số lượng Giảng viên">
                                        <span class="badge bg-warning-subtle text-warning badge-border fs-12 mb-1">
                                            <i class="ri-graduation-cap-line me-1 align-bottom"></i>
                                            {{ number_format($major->instructor_profiles_count) }}
                                        </span>
                                                <span class="text-muted fs-10">Giảng viên</span>
                                            </div>

                                            <div class="d-flex flex-column align-items-center" data-bs-toggle="tooltip" title="Số lượng Sinh viên">
                                        <span class="badge bg-success-subtle text-success badge-border fs-12 mb-1">
                                            <i class="ri-user-line me-1 align-bottom"></i>
                                            {{ number_format($major->student_profiles_count) }}
                                        </span>
                                                <span class="text-muted fs-10">Sinh viên</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button class="btn btn-xl text-secondary dropdown-item"
                                                            wire:click="$dispatch('view-major-details', { id: {{ $major->id }} })">
                                                        <i class="ri-eye-line align-bottom me-2"></i>Xem chi tiết
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="btn btn-xl text-warning dropdown-item"
                                                            wire:click="$dispatch('edit-major', { id: {{ $major->id }} })">
                                                        <i class="ri-edit-2-fill align-bottom me-2"></i> Edit
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                            class="btn btn-xl text-danger dropdown-item"
                                                            wire:click="$dispatch('init-delete-major', { id: {{ $major->id }} })">
                                                        <i class="ri-delete-bin-fill align-bottom me-2"></i> Xóa
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header align-items-center d-flex border-bottom-dashed">
                    <h4 class="card-title mb-0 flex-grow-1">
                        <i class="ri-community-line align-middle me-1"></i> Danh sách Lớp học
                    </h4>
                    <div class="flex-shrink-0">
                        <button type="button"
                                class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#create-classroom-modal">
                            <i class="ri-add-line align-middle"></i> Thêm Lớp
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                            <tr>
                                <th>Mã Lớp</th>
                                <th>Tên Lớp</th>
                                <th>Thuộc Chuyên Ngành</th>
                                <th class="text-center">Sĩ số</th>
                                <th>Ngày tạo</th>
                                <th style="width: 50px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classrooms as $class)
                                <tr>
                                    <td>
                                        <span class="badge bg-info-subtle text-info fs-12">
                                            {{ $class->code }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="javascript:void(0);" class="text-reset fw-medium"
                                           wire:click="$dispatch('view-classroom-details', { id: {{ $class->id }} })">
                                            {{ $class->name }}
                                        </a>
                                    </td>

                                    <td>
                                        @if($class->major)
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="fs-13 mb-0 text-primary">
                                                        {{ $class->major->name }}
                                                    </h6>
                                                    @if($class->major->faculty)
                                                        <span class="text-muted fs-11">
                                                            Khoa: {{ $class->major->faculty->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-danger fs-12">Chưa gán ngành</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle fs-11">
                                            <i class="ri-user-3-line me-1"></i>
                                            {{ number_format($class->student_profiles_count) }} SV
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-muted fs-12">
                                            {{ $class->created_at->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown">
                                                <i class="ri-more-2-fill"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button class="btn btn-xl text-secondary dropdown-item"
                                                            wire:click="$dispatch('view-classroom-details', { id: {{ $class->id }} })">
                                                        <i class="ri-eye-line align-bottom me-2"></i> Chi tiết
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="btn btn-xl text-warning dropdown-item"
                                                            wire:click="$dispatch('edit-classroom', { id: {{ $class->id }} })">
                                                        <i class="ri-edit-2-fill align-bottom me-2"></i> Sửa
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button"
                                                            class="btn btn-xl text-danger dropdown-item"
                                                            onclick="showConfirmAction(
                                                                @this,
                                                                '{{ $class->id }}',
                                                                'deleteClassroom',
                                                                {
                                                                    title: 'Xóa Lớp {{ $class->code }}?',
                                                                    text: 'Sinh viên thuộc lớp này sẽ bị mất thông tin lớp học.',
                                                                    confirmButtonText: 'Xóa ngay',
                                                                    confirmButtonColor: '#d33'
                                                                }
                                                            )">
                                                        <i class="ri-delete-bin-fill align-bottom me-2"></i> Xóa
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <livewire:admin.academic.components.faculty.create-faculty/>
    <livewire:admin.academic.components.faculty.edit-faculty/>
    <livewire:admin.academic.components.faculty.faculty-detail/>
    <livewire:admin.academic.components.faculty.delete-faculty/>

    <livewire:admin.academic.components.major.create-major/>
    <livewire:admin.academic.components.major.edit-major/>
    <livewire:admin.academic.components.major.major-detail/>
    <livewire:admin.academic.components.major.delete-major/>

    <livewire:admin.academic.components.classroom.create-classroom/>
    <livewire:admin.academic.components.classroom.classroom-detail/>
    <livewire:admin.academic.components.classroom.edit-classroom/>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {

            const handleModal = (modalId, action = 'show') => {
                const selector = modalId.startsWith('#') ? modalId : `#${modalId}`;
                const modalEl = document.querySelector(selector);

                if (modalEl) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal[action]();
                } else {
                    console.warn(`Không tìm thấy modal với ID: ${selector}`);
                }
            };

            const openEvents = {
                'open-delete-faculty-modal': 'delete-faculty-modal',
                'open-edit-modal': 'edit-faculty-modal',
                'open-faculty-detail-modal': 'faculty-detail-modal',
                'open-major-detail-modal': 'major-detail-modal',
                'open-edit-major-modal': 'edit-major-modal',
                'open-delete-major-modal': 'delete-major-modal',
                'open-classroom-detail-modal': 'classroom-detail-modal',
                'open-edit-classroom-modal': 'edit-classroom-modal',
            };

            Object.entries(openEvents).forEach(([event, id]) => {
                Livewire.on(event, () => handleModal(id, 'show'));
            });

            Livewire.on('close-modal', (event) => {
                const modalId = event?.modalId || event?.[0]?.modalId || '#create-faculty-modal';
                handleModal(modalId, 'hide');
            });

            Livewire.on('swal-confirm-delete-empty', (event) => {
                const id = Array.isArray(event) ? event[0].id : event.id;

                Swal.fire({
                    title: 'Xóa Khoa này?',
                    text: "Khoa này chưa có chuyên ngành nào. Bạn có chắc muốn xóa?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Xóa luôn!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-empty-faculty-confirmed', {id: id});
                    }
                });
            });

            Livewire.on('swal-confirm-delete-empty-major', (event) => {
                const id = Array.isArray(event) ? event[0].id : event.id;

                Swal.fire({
                    title: 'Xóa Ngành này?',
                    text: "Chuyên ngành này chưa có dữ liệu (Lớp, GV, SV). Xóa ngay?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Xóa luôn!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-empty-major-confirmed', {id: id});
                    }
                });
            });
        });
    </script>
@endpush
