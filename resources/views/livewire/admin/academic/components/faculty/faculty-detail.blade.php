<div>
    <div class="modal fade" id="facultyDetailModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-bottom-dashed pb-3">
                    <h5 class="modal-title d-flex align-items-center text-primary">
                        <i class="ri-building-4-line me-2"></i>
                        Chi tiết Khoa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if($faculty)
                    <div class="modal-body bg-light-subtle p-0">
                        <div class="p-4 bg-white border-bottom">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-md">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded-3 fs-2 fw-bold">
                                            {{ substr($faculty->code, 0, 2) }}
                                        </span>
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <h4 class="fw-bold text-dark mb-1">{{ $faculty->name }}</h4>

                                        <div class="d-flex align-items-center gap-3 text-muted mb-3">
                                        <span class="badge bg-light text-dark border font-monospace">
                                            <i class="ri-barcode-line me-1"></i> {{ $faculty->code }}
                                        </span>
                                            <span class="fs-13"><i class="ri-calendar-line me-1"></i> Tạo ngày: {{ $faculty->created_at->format('d/m/Y') }}</span>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-auto">
                                                <div class="border rounded p-2 px-3 text-center bg-light">
                                                    <h6 class="mb-0 text-info fw-bold">{{ $faculty->majors->count() }}</h6>
                                                    <small class="text-muted" style="font-size: 10px;">CHUYÊN
                                                        NGÀNH</small>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="border rounded p-2 px-3 text-center bg-light">
                                                    <h6 class="mb-0 text-warning fw-bold">{{ count($instructors) }}</h6>
                                                    <small class="text-muted" style="font-size: 10px;">GIẢNG
                                                        VIÊN</small>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="border rounded p-2 px-3 text-center bg-light">
                                                    <h6 class="mb-0 text-success fw-bold">{{ number_format($faculty->student_profiles_count ?? 0) }}</h6>
                                                    <small class="text-muted" style="font-size: 10px;">SINH VIÊN</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-shrink-0 ms-2">
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1"
                                            data-bs-dismiss="modal"
                                            wire:click="$dispatch('show-edit', { id: {{ $faculty->id }} })">
                                        <i class="ri-pencil-line"></i> Chỉnh sửa
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border-bottom">
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified mb-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-majors" role="tab">
                                        <i class="ri-git-branch-line me-1 align-middle"></i> Chuyên ngành
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab-instructors" role="tab">
                                        <i class="ri-user-voice-line me-1 align-middle"></i> Giảng viên
                                        <span class="badge bg-secondary-subtle text-secondary ms-1">{{ count($instructors) }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content p-4">
                            <div class="tab-pane active" id="tab-majors" role="tabpanel">
                                @if($faculty->majors->isEmpty())
                                    <div class="text-center py-4 text-muted">
                                        <i class="ri-inbox-line fs-1"></i>
                                        <p>Chưa có chuyên ngành nào.</p>
                                    </div>
                                @else
                                    <div class="table-responsive border rounded">
                                        <table class="table table-hover table-nowrap align-middle mb-0">
                                            <thead class="table-light text-muted">
                                            <tr>
                                                <th class="ps-3">Mã Ngành</th>
                                                <th>Tên Chuyên Ngành</th>
                                                <th class="text-center">Sinh viên</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($faculty->majors as $major)
                                                <tr>
                                                    <td class="ps-3 fw-medium text-info">{{ $major->code }}</td>
                                                    <td>{{ $major->name }}</td>
                                                    <td class="text-center">
                                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                                {{ number_format($major->student_profiles_count ?? 0) }}
                                                            </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="tab-pane" id="tab-instructors" role="tabpanel">
                                @if(empty($instructors))
                                    <div class="text-center py-4 text-muted">
                                        <i class="ri-user-unfollow-line fs-1"></i>
                                        <p>Chưa có giảng viên nào thuộc khoa này.</p>
                                    </div>
                                @else
                                    <div class="table-responsive border rounded">
                                        <table class="table table-hover table-nowrap align-middle mb-0">
                                            <thead class="table-light text-muted">
                                            <tr>
                                                <th class="ps-3">Giảng viên</th>
                                                <th>Chuyên môn</th>
                                                <th class="text-center">Khóa học</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($instructors as $instructor)
                                                <tr>
                                                    <td class="ps-3">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $instructor->avatar }}" class="avatar-xs rounded-circle me-2 object-fit-cover" alt="">
                                                            <div>
                                                                <h6 class="mb-0 fs-13">{{ $instructor->name }}</h6>
                                                                <small class="text-muted">{{ $instructor->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-medium fs-12">{{ $instructor->majorName }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                            <span class="badge bg-secondary-subtle text-secondary">
                                                                {{ $instructor->course_count }}
                                                            </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                @endif
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
