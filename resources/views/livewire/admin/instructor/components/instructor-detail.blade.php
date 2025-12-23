<div>
    <div wire:ignore.self class="modal fade" id="showInstructorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 overflow-hidden" style="min-height: 300px">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase fw-bold text-primary">Hồ sơ giảng viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($instructor)
                        <div class="row">
                            <div class="col-md-4 border-end">
                                <div class="text-center mb-4">
                                    <div class="avatar-xl mx-auto mb-3 position-relative">
                                        <div wire:loading wire:target="loadInstructor" class="w-100 h-100 position-absolute top-0 start-0">
                                            <div class="w-100 h-100 rounded-circle bg-secondary-subtle placeholder-glow overflow-hidden border">
                                                <span class="placeholder w-100 h-100"></span>
                                            </div>
                                        </div>

                                        <div wire:loading.remove wire:target="loadInstructor" class="w-100 h-100">
                                            <img src="{{ $instructor->avatarUrl }}"
                                                 class="img-thumbnail rounded-circle shadow-sm border p-1 w-100 h-100 object-fit-cover"
                                                 alt="Avatar">
                                        </div>
                                    </div>

                                    <h4 class="mb-1">{{ $instructor->name }}</h4>
                                    <p class="text-muted mb-2">{{ $instructor->jobTitle }}</p>

                                    <span class="badge bg-{{ $instructor->statusClass }}-subtle text-{{ $instructor->statusClass }} border border-{{ $instructor->statusClass }}-subtle px-3 py-2 rounded-pill">
                                        {{ $instructor->statusLabel }}
                                    </span>
                                </div>

                                <div class="card bg-light border-0 mb-3">
                                    <div class="card-body">
                                        <h6 class="fs-13 fw-bold text-uppercase mb-3 text-muted">Thông tin liên hệ</h6>
                                        <ul class="list-unstyled vstack gap-3 mb-0">
                                            <li class="d-flex align-items-center">
                                                <div class="avatar-xs flex-shrink-0 me-2">
                                                    <span class="avatar-title rounded-circle bg-white text-primary shadow-sm"><i class="ri-mail-line"></i></span>
                                                </div>
                                                <span class="text-dark">{{ $instructor->email }}</span>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <div class="avatar-xs flex-shrink-0 me-2">
                                                    <span class="avatar-title rounded-circle bg-white text-primary shadow-sm"><i class="ri-calendar-line"></i></span>
                                                </div>
                                                <span class="text-dark">Tham gia: {{ $instructor->joinedAt }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                @if(!empty($instructor->socialLinks))
                                    <div class="text-center">
                                        <h6 class="fs-13 fw-bold text-uppercase mb-3 text-muted">Mạng xã hội</h6>
                                        <div class="d-flex justify-content-center gap-2">
                                            @foreach($instructor->socialLinks as $platform => $link)
                                                <a href="{{ $link }}" target="_blank" class="btn btn-soft-primary btn-sm btn-icon rounded-circle">
                                                    <i class="ri-{{ $platform }}-fill"></i>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-8 ps-md-4">
                                <div class="row g-3 mb-4">
                                    <div class="col-4">
                                        <div class="p-3 border rounded bg-light-subtle text-center h-100">
                                            <h4 class="mb-1 text-primary fw-bold">{{ number_format($instructor->courseCount) }}</h4>
                                            <p class="text-muted mb-0 fs-13 text-uppercase">Khóa học</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded bg-light-subtle text-center h-100">
                                            <h4 class="mb-1 text-success fw-bold">{{ number_format($instructor->studentCount) }}</h4>
                                            <p class="text-muted mb-0 fs-13 text-uppercase">Học viên</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 border rounded bg-light-subtle text-center h-100">
                                            <h4 class="mb-1 text-warning fw-bold d-flex align-items-center justify-content-center gap-1">
                                                {{ number_format($instructor->rating, 1) }}
                                                <i class="ri-star-fill fs-14"></i>
                                            </h4>
                                            <p class="text-muted mb-0 fs-13 text-uppercase">Đánh giá
                                                ({{ $instructor->reviewCount }})</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5 class="fs-15 fw-bold mb-3 border-bottom pb-2 text-primary">
                                        <i class="ri-book-mark-line me-1"></i> Thông tin chuyên môn
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <label class="text-muted text-uppercase fs-11 fw-bold">Khoa trực
                                                thuộc</label>
                                            <div class="fs-14 fw-medium text-dark">{{ $instructor->facultyName }}</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="text-muted text-uppercase fs-11 fw-bold">Ngành / Bộ
                                                môn</label>
                                            <div class="fs-14 fw-medium text-dark">{{ $instructor->majorName }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div x-data="{ expanded: false }">
                                    <h5 class="fs-15 fw-bold mb-3 border-bottom pb-2 text-primary d-flex align-items-center justify-content-between">
                                        <span><i class="ri-user-voice-line me-1"></i> Giới thiệu</span>

                                        @if(!empty($instructor->bio) && strlen($instructor->bio) > 200)
                                            <button @click="expanded = !expanded"
                                                    class="btn btn-sm btn-link text-decoration-none p-0"
                                                    x-text="expanded ? 'Thu gọn' : 'Xem thêm'">
                                            </button>
                                        @endif
                                    </h5>

                                    <div class="position-relative">
                                        <div class="text-muted text-break"
                                             :class="expanded ? '' : 'line-clamp-3'"
                                             style="line-height: 1.6; transition: all 0.3s ease;">
                                            @if(!empty($instructor->bio))
                                                @markdown($instructor->bio)
                                            @else
                                                <span class="fst-italic text-secondary">Giảng viên chưa cập nhật thông tin giới thiệu.</span>
                                            @endif

                                            @if(!empty($instructor->aboutMe))
                                                <div class="mt-3 pt-3 border-top">
                                                    <h6 class="fs-13 fw-bold text-uppercase mb-2 text-muted">Chi
                                                        tiết</h6>
                                                    {!! nl2br(e($instructor->aboutMe)) !!}
                                                </div>
                                            @endif
                                        </div>

                                        @if(!empty($instructor->bio) && strlen($instructor->bio) > 200)
                                            <div x-show="!expanded" class="text-gradient-overlay"></div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 border-top">
                                    <h5 class="fs-15 fw-bold mb-3 text-primary">
                                        <i class="ri-video-line me-1"></i> Các khóa học giảng dạy
                                    </h5>

                                    @if(!$coursesLoaded)
                                        <div class="text-center py-3">
                                            <p class="text-muted mb-3 fs-13">Bấm vào nút bên dưới để xem danh sách các
                                                khóa học của giảng viên này.</p>

                                            <button wire:click="loadCourses" wire:loading.attr="disabled" class="btn btn-soft-primary btn-sm">
                                                <span wire:loading.remove wire:target="loadCourses">
                                                    <i class="ri-download-cloud-2-line me-1"></i> Tải danh sách khóa học
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
                                                        <div class="list-group-item list-group-item-action px-0 border-0 mb-2">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <img src="{{ $course->thumbnail }}"
                                                                         class="avatar-sm rounded-3 object-fit-cover" alt="">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="fs-14 mb-1 text-truncate" style="max-width: 350px;">
                                                                        {{ $course->name }}
                                                                    </h6>

                                                                    <div class="d-flex align-items-center gap-3 fs-12 text-muted">
                                                                        <span>
                                                                            <i class="ri-price-tag-3-line text-success"></i>
                                                                            {{ $course->priceFormatted }}
                                                                        </span>
                                                                        <span>
                                                                            <i class="ri-time-line"></i>
                                                                            {{ $course->createdAt }}
                                                                        </span>

                                                                        <span>
                                                                            <span class="badge bg-{{ $course->statusClass }}-subtle text-{{ $course->statusClass }}">
                                                                                {{ $course->statusLabel }}
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0">
                                                                    <a href="{{ $course->detailUrl }}" target="_blank" class="btn btn-sm btn-icon btn-ghost-secondary">
                                                                        <i class="ri-arrow-right-s-line fs-16"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-light text-center text-muted border-0 bg-light-subtle">
                                                    <i class="ri-inbox-archive-line fs-24 d-block mb-2"></i>
                                                    Giảng viên này chưa có khóa học nào.
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div wire:loading wire:target="loadInstructor" class="position-absolute top-0 start-0 w-100 h-100 bg-white d-flex justify-content-center align-items-center" style="z-index: 1055;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
