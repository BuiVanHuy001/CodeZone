<div class="card h-100">
    <div class="card-header d-flex align-items-center justify-content-between border-bottom-dashed py-3">
        <div class="d-flex align-items-center gap-2">
            <h4 class="card-title mb-0">
                <i class="ri-building-4-line align-middle me-1 text-primary"></i> Khoa
            </h4>
            <span class="badge bg-primary-subtle text-primary rounded-pill">{{ count($faculties) }}</span>
        </div>

        <div class="d-flex gap-2">
            <div class="search-box" style="width: 140px;">
                <input type="text"
                       class="form-control form-control-sm bg-light border-light"
                       wire:model.live="search"
                       placeholder="Tìm kiếm...">
                <i class="ri-search-2-line search-icon"></i>
            </div>

            <button type="button"
                    class="btn btn-light btn-sm btn-icon text-muted"
                    wire:click="toggleSort"
                    data-bs-toggle="tooltip"
                    title="Sắp xếp theo ngày tạo">
                @if($sortDirection === 'desc')
                    <i class="ri-sort-desc"></i>
                @else
                    <i class="ri-sort-asc"></i>
                @endif
            </button>

            <button class="btn btn-success btn-sm btn-icon" wire:click="$dispatch('open-modal', { id: 'createFacultyModal' })" data-bs-toggle="tooltip" title="Thêm khoa mới">
                <i class="ri-add-line fs-5"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">

            <table class="table table-hover table-nowrap align-middle mb-0">
                <thead class="table-light text-muted sticky-top" style="top: 0; z-index: 1;">
                <tr>
                    <th class="ps-3">Thông tin Khoa</th>
                    <th class="text-center">Thống kê</th>
                    <th class="text-end pe-3"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($faculties as $faculty)
                    <tr wire:key="faculty-{{ $faculty->id }}">
                        <td class="ps-3">
                            <div class="d-flex align-items-center" wire:click="$dispatch('view-details', { id: {{ $faculty->id }} })">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar-xs bg-light rounded-circle d-flex align-items-center justify-content-center cursor-pointer">
                                        <span class="text-primary fw-bold fs-12">{{ substr($faculty->code, 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="fs-13 mb-0 text-truncate cursor-pointer" style="max-width: 180px;">{{ $faculty->name }}</h6>
                                    <span class="text-muted fs-11">{{ $faculty->code }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <span class="badge bg-info-subtle text-info border border-info-subtle fs-11"
                                      data-bs-toggle="tooltip"
                                      title="Tổng số Chuyên ngành">
                                    <i class="ri-git-branch-line me-1"></i> {{ $faculty->majors_count ?? 0 }}
                                </span>

                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-11"
                                      data-bs-toggle="tooltip"
                                      title="Tổng số Giảng viên">
                                    <i class="ri-graduation-cap-line me-1"></i> {{ number_format($faculty->instructor_profiles_count ?? 0) }}
                                </span>

                                <span class="badge bg-success-subtle text-success border border-success-subtle fs-11"
                                      data-bs-toggle="tooltip"
                                      title="Tổng số Sinh viên">
                                    <i class="ri-user-line me-1"></i> {{ number_format($faculty->student_profiles_count ?? 0) }}
                                </span>
                            </div>
                        </td>
                        <td class="text-end pe-3">
                            <div class="dropdown">
                                <button class="btn btn-ghost-secondary btn-icon btn-sm" data-bs-toggle="dropdown">
                                    <i class="ri-more-2-fill fs-14"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item text-secondary" wire:click="$dispatch('view-details', { id: {{ $faculty->id }} })">
                                            <i class="ri-eye-line me-2"></i>
                                            Chi tiết
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-warning" wire:click="$dispatch('show-edit', { id: {{ $faculty->id }} })">
                                            <i class="ri-pencil-line me-2"></i> Sửa
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-danger" wire:click="$dispatch('init-delete-faculty', { id: {{ $faculty->id }} })">
                                            <i class="ri-delete-bin-7-line me-2"></i>
                                            Xóa
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if($faculties->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">
                            <i class="ri-search-2-line fs-4 d-block mb-1"></i>
                            <small>Không có dữ liệu</small>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
