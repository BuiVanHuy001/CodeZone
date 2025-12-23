<div class="course-field mb--20">
    <h6>Tải lên Video bài giảng</h6>

    <div wire:loading wire:target="video, saveVideo" class="alert alert-info w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
            <i class="feather-loader fa-spin fs-5"></i>
            <span>Đang xử lý video... Vui lòng không tắt trình duyệt.</span>
        </div>
    </div>

    @if(!empty($previewVideoUrl) || $hasTempFile)
        <div class="video-preview-wrapper mb--15" wire:loading.remove wire:target="video">
            <div class="position-relative">
                <video controls preload="metadata" class="w-100 rounded-3 border"
                       src="{{ $hasTempFile && $video ? $video->temporaryUrl() : $previewVideoUrl }}">
                    Trình duyệt của bạn không hỗ trợ thẻ video.
                </video>
            </div>

            <div class="mt-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="status-badge">
                    @if($hasTempFile)
                        <span class="badge bg-info text-white p-2"><i class="feather-upload-cloud"></i> Sẵn sàng lưu</span>
                    @elseif($isDraft)
                        <span class="badge bg-secondary p-2"><i class="feather-file-text"></i> Bản nháp (Đã lưu Draft)</span>
                    @elseif($isPending)
                        <span class="badge bg-warning text-dark p-2"><i class="feather-clock"></i> Đang chờ duyệt</span>
                    @else
                        <span class="badge bg-success p-2"><i class="feather-check-circle"></i> Đã duyệt (Official)</span>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button wire:click.prevent="changeOrChangeVideo"
                            class="rbt-btn btn-sm bg-danger-opacity radius-round"
                            wire:confirm="Bạn có chắc chắn muốn xóa/thay đổi video này không?">
                        <i class="feather-trash-2"></i> Xóa / Thay đổi
                    </button>

                    @if($hasTempFile)
                        <button wire:click.prevent="saveVideo" class="rbt-btn btn-sm btn-gradient radius-round">
                            <i class="feather-save"></i> Xác nhận lưu
                        </button>
                    @endif
                </div>
            </div>
        </div>

    @else
        <div x-data
             x-on:click="$refs.videoInput.click()"
             class="d-flex flex-column align-items-center justify-content-center p-5 position-relative"
             wire:loading.class="opacity-50"
             style="min-height: 250px; cursor: pointer; border: 2px dashed #2f57ef; border-radius: 12px; background-color: #f8f9fc; transition: all 0.3s ease;">

            <div class="upload-area__icon mb-3">
                <i class="feather-video" style="font-size: 4rem; color: #2f57ef;"></i>
            </div>

            <div class="upload-area__text text-center">
                <h6 class="mb-3 fw-bold">Kéo và thả video vào đây</h6>
                <p class="text-muted mb-4">Hoặc nhấn để chọn tệp từ máy tính</p>

                <input type="file"
                       id="video-upload"
                       wire:model="video"
                       accept="video/mp4,video/webm,video/mov"
                       style="display: none;"
                       x-ref="videoInput">

                <button class="rbt-btn btn-md btn-gradient hover-icon-reverse" type="button">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Chọn tệp Video</span>
                        <span class="btn-icon"><i class="feather-folder-plus"></i></span>
                        <span class="btn-icon"><i class="feather-folder-plus"></i></span>
                    </span>
                </button>
            </div>
        </div>

        <div class="mt-3">
            <small class="text-muted">
                <i class="feather-info"></i> Định dạng hỗ trợ: <strong>MP4, WebM, MOV</strong>. Dung lượng tối đa:
                <strong>250MB</strong>.
            </small>
        </div>
    @endif

    @error('video')
    <small class="text-danger d-block mt-2">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
</div>
