<div>
    <div id="import-student-modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">
                        <i class="ri-file-upload-line me-2"></i>Import Students
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class="ri-information-line me-2"></i>
                        <strong>Instructions:</strong> Drop multiple Excel files (CSV, XLS, XLSX) into the area below or
                        click to select files.
                    </div>

                    <div
                        x-data="{
                            dragging: false,
                            handleDragEnter() { this.dragging = true; },
                            handleDragLeave(e) {
                                if (e.target === $refs.dropzone) {
                                    this.dragging = false;
                                }
                            },
                            handleDrop(e) {
                                this.dragging = false;
                                const files = Array.from(e.dataTransfer.files);
                                if (files.length > 0) {
                                    $refs.fileInput.files = e.dataTransfer.files;
                                    $wire.uploadMultiple('files', files);
                                }
                            }
                        }"
                        @dragenter.prevent="handleDragEnter"
                        @dragover.prevent
                        @dragleave.prevent="handleDragLeave"
                        @drop.prevent="handleDrop"
                        x-ref="dropzone"
                        :class="{ 'border-primary bg-primary bg-opacity-10': dragging }"
                        class="border-2 border-dashed rounded-3 p-5 text-center position-relative transition-all"
                        style="cursor: pointer; transition: all 0.3s ease;"
                        @click="$refs.fileInput.click()"
                    >
                        <input
                            type="file"
                            x-ref="fileInput"
                            wire:model="files"
                            multiple
                            accept=".csv,.xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                            class="d-none"
                        >

                        <div class="mb-3">
                            <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                        </div>
                        <h4 class="mb-2">Drop files here or click to upload</h4>
                        <p class="text-muted mb-0">You can upload multiple Excel files at once</p>
                        <small class="text-muted d-block mt-2">Supported formats: CSV, XLS, XLSX</small>
                    </div>

                    <div wire:loading wire:target="files" class="mt-3">
                        <div class="alert alert-info d-flex align-items-center">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            <span>Uploading files...</span>
                        </div>
                    </div>

                    @if(!empty($files))
                        <div class="mt-3">
                            <h6 class="mb-2">Selected Files:</h6>
                            <ul class="list-group">
                                @foreach($files as $index => $file)
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="ri-file-excel-2-line text-success fs-4 me-2"></i>
                                            <div>
                                                <span class="fw-medium">{{ $file->getClientOriginalName() }}</span>
                                                <small class="text-muted d-block">{{ number_format($file->getSize() / 1024, 2) }}
                                                    KB</small>
                                            </div>
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="removeFile({{ $index }})"
                                            class="btn btn-link text-danger p-0"
                                        >
                                            <i class="ri-close-circle-line fs-5"></i>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @error('files')
                    <div class="alert alert-danger mt-2">
                        <i class="ri-error-warning-line me-2"></i>{{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('excel_file/ImportStudentSample.xlsx') }}" download class="btn btn-outline-secondary btn-sm d-flex align-items-center me-auto" role="button">
                        <i class="ri-file-excel-2-line me-2"></i>
                        <span>Download Sample File</span>
                    </a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1 align-middle"></i>Cancel
                    </button>
                    <button
                        type="button"
                        wire:click="importStudents"
                        class="btn btn-primary"
                        wire:loading.attr="disabled"
                        wire:target="importStudents"
                    >
                        <span wire:loading.remove wire:target="importStudents">
                            <i class="ri-upload-2-line me-1 align-middle"></i>Import Students
                        </span>
                        <span wire:loading wire:target="importStudents">
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Importing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
