<div>
    <div class="modal fade" id="delete-classroom-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger-subtle">
                    <h5 class="modal-title text-danger">
                        <i class="ri-alert-fill me-2"></i>Chuyển Sinh viên & Xóa Lớp
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="confirmDeleteWithMigration">
                    <div class="modal-body">
                        @if($classroom)
                            <div class="alert alert-warning border-0">
                                <strong>Cảnh báo:</strong> Lớp <strong>{{ $classroom->name }}</strong> đang có
                                <span class="badge bg-warning text-dark fs-12">{{ $studentCount }}</span> sinh viên.
                            </div>

                            <p class="text-muted mb-3">
                                Để xóa lớp này, bạn bắt buộc phải chuyển toàn bộ sinh viên sang một lớp khác cùng chuyên
                                ngành.
                            </p>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Chọn Lớp tiếp nhận <span class="text-danger">*</span></label>
                                <select class="form-select @error('targetClassId') is-invalid @enderror"
                                        wire:model="targetClassId">
                                    <option value="">-- Chọn lớp --</option>
                                    @foreach($targetClassrooms ?? [] as $target)
                                        <option value="{{ $target['id'] }}">
                                            {{ $target['name'] }} ({{ $target['code'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('targetClassId')
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
