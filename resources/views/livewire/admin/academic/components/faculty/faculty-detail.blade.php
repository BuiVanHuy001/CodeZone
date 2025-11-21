<div>
    <div class="modal fade" id="faculty-detail-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-bottom-dashed">
                    <h5 class="modal-title text-primary">
                        <i class="ri-building-4-line me-1"></i> Chi tiết Khoa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light-subtle">
                    {{-- Loading State --}}
                    <div wire:loading wire:target="loadFaculty" class="text-center w-100 py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted">Đang tải dữ liệu...</p>
                    </div>

                    {{-- Content --}}
                    <div wire:loading.remove wire:target="loadFaculty">
                        @if($faculty)
                            {{-- 1. INFO CARD & STATS --}}
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h4 class="card-title text-primary fw-bold mb-1">{{ $faculty->name }}</h4>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                    Mã: {{ $faculty->code }}
                                                </span>
                                                <span class="text-muted">|</span>
                                                <span class="text-muted fs-12">Slug: {{ $faculty->slug }}</span>
                                            </div>
                                        </div>
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-primary-subtle text-primary rounded fs-3">
                                                {{ substr($faculty->code, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- [YÊU CẦU 1] Hiển thị số lượng --}}
                                    <div class="row g-0 border rounded overflow-hidden text-center">
                                        <div class="col-4 border-end bg-white py-3">
                                            <h5 class="mb-1 text-info">{{ $faculty->majors->count() }}</h5>
                                            <p class="text-muted mb-0 fs-12 text-uppercase">Chuyên ngành</p>
                                        </div>
                                        <div class="col-4 border-end bg-white py-3">
                                            <h5 class="mb-1 text-warning">{{ number_format($faculty->instructor_profiles_count) }}</h5>
                                            <p class="text-muted mb-0 fs-12 text-uppercase">Giảng viên</p>
                                        </div>
                                        <div class="col-4 bg-white py-3">
                                            <h5 class="mb-1 text-success">{{ number_format($faculty->student_profiles_count) }}</h5>
                                            <p class="text-muted mb-0 fs-12 text-uppercase">Sinh viên</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 2. DANH SÁCH CHUYÊN NGÀNH --}}
                            <h6 class="mb-3 text-uppercase text-muted fs-13 fw-bold">
                                <i class="ri-git-branch-line me-1"></i> Danh sách Chuyên ngành
                            </h6>

                            <div class="card border shadow-none mb-4">
                                @if($faculty->majors->isEmpty())
                                    <div class="card-body text-center text-muted py-4">
                                        Chưa có chuyên ngành nào.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-sm table-nowrap align-middle mb-0 table-hover">
                                            <thead class="table-light text-muted">
                                            <tr>
                                                <th class="ps-3">Mã Ngành</th>
                                                <th>Tên Ngành</th>
                                                <th class="text-center">Sinh viên</th>
                                                <th class="text-end pe-3">Ngày tạo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($faculty->majors as $major)
                                                <tr>
                                                    <td class="ps-3">
                                                        <span class="badge bg-info-subtle text-info">{{ $major->code }}</span>
                                                    </td>
                                                    <td class="fw-medium">{{ $major->name }}</td>
                                                    <td class="text-center">
                                                            <span class="badge bg-success-subtle text-success">
                                                                {{ number_format($major->student_profiles_count) }}
                                                            </span>
                                                    </td>
                                                    <td class="text-end pe-3 text-muted small">{{ $major->created_at->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            {{-- [YÊU CẦU 2] DANH SÁCH GIẢNG VIÊN --}}
                            <h6 class="mb-3 text-uppercase text-muted fs-13 fw-bold">
                                <i class="ri-briefcase-line me-1"></i> Danh sách Giảng viên
                            </h6>

                            <div class="card border shadow-none mb-0">
                                @if($faculty->instructorProfiles->isEmpty())
                                    <div class="card-body text-center text-muted py-4">
                                        Chưa có giảng viên nào thuộc khoa này.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-nowrap align-middle mb-0 table-hover">
                                            <thead class="table-light text-muted">
                                            <tr>
                                                <th class="ps-3">Giảng viên</th>
                                                <th>Chuyên ngành</th>
                                                <th class="text-center">Khóa học</th>
                                                <th class="text-center">Học viên</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($faculty->instructorProfiles as $instructor)
                                                <tr>
                                                    <td class="ps-3">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $instructor->user->avatar ?? asset('assets/images/users/user-dummy-img.jpg') }}"
                                                                 alt=""
                                                                 class="avatar-xs rounded-circle me-2">
                                                            <div>
                                                                <h6 class="mb-0 fs-13">{{ $instructor->user->name ?? 'Unknown' }}</h6>
                                                                <p class="text-muted mb-0 fs-11">{{ $instructor->user->email ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($instructor->major)
                                                            <span class="badge bg-info-subtle text-info border border-info-subtle">
                                                                    {{ $instructor->major->name }}
                                                                </span>
                                                        @else
                                                            <span class="text-muted small">--</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                            <span class="badge bg-secondary-subtle text-secondary">
                                                                {{ $instructor->course_count }}
                                                            </span>
                                                    </td>
                                                    <td class="text-center">
                                                            <span class="badge bg-success-subtle text-success">
                                                                {{ number_format($instructor->student_count) }}
                                                            </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

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
