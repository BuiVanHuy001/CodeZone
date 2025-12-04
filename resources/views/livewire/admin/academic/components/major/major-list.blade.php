<div class="card h-100">
    <div class="card-header d-flex align-items-center justify-content-between border-bottom-dashed py-3">
        <div class="d-flex align-items-center gap-2">
            <h4 class="card-title mb-0">
                <i class="ri-git-branch-line align-middle me-1 text-info"></i> Chuyên ngành
            </h4>
            <span class="badge bg-info-subtle text-info rounded-pill">{{ count($majors) }}</span>
        </div>

        <div class="d-flex gap-2">
            <div class="search-box" style="width: 140px;">
                <input type="text" class="form-control form-control-sm bg-light border-light" wire:model.live="search" placeholder="Tìm ngành...">
                <i class="ri-search-2-line search-icon"></i>
            </div>
            <button class="btn btn-light btn-sm btn-icon text-muted" wire:click="toggleSort">
                @if($sortDirection === 'desc')
                    <i class="ri-sort-desc"></i>
                @else
                    <i class="ri-sort-asc"></i>
                @endif
            </button>
            <button class="btn btn-success btn-sm btn-icon" data-bs-toggle="modal" data-bs-target="#create-major-modal">
                <i class="ri-add-line fs-5"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-hover table-nowrap align-middle mb-0">
                <thead class="table-light text-muted sticky-top" style="top: 0; z-index: 1;">
                <tr>
                    <th class="ps-3">Thông tin Ngành</th>
                    <th>Khoa</th>
                    <th class="text-center">Thống kê</th>
                    <th class="text-end pe-3"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($majors as $major)
                    <tr wire:key="major-{{ $major->id }}">
                        <td class="ps-3">
                            <h6 wire:click="$dispatch('view-major-details', { id: {{ $major->id }} })" class="fs-14 mb-0 text-truncate cursor-pointer" style="max-width: 200px;">{{ $major->name }}</h6>
                            <span wire:click="$dispatch('view-major-details', { id: {{ $major->id }} })" class="text-muted fs-11">{{ $major->code }}</span>
                        </td>

                        <td>
                            @if($major->faculty)
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-11 text-truncate" style="max-width: 120px;">
                                    {{ $major->faculty->name }}
                                 </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Chưa gán</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <div class="d-flex flex-column align-items-center">
                        <span class="badge bg-warning-subtle text-warning badge-border fs-11 mb-1"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="Số lượng giảng viên {{ $major->name }}">
                            <i class="ri-graduation-cap-line me-1"></i>
                            {{ number_format($major->instructor_profiles_count ?? 0) }}
                        </span>
                                </div>

                                <div class="d-flex flex-column align-items-center">
                        <span class="badge bg-success-subtle text-success badge-border fs-11 mb-1"
                              data-bs-toggle="tooltip"
                              data-bs-placement="top"
                              title="Số lượng sinh viên {{ $major->name }}">
                            <i class="ri-user-line me-1"></i>
                            {{ number_format($major->student_profiles_count ?? 0) }}
                        </span>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-3">
                            <div class="dropdown">
                                <button class="btn btn-ghost-secondary btn-icon btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-more-2-fill fs-14"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item text-secondary" wire:click="$dispatch('view-major-details', { id: {{ $major->id }} })">
                                            <i class="ri-eye-line me-2"></i> Chi tiết
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-warning" wire:click="$dispatch('edit-major', { id: {{ $major->id }} })">
                                            <i class="ri-pencil-line me-2"></i> Sửa
                                        </button>
                                    </li>
                                    <li class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item text-danger" wire:click="$dispatch('init-delete-major', { id: {{ $major->id }} })">
                                            <i class="ri-delete-bin-line me-2"></i> Xóa
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if($majors->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Không có dữ liệu</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
