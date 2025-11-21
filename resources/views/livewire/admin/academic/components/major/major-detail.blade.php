<div>
    <div class="modal fade" id="major-detail-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết Chuyên ngành</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div wire:loading wire:target="loadMajor" class="text-center w-100 py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>

                    <div wire:loading.remove wire:target="loadMajor">
                        @if($major)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card bg-light mb-0 border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h5 class="card-title text-primary mb-1">{{ $major->name }}</h5>
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <span class="badge bg-white text-primary border border-primary-subtle">
                                                            {{ $major->code }}
                                                        </span>
                                                        <span class="text-muted">|</span>
                                                        <span class="text-muted">Khoa: <strong>{{ $major->faculty->name ?? 'N/A' }}</strong></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-4 mt-3">
                                                <div class="text-center px-3 border-end">
                                                    <h5 class="mb-0 text-primary">{{ $major->class_rooms_count }}</h5>
                                                    <small class="text-muted">Lớp học</small>
                                                </div>
                                                <div class="text-center px-3 border-end">
                                                    <h5 class="mb-0 text-warning">{{ number_format($major->instructor_profiles_count) }}</h5>
                                                    <small class="text-muted">Giảng viên</small>
                                                </div>
                                                <div class="text-center px-3">
                                                    <h5 class="mb-0 text-success">{{ number_format($major->student_profiles_count) }}</h5>
                                                    <small class="text-muted">Sinh viên</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mb-3 text-uppercase text-muted fs-12 fw-bold">Danh sách Lớp học trực thuộc</h6>

                            @if($major->classRooms->isEmpty())
                                <div class="alert alert-warning border-0 bg-warning-subtle text-warning">
                                    <i class="ri-alert-line me-1"></i> Chưa có lớp học nào được tạo cho chuyên ngành
                                    này.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-nowrap align-middle mb-0 table-striped">
                                        <thead class="table-light text-muted">
                                        <tr>
                                            <th>Mã Lớp</th>
                                            <th>Tên Lớp</th>
                                            <th class="text-center">Sĩ số</th>
                                            <th>Ngày tạo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($major->classRooms as $class)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-info-subtle text-info">{{ $class->code }}</span>
                                                </td>
                                                <td class="fw-medium">{{ $class->name }}</td>
                                                <td class="text-center">
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                            <i class="ri-user-line me-1 align-bottom"></i>
                                                            {{ number_format($class->student_profiles_count) }} Sinh viên
                                                        </span>
                                                </td>
                                                <td class="text-muted small">{{ $class->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
