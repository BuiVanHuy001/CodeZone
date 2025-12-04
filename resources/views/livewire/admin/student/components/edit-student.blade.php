<div>
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật Sinh viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="updateStudent">
                    <div class="modal-body">
                        @error('root')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <div class="avatar-lg">
                                    <div class="avatar-title bg-light rounded-circle overflow-hidden">
                                        @if($currentAvatarUrl)
                                            <img src="{{ $currentAvatarUrl }}" class="avatar-md rounded-circle h-100 w-100 object-fit-cover" alt="Avatar"/>
                                        @else
                                            <img src="{{ asset('images/team/temp-avatar.webp') }}" class="avatar-md rounded-circle h-100 w-100 object-fit-cover" alt="Placeholder"/>
                                        @endif
                                    </div>
                                </div>

                                @if($hasAvatar)
                                    <button type="button"
                                            wire:click="$dispatch('swal-confirm-delete-student-avatar')"
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light p-1">
                                        <i class="ri-delete-bin-line fs-12"></i>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Mã số sinh viên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('studentCode') is-invalid @enderror" wire:model="studentCode">
                                @error('studentCode')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Lớp / Ngành</label>
                                <select class="form-select @error('classRoomId') is-invalid @enderror" wire:model="classRoomId">
                                    <option value="">-- Chưa phân lớp --</option>
                                    @foreach($classRooms->groupBy(fn($c) => $c->major->name ?? 'Chưa phân ngành') as $majorName => $classes)
                                        <optgroup label="{{ $majorName }}">
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->code }}
                                                    - {{ $class->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('classRoomId')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" wire:model="dob">
                                @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Giới tính</label>
                                <select class="form-select @error('gender') is-invalid @enderror" wire:model="gender">
                                    <option value="">-- Chọn --</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                    <option value="other">Khác</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                    @foreach($statusOptions as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Lưu thay đổi</span>
                            <span wire:loading>Đang lưu...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
