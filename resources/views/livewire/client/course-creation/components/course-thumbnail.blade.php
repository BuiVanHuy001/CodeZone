<div class="course-field mb--20">
    <h6>Ảnh đại diện khóa học</h6>
    <div class="rbt-create-course-thumbnail upload-area">
        <div class="upload-area">
            <div class="brows-file-wrapper" data-black-overlay="9">
                @if ($imagePreview)
                    <img src="{{ $imagePreview }}" alt="Xem trước ảnh đại diện">
                @else
                    <img src="{{ asset('images/others/thumbnail-placeholder.svg') }}"
                         loading="lazy"
                         alt="Ảnh mặc định">
                @endif

                <input wire:model="image" id="createinputfile" name="thumbnail_url"
                       type="file" class="inputfile"
                       accept="image/png,image/jpeg,image/webp,image/jpg"
                />
                <label class="d-flex" for="createinputfile" title="Chưa chọn tệp">
                    <i class="feather-upload"></i>
                    <span class="text-center">Tải lên ảnh đại diện khóa học</span>
                </label>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt--10">
            <small>
                <i class="feather-info"></i>
                <b>Kích thước chuẩn:</b> 700x430 pixels.
                <b>Định dạng:</b> JPG, JPEG, PNG, WEBP
            </small>

            @if($imagePreview)
                <button class="rbt-btn btn-xs bg-danger-opacity color-danger" wire:click.prevent="deleteImage">
                    <i class="feather-trash-2"></i> Xóa ảnh
                </button>
            @endif
        </div>
    </div>

    @error('image')
    <small class="d-block mt--10 text-danger">
        <i class="feather-alert-triangle"></i> {{ $message }}
    </small>
    @enderror
</div>
