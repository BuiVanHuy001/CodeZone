<div>
    <div class="modal fade" id="classroom-detail-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-dashed">
                    <h5 class="modal-title text-primary">
                        <i class="ri-community-line me-1"></i> Quản lý Lớp học
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body bg-light-subtle">
                    <div wire:loading wire:target="loadClassroom" class="text-center w-100 py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>

                    <div wire:loading.remove wire:target="loadClassroom">
                        @if($classroom)
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="card-title text-primary fw-bold mb-1">{{ $classroom->name }}</h4>
                                            <div class="d-flex align-items-center gap-2 text-muted fs-13">
                                                <span class="badge bg-info-subtle text-info border border-info-subtle">{{ $classroom->code }}</span>
                                                <span>|</span>
                                                <span>Ngành: <strong>{{ $classroom->major->name ?? 'N/A' }}</strong></span>
                                                @if($classroom->major && $classroom->major->faculty)
                                                    <span>-</span>
                                                    <span>Khoa: {{ $classroom->major->faculty->name }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="text-center p-2 bg-white rounded border">
                                            <h4 class="mb-0 text-success fw-bold">
                                                {{ isset($classroom->students_list) ? count($classroom->students_list) : 0 }}
                                            </h4>
                                            <small class="text-muted text-uppercase fs-10">Sĩ số</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-uppercase text-muted fs-13 fw-bold mb-0">
                                    <i class="ri-team-line me-1"></i> Danh sách Sinh viên
                                </h6>

                                <button class="btn btn-sm {{ $isAddingMode ? 'btn-danger' : 'btn-success' }}"
                                        wire:click="toggleAddMode"
                                        wire:loading.attr="disabled">
                                    @if($isAddingMode)
                                        <i class="ri-close-line align-bottom me-1"></i> Hủy bỏ
                                    @else
                                        <i class="ri-user-add-line align-bottom me-1"></i> Thêm Sinh viên
                                    @endif
                                </button>
                            </div>

                            @if($isAddingMode)
                                <div class="card border border-success border-opacity-25 shadow-none mb-4 bg-success-subtle bg-opacity-10">
                                    <div class="card-header bg-transparent border-bottom border-success border-opacity-25">
                                        <h6 class="card-title mb-0 text-success">Chọn sinh viên để thêm vào lớp</h6>
                                    </div>
                                    <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                                        @if(empty($availableStudents))
                                            <div class="text-center py-4 text-muted">
                                                <p>Không tìm thấy sinh viên nào cùng chuyên ngành (chưa có lớp hoặc khác
                                                    lớp).</p>
                                            </div>
                                        @else
                                            <div class="list-group list-group-flush">
                                                @foreach($availableStudents as $st)
                                                    <label class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer bg-transparent">
                                                        <div class="flex-shrink-0 me-3">
                                                            <input class="form-check-input form-check-input-lg"
                                                                   type="checkbox"
                                                                   wire:model="selectedStudents"
                                                                   value="{{ $st['id'] }}"
                                                                   style="cursor: pointer;">
                                                        </div>
                                                        <div class="d-flex align-items-center flex-grow-1">
                                                            <img src="{{ $st['avatar'] ?? asset('assets/images/users/user-dummy-img.jpg') }}"
                                                                 class="avatar-xs rounded-circle me-2" alt="Student avatar" loading="lazy">
                                                            <div>
                                                                <h6 class="mb-0 fs-13">{{ $st['name'] }}</h6>
                                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                    <small class="text-muted">{{ $st['code'] }}</small>

                                                                    @if($st['current_class_code'])
                                                                        <span class="badge bg-warning-subtle text-warning fs-10">Chuyển từ: {{ $st['current_class_code'] }}</span>
                                                                    @else
                                                                        <span class="badge bg-success-subtle text-success fs-10">Chưa có lớp</span>
                                                                    @endif

                                                                    @if($st['no_major'])
                                                                        <span class="badge bg-danger-subtle text-danger fs-10">Chưa phân ngành</span>
                                                                    @elseif($st['is_diff_major'])
                                                                        <span class="badge bg-danger-subtle text-danger fs-10">Khác ngành</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-transparent border-top border-success border-opacity-25 text-end">
                                        <button class="btn btn-success btn-sm"
                                                wire:click="addSelectedStudents"
                                                wire:loading.attr="disabled"
                                            {{ empty($availableStudents) ? 'disabled' : '' }}>
                                            <i class="ri-check-double-line align-bottom me-1"></i> Lưu danh sách
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @if(!$isAddingMode)
                                <div class="card border shadow-none mb-0">
                                    @if(empty($classroom->students_list))
                                        <div class="card-body text-center text-muted py-5">
                                            <p class="mb-0">Lớp này chưa có sinh viên nào.</p>
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-nowrap align-middle mb-0 table-hover">
                                                <thead class="table-light text-muted">
                                                <tr>
                                                    <th>STT</th>
                                                    <th class="ps-4">Sinh viên</th>
                                                    <th>MSSV</th>
                                                    <th>Giới tính</th>
                                                    <th>Trạng thái</th>
                                                    <th class="text-center">Tác vụ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($classroom->students_list as $student)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ $student['avatar'] ?? asset('assets/images/users/user-dummy-img.jpg') }}"
                                                                     loading="lazy"
                                                                     alt="" class="avatar-xs rounded-circle me-2">
                                                                <div>
                                                                    <h6 class="mb-0 fs-13">{{ $student['name'] ?? 'Unknown' }}</h6>
                                                                    <p class="text-muted mb-0 fs-11">{{ $student['email'] ?? '' }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="fw-medium font-monospace">{{ $student['student_code'] }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-light text-body">{{ $student['gender_text'] }}</span>
                                                        </td>
                                                        <td>
                                                            @if($student['status'] === 'active')
                                                                <span class="badge badge-label bg-success">Active</span>
                                                            @else
                                                                <span class="badge badge-label bg-danger">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="d-flex gap-2 justify-content-end">
                                                                <button class="btn btn-sm btn-soft-info"
                                                                        onclick="promptTransferStudent('{{ $student['id'] }}', '{{ $student['name'] }}')">
                                                                    <i class="ri-share-forward-line align-bottom"></i>
                                                                    Chuyển
                                                                </button>

                                                                <button class="btn btn-sm btn-soft-danger"
                                                                        onclick="confirmRemoveStudent('{{ $student['id'] }}', '{{ $student['name'] }}')">
                                                                    <i class="ri-user-unfollow-line align-bottom"></i>
                                                                    Xóa
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
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

    <script>
        function confirmRemoveStudent(id, name) {
            Swal.fire({
                title: 'Xóa khỏi lớp?',
                text: `Bạn muốn xóa học viên ${name} ra khỏi lớp này?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Vâng, xóa!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) @this.
                removeStudent(id);
            });
        }

        async function promptTransferStudent(id, name) {
            const classes = await @this.
            get('transferableClasses');
            const options = {};

            if (Array.isArray(classes)) {
                classes.forEach(c => {
                    options[c.id] = `${c.name} (${c.code})`;
                });
            }

            if (Object.keys(options).length === 0) {
                Swal.fire('Thông báo', 'Không còn lớp nào khác cùng chuyên ngành để chuyển.', 'info');
                return;
            }

            Swal.fire({
                title: `Chuyển lớp cho ${name}`,
                input: 'select',
                inputOptions: options,
                inputPlaceholder: 'Chọn lớp mới',
                showCancelButton: true,
                confirmButtonText: 'Chuyển ngay',
                preConfirm: (targetId) => {
                    if (!targetId) Swal.showValidationMessage('Vui lòng chọn một lớp');
                    else return @this.
                    transferStudent(id, targetId);
                }
            });
        }
    </script>
</div>
