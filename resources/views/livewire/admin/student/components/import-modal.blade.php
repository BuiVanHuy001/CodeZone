<div>
    <div wire:ignore.self class="modal fade" id="importStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="min-height: 500px">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold">
                            @if($showResult)
                                Kết quả Import
                            @else
                                Import Sinh Viên
                            @endif
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal" wire:loading.attr="disabled"></button>
                </div>

                <div class="modal-body p-4 d-flex flex-column">
                    @if(!$showResult)
                        <div
                            x-data="{
                                isUploading: false,
                                progress: 0,
                                isDragging: false
                            }"
                            class="d-flex flex-column flex-grow-1"
                            x-on:livewire-upload-start="isUploading = true"
                            x-on:livewire-upload-finish="isUploading = false"
                            x-on:livewire-upload-error="isUploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                        >
                            <div
                                class="upload-zone position-relative rounded-3 p-5 text-center border-2 border-dashed transition-all flex-grow-1 d-flex flex-column justify-content-center align-items-center"
                                :class="{ 'border-primary bg-primary bg-opacity-10': isDragging, 'border-secondary-subtle bg-light': !isDragging }"
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; $wire.uploadMultiple('files', $event.dataTransfer.files)"
                                @click="$refs.fileInput.click()"
                                style="cursor: pointer; transition: all 0.2s ease;"
                            >
                                <input type="file" wire:model="files" x-ref="fileInput" multiple accept=".csv,.xls,.xlsx" class="d-none">

                                <div class="mb-3">
                                    <div class="avatar-sm mx-auto bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                        <i class="ri-upload-cloud-2-line fs-1 text-primary"></i>
                                    </div>
                                </div>
                                <h5 class="fw-semibold mb-1">Kéo thả hoặc click để tải file lên</h5>
                                <p class="text-muted small mb-0">Hỗ trợ định dạng: .xlsx, .xls, .csv (Max: 10MB)</p>
                            </div>

                            <div x-show="isUploading" class="mt-3" style="display: none;">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="fw-medium">Đang tải lên...</small>
                                    <small x-text="progress + '%'"></small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary rounded-pill" role="progressbar" :style="'width: ' + progress + '%'"></div>
                                </div>
                            </div>

                            @error('files.*')
                            <div class="alert alert-danger mt-3 d-flex align-items-center" role="alert">
                                <i class="ri-error-warning-line fs-5 me-2"></i>
                                <div>{{ $message }}</div>
                            </div>
                            @enderror

                            @if(!empty($files))
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">File đã chọn ({{ count($files) }})</h6>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach($files as $index => $file)
                                            <div class="border shadow-none p-2" wire:key="file-{{ $index }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-xs bg-success-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            <i class="ri-file-excel-2-fill text-success fs-4"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h6 class="mb-0 text-truncate">{{ $file->getClientOriginalName() }}</h6>
                                                        <small class="text-muted">{{ number_format($file->getSize() / 1024, 2) }}
                                                            KB</small>
                                                    </div>
                                                    <button
                                                        wire:click="removeFile({{ $index }})"
                                                        class="btn btn-icon btn-sm btn-ghost-danger"
                                                        title="Xóa file này"
                                                    >
                                                        <i class="ri-delete-bin-line fs-5"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        @if(!empty($importErrors))
                            <div class="alert alert-warning mb-3" role="alert">
                                <h6 class="alert-heading fw-bold"><i class="ri-alert-line me-1"></i> Có một số lỗi xảy
                                    ra:</h6>
                                <ul class="mb-0 small ps-3" style="max-height: 100px; overflow-y: auto;">
                                    @foreach($importErrors as $error)
                                        <li class="text-start">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="alert alert-success mb-3">
                                <i class="ri-checkbox-circle-line me-1"></i>
                                Đã import thành công <strong>{{ count($importedStudents) }}</strong> sinh viên.
                            </div>
                        @endif
                        <div class="table-responsive border rounded-3" style="max-height: 450px; overflow-y: auto;">
                            <table class="table align-middle table-nowrap table-hover mb-0">
                                <thead class="table-light sticky-top" style="z-index: 1; top: 0;">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 50px;">#</th>
                                    <th scope="col">Thông tin Sinh viên</th>
                                    <th scope="col">Thông tin Học vụ</th>
                                    <th scope="col" class="text-center">Trạng thái</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                @foreach($importedStudents as $index => $std)
                                    <tr wire:key="student-row-{{ $index }}">
                                        <td class="text-center text-muted">{{ $index + 1 }}</td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center border border-primary-subtle">
                                                        <span class="fw-bold fs-6">
                                                            {{ substr($std['name'] ?? 'U', 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="fs-14 mb-1 text-dark fw-semibold">{{ $std['name'] }}</h6>
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="ri-mail-line me-1 text-secondary"></i>
                                                        <span class="text-truncate" style="max-width: 200px;" title="{{ $std['email'] }}">
                                                            {{ $std['email'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-light text-body border me-2">MSSV</span>
                                                    <span class="fw-bold text-primary font-monospace">
                                                        {{ $std['student_profile']['student_code'] ?? 'N/A' }}
                                                    </span>
                                                </div>

                                                <div class="d-flex align-items-center small text-muted">
                                                    <div class="d-flex align-items-center me-3">
                                                        <i class="ri-community-line me-1 text-info"></i>
                                                        <span
                                                            class="cursor-help text-decoration-underline text-decoration-style-dotted"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="{{ $std['student_profile']['class_room']['name'] ?? 'Chưa cập nhật tên lớp' }}"
                                                        >
                                                            {{ $std['student_profile']['class_room']['code'] ?? '---' }}
                                                        </span>
                                                    </div>
                                                    @if(isset($std['student_profile']['major']))
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-book-mark-line me-1 text-warning"></i>
                                                            <span
                                                                class="cursor-help text-decoration-underline text-decoration-style-dotted"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="{{ $std['student_profile']['major']['name'] ?? 'Chưa cập nhật tên ngành' }}"
                                                            >
                                                                {{ $std['student_profile']['major']['code'] ?? '---' }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                <i class="ri-checkbox-circle-fill align-middle me-1"></i> Thành công
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                    @if(!$showResult)
                        <div class="d-flex justify-content-between w-100 align-items-center">
                            <a href="{{ asset('excel_file/ImportStudentSample.xlsx') }}" download class="text-decoration-none small d-flex align-items-center">
                                <i class="ri-download-line me-1"></i> Tải file mẫu
                            </a>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal" wire:click="closeModal">
                                    Hủy bỏ
                                </button>
                                <button wire:click="importStudents" class="btn btn-primary px-4" @if(empty($files)) disabled @endif>
                                    <span wire:loading.remove wire:target="importStudents">Import Dữ Liệu</span>
                                    <span wire:loading wire:target="importStudents"><span class="spinner-border spinner-border-sm me-1"></span> Đang xử lý...</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-end w-100 gap-2">
                            <button wire:click="resetUpload" class="btn btn-light">
                                <i class="ri-arrow-go-back-line me-1"></i> Import tiếp
                            </button>
                            <button wire:click="closeModal" class="btn btn-success px-4">
                                <i class="ri-check-double-line me-1"></i> Hoàn tất
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
