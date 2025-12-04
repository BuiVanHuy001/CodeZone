<div>
    <div class="modal fade" id="createFacultyModal" tabindex="-1" aria-labelledby="createFacultyModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFacultyModalLabel">Thêm khoa mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="storeFaculty">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div>
                                    <label for="facultyName" class="form-label">Tên khoa
                                        <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="facultyName"
                                           wire:model="name"
                                           placeholder="Ví dụ: Công nghệ thông tin">
                                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div>
                                    <label for="facultyCode" class="form-label">Mã khoa
                                        <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           id="facultyCode"
                                           wire:model="code"
                                           placeholder="Ví dụ: CNTT">
                                    @error('code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="storeFaculty">Tạo mới</span>
                            <span wire:loading wire:target="storeFaculty">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Đang lưu...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
