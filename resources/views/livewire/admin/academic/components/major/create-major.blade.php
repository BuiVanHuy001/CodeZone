<div>
    <div class="modal fade" id="create-major-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Chuyên Ngành Mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="storeMajor">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Tên Chuyên Ngành <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       wire:model="name"
                                       placeholder="Ví dụ: Kỹ thuật phần mềm">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Mã Ngành <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('code') is-invalid @enderror"
                                       wire:model="code"
                                       placeholder="Ví dụ: KTPM">
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Thuộc Khoa <span class="text-danger">*</span></label>
                                <select class="form-select @error('faculty_id') is-invalid @enderror"
                                        wire:model="faculty_id">
                                    <option value="">-- Chọn Khoa --</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}">
                                            {{ $faculty->name }} ({{ $faculty->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('faculty_id')
                                <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove>Tạo mới</span>
                            <span wire:loading>Đang xử lý...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
