<div>
    <div class="modal fade" id="edit-classroom-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cập nhật Lớp học</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="updateClassroom">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Thuộc Chuyên Ngành <span class="text-danger">*</span></label>
                                <select class="form-select @error('major_id') is-invalid @enderror"
                                        wire:model="major_id">
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

                            <div class="col-12">
                                <label class="form-label">Tên Lớp <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       wire:model="name"
                                       placeholder="Ví dụ: Kỹ thuật phần mềm 01">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Mã Lớp <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('code') is-invalid @enderror"
                                       wire:model="code"
                                       placeholder="Ví dụ: KTPM01">
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-warning" wire:loading.attr="disabled">
                            <span wire:loading.remove>Lưu thay đổi</span>
                            <span wire:loading>Đang lưu...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
