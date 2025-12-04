<div class="card h-100">
    <div class="card-header align-items-center d-flex justify-content-between border-bottom-dashed py-3">
        <div class="d-flex align-items-center gap-2">
            <h4 class="card-title mb-0">
                <i class="ri-community-line align-middle me-1 text-success"></i> Danh sách Lớp học
            </h4>
            <span class="badge bg-success-subtle text-success rounded-pill">
                {{ $classrooms->total() }} </span>
        </div>

        <div class="d-flex gap-2">
            <div class="search-box" style="width: 200px;">
                <input type="text"
                       class="form-control form-control-sm bg-light border-light"
                       wire:model.live.debounce.300ms="search"
                       placeholder="Tìm tên hoặc mã lớp...">
                <i class="ri-search-2-line search-icon"></i>
            </div>

            <button type="button"
                    class="btn btn-light btn-sm btn-icon text-muted"
                    wire:click="toggleSort"
                    data-bs-toggle="tooltip"
                    title="Sắp xếp: {{ $sortDirection === 'asc' ? 'Cũ nhất' : 'Mới nhất' }}">
                @if($sortDirection === 'desc')
                    <i class="ri-sort-desc"></i>
                @else
                    <i class="ri-sort-asc"></i>
                @endif
            </button>

            <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#create-classroom-modal">
                <i class="ri-add-line align-middle me-1"></i> Thêm Lớp
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-nowrap align-middle mb-0">
                <thead class="table-light text-muted">
                <tr>
                    <th scope="col" class="text-center" style="width: 50px;">#</th>
                    <th scope="col" class="ps-3">Mã Lớp</th>
                    <th scope="col">Tên Lớp</th>
                    <th scope="col">Thuộc Chuyên Ngành</th>
                    <th scope="col" class="text-center">Sĩ số</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col" class="text-end pe-3" style="width: 50px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($classrooms as $class)
                    <tr wire:key="class-{{ $class->id }}">
                        <td class="text-center text-muted">
                            {{ $classrooms->firstItem() + $loop->index }}
                        </td>

                        <td class="ps-3">
                                <span class="badge bg-info-subtle text-info fs-12 font-monospace">
                                    {{ $class->code }}
                                </span>
                        </td>

                        <td>
                            <a href="javascript:void(0);"
                               class="text-reset fw-medium text-truncate d-block"
                               style="max-width: 200px;"
                               wire:click="$dispatch('view-classroom-details', { id: {{ $class->id }} })">
                                {{ $class->name }}
                            </a>
                        </td>

                        <td>
                            @if($class->major)
                                <div class="d-flex flex-column">
                                        <span class="fw-medium text-primary fs-13 text-truncate" style="max-width: 200px;">
                                            {{ $class->major->name }}
                                        </span>
                                    @if($class->major->faculty)
                                        <span class="text-muted fs-11">
                                                <i class="ri-building-line me-1"></i> {{ $class->major->faculty->name }}
                                            </span>
                                    @endif
                                </div>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        <i class="ri-error-warning-line me-1"></i> Chưa gán ngành
                                    </span>
                            @endif
                        </td>

                        <td class="text-center">
                                <span class="badge bg-success-subtle text-success border border-success-subtle fs-11">
                                    <i class="ri-user-3-line me-1"></i>
                                    {{ number_format($class->student_profiles_count ?? 0) }} SV
                                </span>
                        </td>

                        <td>
                            <div class="text-muted fs-12">
                                <i class="ri-calendar-line me-1"></i>
                                {{ $class->created_at->format('d/m/Y') }}
                            </div>
                        </td>

                        <td class="text-end pe-3">
                            <div class="dropdown">
                                <button class="btn btn-ghost-secondary btn-icon btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-more-2-fill fs-14"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item" wire:click="$dispatch('view-classroom-details', { id: {{ $class->id }} })">
                                            <i class="ri-eye-line me-2 text-muted"></i> Chi tiết
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$dispatch('edit-classroom', { id: {{ $class->id }} })">
                                            <i class="ri-pencil-line me-2 text-muted"></i> Sửa
                                        </button>
                                    </li>
                                    <li class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item text-danger" wire:click="$dispatch('init-delete-classroom', { id: {{ $class->id }} })">
                                            <i class="ri-delete-bin-line me-2"></i> Xóa
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="avatar-lg mx-auto mb-3">
                                <div class="avatar-title bg-light rounded-circle text-primary display-5">
                                    <i class="ri-search-2-line"></i>
                                </div>
                            </div>
                            <h5 class="text-muted">Không tìm thấy lớp học nào</h5>
                            <p class="text-muted mb-0">Thử tìm kiếm với từ khóa khác.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($classrooms->hasPages())
        <div class="card-footer border-top-dashed py-2">
            {{ $classrooms->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
