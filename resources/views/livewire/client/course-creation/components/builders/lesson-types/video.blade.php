<div class="course-field mb--20">
    <h6>Upload video</h6>
    @if($video && (isset($previewVideo) || isset($storedVideo)))
        <video width="100%" controls>
            <source src="{{ $previewVideo ?? $storedVideo }}" type="video/mp4">
        </video>
        <button class="awe-btn bg-danger" wire:click="changeVideo">Choose different video</button>
        <button class="awe-btn" wire:click="saveVideo">Save</button>
    @else
        <div x-data
             x-on:click="$refs.videoInput.click()"
             class="d-flex flex-column align-items-center justify-content-center"
             style="min-height: 220px; cursor: pointer; border: 2px dashed #0d6efd; border-radius: 10px;">
            <div class="upload-area__icon mb-3">
                <i class="feather-video" style="font-size: 3rem; color: #0d6efd;"></i>
            </div>

            <div class="upload-area__text">
                <h6 class="mb-4 fw-bold">Drag & Drop your video here</h6>
                <input type="file"
                       id="video-upload"
                       wire:model="video"
                       accept="video/mp4,video/mov"
                       style="display: none;"
                       x-ref="videoInput">

                <button class="rbt-btn btn-md btn-gradient hover-icon-reverse"
                        type="button">
                        <span class="icon-reverse-wrapper">
                            <span class="btn-text">Browse Files</span>
                            <span class="btn-icon"><i class="feather-folder-plus"></i></span>
                            <span class="btn-icon"><i class="feather-folder-plus"></i></span>
                        </span>
                </button>
            </div>
        </div>
    @endif
</div>
