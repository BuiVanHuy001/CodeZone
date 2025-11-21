<div>
    <div class="modal fade" id="delete-major-modal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger-subtle">
                    <h5 class="modal-title text-danger">
                        <i class="ri-alert-fill me-2"></i>Yêu cầu chuyển dữ liệu
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="confirmDeleteWithMigration">
                    <div class="modal-body">
                        @if($major)
                            <div class="alert alert-warning border-0">
                                <strong>Cảnh báo:</strong> Chuyên ngành <strong>{{ $major->name }}</strong> đang chứa dữ
                                liệu:
                                <ul class="mb-0 mt-2">
                                    @if($classCount > 0)
                                        <li><strong>{{ $classCount }}</strong> Lớp học</li>
                                    @endif
                                    @if($instructorCount > 0)
                                        <li><strong>{{ $instructorCount }}</strong> Giảng viên</li>
                                    @endif
                                    @if($studentCount > 0)
                                        <li><strong>{{ $studentCount }}</strong> Sinh viên</li>
                                    @endif
                                </ul>
                            </div>

                            <p class="text-muted mb-3">
                                Để xóa ngành này, bạn bắt buộc phải chuyển toàn bộ dữ liệu trên sang một Chuyên ngành
                                khác.
                            </p>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Chọn Chuyên ngành tiếp nhận <span class="text-danger">*</span></label>
                                <select class="form-select @error('targetMajorId') is-invalid @enderror"
                                        wire:model="targetMajorId">
                                    <option value="">-- Chọn ngành --</option>
                                    @foreach($targetMajors as $target)
                                        <option value="{{ $target->id }}">
                                            {{ $target->name }} ({{ $target->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('targetMajorId')
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
