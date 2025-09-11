<div class="course-field mb--20">
    <h6>Course Thumbnail</h6>
    <div class="rbt-create-course-thumbnail upload-area">
        <div class="upload-area">
            <div class="brows-file-wrapper" data-black-overlay="9">
                @if ($imagePreview)
                    <img src="{{ $imagePreview }}" alt="preview">
                @else
                    <img src="{{ asset('images/others/thumbnail-placeholder.svg') }}"
                         loading="lazy"
                         alt="placeholder">
                @endif

                <input wire:model="image" id="createinputfile" name="thumbnail_url"
                       type="file" class="inputfile"
                       accept="image/png,image/jpeg,image/webp,image/jpg"
                />
                <label class="d-flex" for="createinputfile" title="No File Chosen">
                    <i class="feather-upload"></i>
                    <span class="text-center">Choose your course thumbnail</span>
                </label>
            </div>
        </div>
        <small><i class="feather-info"></i> <b>Size:</b> 700x430 pixels, <b>File Support:</b> JPG, JPEG, PNG,
            WEBP</small>
        @if($imagePreview)
            <button class="awe-btn bg-danger float-end" wire:click.prevent="deleteImage">
                <span>Delete</span>
            </button>
        @endif
    </div>
    @error('image')
    <small class="d-block mb-3 text-danger">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
</div>
