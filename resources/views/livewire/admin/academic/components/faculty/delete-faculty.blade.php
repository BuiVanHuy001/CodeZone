<div>
    <div class="modal fade" id="deleteFacultyModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger-subtle">
                    <h5 class="modal-title text-danger" id="deleteLabel">
                        <i class="ri-alert-fill me-2"></i>Yêu cầu chuyển dữ liệu
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="confirmDeleteWithMigration">
                    <div class="modal-body">
                        @if($faculty)
                            <div class="alert alert-warning border-0">
                                <strong>Cảnh báo:</strong> Khoa <strong>{{ $faculty->name }}</strong> đang chứa
                                <span class="badge bg-warning text-dark">{{ $majorsCount }}</span> chuyên ngành.
                            </div>

                            <p class="text-muted mb-3">
                                Để xóa khoa này, bạn bắt buộc phải chuyển toàn bộ chuyên ngành trực thuộc sang một khoa
                                khác.
                            </p>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Chọn Khoa tiếp nhận <span class="text-danger">*</span></label>
                                <select class="form-select @error('targetFacultyId') is-invalid @enderror"
                                        wire:model="targetFacultyId">
                                    <option value="">-- Chọn khoa --</option>
                                    @foreach($targetFaculties as $target)
                                        <option value="{{ $target->id }}">
                                            {{ $target->name }} ({{ $target->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('targetFacultyId')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-danger" wire:loading.attr="disabled">
                            <span wire:loading.remove>Chuyển & Xóa</span>
                            <span wire:loading>Đang xử lý...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
