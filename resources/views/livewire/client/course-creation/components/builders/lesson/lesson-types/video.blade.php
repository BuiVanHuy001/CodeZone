<div class="course-field mb--20">
    <h6>Upload video</h6>
    @if($video && (!empty($previewVideo) || !empty($storedVideoAbsPath)))
        <video width="100%" controls>
            <source src="{{ $previewVideo ?? $storedVideoAbsPath }}" type="video/mp4">
        </video>
        @if(!empty($storedVideoAbsPath) && empty($previewVideo))
            <button wire:click="changeOrChangeVideo" class="awe-btn bg-danger">Delete/Change</button>
        @elseif(!empty($previewVideo) && empty($storedVideoAbsPath))
            <button wire:click="saveVideo" class="awe-btn">Save</button>
        @endif
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
                       accept="video/mp4,video/webm,video/mov"
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
    @error('video')
    <small class="text-danger d-block">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
</div>
