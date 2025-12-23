<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Quản lý Giảng viên</h4>
            <div class="page-title-right">
                <button type="button" class="btn btn-primary btn-label waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#create-instructor-modal">
                    <i class="ri-user-add-line label-icon align-middle fs-16 me-2"></i> Thêm Giảng viên
                </button>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
            <x-admin.shared-ui.counter-card title="Đang hoạt động" count="{{ $stats['active'] ?? 0 }}" icon="ri-checkbox-circle-fill" color="success"/>
            <x-admin.shared-ui.counter-card title="Chờ duyệt" count="{{ $stats['pending'] ?? 0 }}" icon="ri-time-fill" color="warning"/>
            <x-admin.shared-ui.counter-card title="Đã đình chỉ" count="{{ $stats['suspended'] ?? 0 }}" icon="ri-prohibited-fill" color="danger"/>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Danh sách giảng viên</h5>
                    <div class="flex-shrink-0">
                        <ul class="nav nav-tabs-custom card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#active" role="tab">
                                    <i class="ri-user-follow-line me-1 align-bottom"></i> Đang hoạt động
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#pending" role="tab">
                                    <i class="ri-user-received-line me-1 align-bottom"></i> Chờ duyệt
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#suspended" role="tab">
                                    <i class="ri-user-unfollow-line me-1 align-bottom"></i> Đã khóa
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">
                    <div class="tab-pane active" id="active" role="tabpanel">
                        <div class="p-3">
                            <div class="row g-3 mb-4">
                                <div class="col-lg-3 col-md-6">
                                    <div class="search-box">
                                        <input type="text" class="form-control" placeholder="Tìm tên, email..." wire:model.live.debounce.300ms="searchActive">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <select class="form-select" wire:model.live="selectedFaculty">
                                        <option value="">-- Tất cả Khoa --</option>
                                        @if(isset($faculties))
                                            @foreach($faculties as $faculty)
                                                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <select class="form-select" wire:model.live="selectedMajor" @disabled(empty($selectedFaculty))>
                                        <option value="">-- Tất cả Ngành --</option>
                                        @if(isset($majors))
                                            @foreach($majors as $major)
                                                <option value="{{ $major->id }}">{{ $major->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <select class="form-select" wire:model.live="sortField">
                                        <option value="created_at">Ngày tạo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">STT</th>
                                        <th>Giảng viên</th>
                                        <th>Chuyên môn</th>
                                        <th class="text-center">Khóa học</th>
                                        <th class="text-center">Học viên</th>
                                        <th class="text-center">Đánh giá</th>
                                        <th>Ngày tham gia</th>
                                        <th class="text-end">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($instructors['active'] as $instructor)
                                        <tr wire:key="active-{{ $instructor->id }}">
                                            <td>{{ $loop->iteration + ($instructors['active']->currentPage() - 1) * $instructors['active']->perPage() }}</td>

                                            <td>
                                                <h6 wire:click="$dispatch('view-instructor-details', { id: '{{ $instructor->id }}' })" class="fs-14 mb-0 fw-semibold cursor-pointer">{{ $instructor->name }}</h6>
                                                <small class="text-muted">{{ $instructor->email }}</small>
                                            </td>

                                            <td>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                                    {{ $instructor->instructorProfile->major->name ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="fw-medium">{{ number_format($instructor->instructorProfile->course_count ?? 0) }}</span>
                                            </td>

                                            <td class="text-center">
                                                <span class="fw-medium text-success">{{ number_format($instructor->instructorProfile->student_count ?? 0) }}</span>
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center gap-1 text-warning">
                                                    <i class="ri-star-fill"></i>
                                                    <span class="fw-bold text-dark">{{ number_format($instructor->instructorProfile->rating ?? 0, 1) }}</span>
                                                    <span class="text-muted fw-normal fs-11">({{ $instructor->instructorProfile->review_count ?? 0 }})</span>
                                                </div>
                                            </td>

                                            <td>
                                                {{ $instructor->created_at ? $instructor->created_at->format('d/m/Y') : 'N/A' }}
                                            </td>

                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-soft-secondary btn-sm btn-icon" type="button" data-bs-toggle="dropdown">
                                                        <i class="ri-more-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <button class="dropdown-item text-warning"
                                                                    onclick="showConfirmAction(@this, '{{ $instructor->id }}', 'suspend', { title: 'Đình chỉ?', confirmButtonText: 'Đình chỉ', confirmButtonColor: '#ffc107' })">
                                                                <i class="ri-prohibited-line me-2"></i> Đình chỉ
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4 text-muted">Không tìm thấy dữ liệu
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $instructors['active']->links('pagination::bootstrap-5') }}</div>
                        </div>
                    </div>

                    <div class="tab-pane" id="pending" role="tabpanel">
                        <div class="p-3">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="search-box">
                                        <input type="text" class="form-control" placeholder="Tìm hồ sơ..." wire:model.live.debounce.300ms="searchPending">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">STT</th>
                                        <th>Ứng viên</th>
                                        <th>Chuyên môn</th>
                                        <th>Công việc hiện tại</th>
                                        <th>Ngày đăng ký</th>
                                        <th class="text-end">Duyệt hồ sơ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($instructors['pending'] as $instructor)
                                        <tr wire:key="pending-{{ $instructor->id }}">
                                            <td>{{ $loop->iteration + ($instructors['pending']->currentPage() - 1) * $instructors['pending']->perPage() }}</td>

                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-warning-subtle text-warning">
                                                            {{ strtoupper(substr($instructor->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="fs-14 mb-0 fw-bold">{{ $instructor->name }}</h6>
                                                        <small class="text-muted">{{ $instructor->email }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                                    {{ $instructor->instructorProfile->major->name ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td>{{ $instructor->instructorProfile->current_job ?? '---' }}</td>
                                            <td>{{ $instructor->created_at ? $instructor->created_at->format('d/m/Y H:i') : 'N/A' }}</td>

                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button class="btn btn-sm btn-soft-success"
                                                            onclick="showConfirmAction(@this, '{{ $instructor->id }}', 'approve', { title: 'Duyệt giảng viên?', confirmButtonText: 'Chấp thuận', confirmButtonColor: '#0ab39c' })">
                                                        <i class="ri-check-double-line"></i> Duyệt
                                                    </button>
                                                    <button class="btn btn-sm btn-soft-danger"
                                                            onclick="showConfirmAction(@this, '{{ $instructor->id }}', 'reject', { title: 'Từ chối?', confirmButtonText: 'Từ chối', confirmButtonColor: '#f06548' })">
                                                        <i class="ri-close-line"></i> Từ chối
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Không có hồ sơ chờ
                                                duyệt
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $instructors['pending']->links('pagination::bootstrap-5') }}</div>
                        </div>
                    </div>

                    <div class="tab-pane" id="suspended" role="tabpanel">
                        <div class="p-3">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="search-box">
                                        <input type="text" class="form-control" placeholder="Tìm tài khoản..." wire:model.live.debounce.300ms="searchSuspended">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-nowrap align-middle mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">STT</th>
                                        <th>Giảng viên</th>
                                        <th>Chuyên môn</th>
                                        <th>Ngày khóa</th>
                                        <th class="text-end">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($instructors['suspended'] as $instructor)
                                        <tr wire:key="suspended-{{ $instructor->id }}" class="bg-light-subtle">
                                            <td>{{ $loop->iteration + ($instructors['suspended']->currentPage() - 1) * $instructors['suspended']->perPage() }}</td>

                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3 opacity-75">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-secondary text-white">
                                                            <i class="ri-prohibited-line"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="fs-14 mb-0 text-decoration-line-through">{{ $instructor->name }}</h6>
                                                        <small class="text-muted">{{ $instructor->email }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="text-muted">{{ $instructor->instructorProfile->major->name ?? 'N/A' }}</span>
                                            </td>

                                            <td class="text-danger">
                                                {{ $instructor->updated_at ? $instructor->updated_at->format('d/m/Y') : 'N/A' }}
                                            </td>

                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary"
                                                        onclick="showConfirmAction(@this, '{{ $instructor->id }}', 'restore', { title: 'Khôi phục?', confirmButtonText: 'Khôi phục ngay', confirmButtonColor: '#0ab39c' })">
                                                    <i class="ri-refresh-line align-bottom me-1"></i> Khôi phục
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">{{ $instructors['suspended']->links('pagination::bootstrap-5') }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <livewire:admin.instructor.components.create-modal/>
    <livewire:admin.instructor.components.instructor-detail/>
</div>
