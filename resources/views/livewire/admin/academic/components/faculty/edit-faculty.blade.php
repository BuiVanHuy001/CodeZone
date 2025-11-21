<div>
    <div class="modal fade" id="edit-faculty-modal" tabindex="-1" aria-labelledby="edit-faculty-modalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-faculty-modalLabel">Cập nhật Khoa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="updateFaculty">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div>
                                    <label for="editFacultyName" class="form-label">Tên khoa
                                        <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="editFacultyName"
                                           wire:model="name"
                                           placeholder="Ví dụ: Công nghệ thông tin">
                                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div>
                                    <label for="editFacultyCode" class="form-label">Mã khoa
                                        <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('code') is-invalid @enderror"
                                           id="editFacultyCode"
                                           wire:model="code"
                                           placeholder="Ví dụ: CNTT">
                                    @error('code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>

                        <button type="submit" class="btn btn-warning" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="updateFaculty">Lưu thay đổi</span>
                            <span wire:loading wire:target="updateFaculty">
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
