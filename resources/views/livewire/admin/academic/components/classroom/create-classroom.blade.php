<div>
    <div class="modal fade" id="create-classroom-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Lớp học mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="storeClassroom">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Thuộc Chuyên Ngành <span class="text-danger">*</span></label>
                                <select class="form-select @error('major_id') is-invalid @enderror"
                                        wire:model.live="major_id">
                                    <option value="">-- Chọn Ngành --</option>
                                    @foreach($majors as $major)
                                        <option value="{{ $major->id }}">
                                            {{ $major->name }} ({{ $major->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('major_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- 2. Tên & Mã --}}
                            <div class="col-md-8">
                                <label class="form-label">Tên Lớp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       wire:model="name" placeholder="Ví dụ: Kỹ thuật phần mềm 01">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Mã Lớp <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                       wire:model="code" placeholder="Ví dụ: KTPM01">
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- 3. Danh sách Sinh viên chưa có lớp --}}
                            <div class="col-12">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Thêm Sinh viên vào lớp (Tùy chọn)</span>
                                    @if($availableStudents->isNotEmpty())
                                        <span class="badge bg-info-subtle text-info">
                                            Tìm thấy {{ $availableStudents->count() }} SV chưa có lớp
                                        </span>
                                    @endif
                                </label>

                                <div class="card border shadow-none mb-0" style="max-height: 300px; overflow-y: auto;">
                                    @if(!$major_id)
                                        <div class="text-center py-4 text-muted">
                                            Vui lòng chọn Chuyên ngành để xem danh sách sinh viên.
                                        </div>
                                    @elseif($availableStudents->isEmpty())
                                        <div class="text-center py-4 text-muted">
                                            <i class="ri-user-search-line fs-24"></i>
                                            <p class="mb-0">Không có sinh viên (Internal) nào chưa có lớp thuộc ngành
                                                này.</p>
                                        </div>
                                    @else
                                        <div class="list-group list-group-flush">
                                            @foreach($availableStudents as $student)
                                                <label class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">
                                                    <input class="form-check-input me-3" type="checkbox"
                                                           wire:model="selectedStudents"
                                                           value="{{ $student->user_id }}">

                                                    <div class="d-flex align-items-center flex-grow-1">
                                                        <img src="{{ $student->user->avatar ?? asset('assets/images/users/user-dummy-img.jpg') }}"
                                                             class="avatar-xs rounded-circle me-2" alt="">
                                                        <div>
                                                            <h6 class="mb-0 fs-13">{{ $student->user->name }}</h6>
                                                            <small class="text-muted me-2">{{ $student->student_code }}</small>

                                                            @if(!$student->major_id)
                                                                <span class="badge bg-warning-subtle text-warning fs-10">Chưa có ngành</span>
                                                            @else
                                                                <span class="badge bg-success-subtle text-success fs-10">
                                                                    Ngành{{ $student->major->name ?? 'Đang cập nhật' }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="form-text text-muted">
                                    Chỉ hiển thị sinh viên thuộc hệ <strong>Internal</strong> và chưa được gán vào lớp
                                    nào.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove>Tạo lớp</span>
                            <span wire:loading>Đang xử lý...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
