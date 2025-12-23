<div>
    <div wire:ignore.self class="modal fade" id="studentDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 overflow-hidden" style="min-height: 300px">
                @if($student)
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase fw-bold text-primary">Hồ sơ sinh viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 border-end">
                                <div class="text-center mb-4">
                                    <div class="avatar-xl mx-auto mb-3">
                                        @if($student->avatar)
                                            <img src="{{ $student->avatar }}" class="img-thumbnail rounded-circle shadow-sm border p-1 w-100 h-100 object-fit-cover" alt="Avatar">
                                        @else
                                            <div class="avatar-title img-thumbnail rounded-circle shadow-sm bg-primary-subtle text-primary fw-bold fs-1 d-flex align-items-center justify-content-center w-100 h-100">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <h4 class="mb-1">{{ $student->name }}</h4>
                                    <p class="text-muted mb-2">{{ $student->email }}</p>

                                    <span class="badge bg-{{ $student->statusColor }}-subtle text-{{ $student->statusColor }} border border-{{ $student->statusColor }}-subtle px-3 py-2 rounded-pill">
                                            {{ $student->statusLabel }}
                                        </span>
                                </div>

                                <div class="card bg-light border-0 mb-3">
                                    <div class="card-body">
                                        <h6 class="fs-13 fw-bold text-uppercase mb-3 text-muted">Thông tin
                                            chung</h6>
                                        <ul class="list-unstyled vstack gap-3 mb-0">
                                            <li class="d-flex justify-content-between">
                                                <span class="text-muted"><i class="ri-phone-line me-2"></i>SĐT:</span>
                                                <span class="text-dark">{{ $student->phone }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span class="text-muted"><i class="ri-men-line me-2"></i>Giới tính:</span>
                                                <span class="text-dark">{{ $student->genderLabel }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span class="text-muted"><i class="ri-cake-2-line me-2"></i>Ngày sinh:</span>
                                                <span class="text-dark">{{ $student->dob }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                @if($student->isInternalStudent)
                                    <div class="card bg-white border shadow-sm">
                                        <div class="card-body">
                                            <h6 class="fs-13 fw-bold text-uppercase mb-3 text-muted">Học vụ</h6>
                                            <ul class="list-unstyled vstack gap-2 mb-0 fs-13">
                                                <li class="d-flex justify-content-between border-bottom pb-2">
                                                    <span class="text-muted">MSSV</span>
                                                    <span class="fw-bold text-primary font-monospace">{{ $student->studentCode }}</span>
                                                </li>
                                                <li class="d-flex justify-content-between border-bottom py-2">
                                                    <span class="text-muted">Lớp</span>
                                                    <span class="fw-medium text-dark">{{ $student->classRoomName }}</span>
                                                </li>
                                                <li class="d-flex justify-content-between pt-2">
                                                    <span class="text-muted">Niên khóa</span>
                                                    <span class="text-dark">{{ $student->enrollmentYear }}</span>
                                                </li>
                                            </ul>

                                            <div class="mt-3 pt-3 border-top text-center">
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-primary w-100"
                                                        data-bs-dismiss="modal"
                                                        wire:click="$dispatch('show-edit-modal', { id: '{{ $student->id }}' })">
                                                    <i class="ri-edit-box-line me-1"></i> Chỉnh sửa thông tin
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning text-center border-0 bg-warning-subtle text-warning mb-0">
                                        <i class="ri-global-line me-1"></i> Sinh viên vãng lai (External)
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-8 ps-md-4">
                                <div class="row g-3 mb-4">
                                    <div class="col-6">
                                        <div class="p-3 border rounded bg-light-subtle text-center h-100">
                                            <h4 class="mb-1 text-primary fw-bold">{{ $student->stats['enrolled'] ?? 0 }}</h4>
                                            <p class="text-muted mb-0 fs-13 text-uppercase">Khóa học tham gia</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 border rounded bg-light-subtle text-center h-100">
                                            <h4 class="mb-1 text-success fw-bold">{{ $student->stats['completed'] ?? 0 }}</h4>
                                            <p class="text-muted mb-0 fs-13 text-uppercase">Hoàn thành</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="fs-15 fw-bold mb-3 border-bottom pb-2 text-primary">
                                        <i class="ri-book-mark-line me-1"></i> Thông tin chuyên ngành
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label class="text-muted text-uppercase fs-11 fw-bold">Khoa trực
                                                thuộc</label>
                                            <div class="fs-14 fw-medium text-dark">{{ $student->facultyName }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted text-uppercase fs-11 fw-bold">Ngành học</label>
                                            <div class="fs-14 fw-medium text-dark">{{ $student->majorName }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top">
                                    <h5 class="fs-15 fw-bold mb-3 text-primary">
                                        <i class="ri-video-line me-1"></i> Tiến độ học tập
                                    </h5>

                                    @if(!$coursesLoaded && $student->stats['enrolled'] > 0)
                                        <div class="text-center py-3">
                                            <p class="text-muted mb-3 fs-13">Bấm nút bên dưới để tải danh sách khóa học
                                                và tiến độ.</p>
                                            <button wire:click="loadCourses" wire:loading.attr="disabled" class="btn btn-soft-primary btn-sm">
                                                    <span wire:loading.remove wire:target="loadCourses">
                                                        <i class="ri-download-cloud-2-line me-1"></i> Tải dữ liệu khóa học
                                                    </span>
                                                <span wire:loading wire:target="loadCourses">
                                                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                                        Đang tải...
                                                    </span>
                                            </button>
                                        </div>
                                    @endif

                                    @if($coursesLoaded)
                                        <div class="animate__animated animate__fadeIn">
                                            @if(count($courses) > 0)
                                                <div class="list-group list-group-flush">
                                                    @foreach($courses as $course)
                                                        <div class="list-group-item list-group-item-action px-0 border-0 mb-3">
                                                            <div class="d-flex align-items-start">
                                                                <div class="flex-shrink-0">
                                                                    <img src="{{ $course->thumbnail }}" class="avatar-md rounded-3 object-fit-cover border" alt="">
                                                                </div>

                                                                <div class="flex-grow-1 ms-3">
                                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                                        <a href="{{ $course->detailUrl }}" target="_blank" class="fs-14 mb-0 text-truncate fw-bold" style="max-width: 300px;">
                                                                            {{ $course->name }}
                                                                        </a>

                                                                        <span class="badge bg-{{ $course->statusClass }}-subtle text-{{ $course->statusClass }}">
                                                                                {{ $course->statusLabel }}
                                                                            </span>
                                                                    </div>

                                                                    <div class="d-flex align-items-center gap-3 fs-12 text-muted mb-2">
                                                                        <span><i class="ri-calendar-event-line"></i> {{ $course->createdAt }}</span>
                                                                        <span><i class="ri-price-tag-3-line"></i> {{ $course->priceFormatted }}</span>
                                                                    </div>

                                                                    <div class="d-flex align-items-center gap-3 fs-12 text-muted mb-2">
                                                                        @if(!empty($course->authorName))
                                                                            <a href="{{ $course->authorProfileUrl }}">
                                                                                <i class="ri-user-line me-1"></i> {{ $course->authorName }}
                                                                            </a>
                                                                        @endif
                                                                        <span><i class="ri-calendar-event-line me-1"></i> {{ $course->createdAt }}</span>
                                                                    </div>

                                                                    <div class="d-flex align-items-center">
                                                                        <div class="progress flex-grow-1 progress-sm rounded-pill bg-light border">
                                                                            <div class="progress-bar bg-{{ $course->statusClass }}"
                                                                                 role="progressbar"
                                                                                 style="width: {{ $course->progress }}%"
                                                                                 aria-valuenow="{{ $course->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                        <span class="ms-2 fs-12 fw-bold text-dark">{{ $course->progress }}%</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-light text-center text-muted border-0 bg-light-subtle">
                                                    <i class="ri-inbox-archive-line fs-24 d-block mb-2"></i>
                                                    Sinh viên này chưa đăng ký khóa học nào.
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-white d-flex justify-content-center align-items-center" style="z-index: 1055;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
