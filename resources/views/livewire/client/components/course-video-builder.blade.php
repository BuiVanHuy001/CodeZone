<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20" id="LessonLabel">Lesson video</h5>
    <div class="rbt-create-course-thumbnail p-4 rounded border text-center">
        @if($this->videoURL)
            <video width="100%" controls>
                <source src="{{ $videoURL }}" type="video/mp4">
            </video>
        @else
            <div x-data
                 x-on:click="$refs.videoInput.click()"
                 class="d-flex flex-column align-items-center justify-content-center"
                 style="min-height: 220px; cursor: pointer;">
                <div class="upload-area__icon mb-3">
                    <i class="feather-video" style="font-size: 3rem; color: #0d6efd;"></i>
                </div>

                <div class="upload-area__text">
                    <h6 class="mb-4 fw-bold">Drag & Drop your video here</h6>
                    <input type="file"
                           id="video-upload"
                           wire:model="videoURL"
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
    <small class="d-block mt-2 text-muted">
        <i class="feather-info"></i>
        <b>File Support:</b> MP4, MOV
    </small>
    <div class="d-flex pt--30 justify-content-between">
        <button type="button" class="rbt-btn btn-border btn-md radius-round-10" wire:click="deleteVideo">
            Cancel
        </button>
        <button type="button" wire:click="saveVideo" class="rbt-btn btn-md radius-round-10">Save
        </button>
    </div>
</div>
