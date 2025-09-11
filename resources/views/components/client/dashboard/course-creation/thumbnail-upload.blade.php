<div class="rbt-create-course-thumbnail upload-area">
    <div class="upload-area">
        <div class="brows-file-wrapper" data-black-overlay="9">
            @if ($imageUrl)
                <img src="{{ $imageUrl }}" alt="preview">
                <button style="z-index: 999" type="button" wire:click="$cancelUpload('image')">
                    Cancel Button
                </button>
            @else
                <img src="{{ asset('images/others/thumbnail-placeholder.svg') }}"
                     alt="placeholder">
            @endif

            <input wire:model="image" id="createinputfile" name="thumbnail_url"
                   type="file" class="inputfile"
                   accept="image/png,image/jpeg,image/webp,image/jpg"/>
            <label class="d-flex" for="createinputfile" title="No File Chosen">
                <i class="feather-upload"></i>
                <span class="text-center">Choose your course thumbnail</span>
            </label>
        </div>
    </div>
    <small><i class="feather-info"></i> <b>Size:</b> 700x430 pixels, <b>File
            Support:</b>
        JPG, JPEG, PNG, WEBP</small>
    @error('image')
</div>
