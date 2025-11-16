<div>
    <div id="create-instructor-modal" class="modal fade flip" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel" aria-hidden="true" data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Add instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form wire:submit="storeInstructor" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text"
                                       class="form-control @if ($errors->has('name')) is-invalid @elseif($name) is-valid @endif"
                                       id="fullName" wire:model.blur="name"
                                       placeholder="Enter full name" required>
                                <div class="valid-feedback">Looks good!</div>
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Email (Required) --}}
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control @if ($errors->has('email')) is-invalid @elseif($email) is-valid @endif"
                                       id="email" wire:model.blur="email" placeholder="Enter email" required>
                                <div class="valid-feedback">Looks good!</div>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                            <div class="col-9">
                                <label for="passwordInput" class="form-label">Password</label>
                                <input type="text"
                                       class="form-control @if ($errors->has('password')) is-invalid @elseif($password) is-valid @endif"
                                       id="passwordInput" wire:model.blur="password" placeholder="Enter password" required>
                                <div class="valid-feedback">Looks good!</div>
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-3 mt-auto">
                                <button class="btn btn-sm btn-primary" type="button" wire:click="generatePassword"
                                        wire:loading.attr="disabled" wire:target="generatePassword">
                                    <span wire:loading.remove.inline-flex wire:target="generatePassword" class="align-items-center">
                                        <i class="ri-refresh-line me-1"></i>
                                        <span>Generate</span>
                                    </span>
                                    <span wire:loading.inline-flex wire:target="generatePassword" class="align-items-center">
                                        <i class="ri-refresh-line ri-spin me-1"></i>
                                        <span>Generating</span>
                                    </span>
                                </button>
                            </div>

                            <div class="col-12">
                                <label for="major_id" class="form-label">Major (Specialty)</label>
                                <select id="major_id"
                                        class="form-select @if ($errors->has('major_id')) is-invalid @elseif($major_id) is-valid @endif"
                                        wire:model.blur="major_id" required>
                                    <option value="">Choose a major...</option>
                                    @foreach ($faculties as $faculty)
                                        <optgroup label="{{ $faculty->name }}">
                                            @foreach ($faculty->majors as $major)
                                                <option value="{{ $major->id }}">{{ $major->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">Looks good!</div>
                                @error('major_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="col-12">
                                    <label class="form-label">Avatar</label>
                                    <div wire:ignore>
                                        <div class="avatar-xl mx-auto">
                                            <input type="file"
                                                   class="filepond filepond-input-circle"
                                                   name="avatar"
                                                   accept="image/png, image/jpeg, image/gif, image/webp"
                                            />
                                        </div>
                                    </div>

                                    @error('avatar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <div class="mt-2">
                                        <label for="avatarLink" class="form-label text-muted">Or paste image link
                                            (Optional)</label>
                                        <input type="text"
                                               class="form-control mt-0 @error('avatarLink') is-invalid @enderror"
                                               id="avatarLink" wire:model.blur="avatarLink" placeholder="https://...">
                                        @error('avatarLink')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <span wire:loading.remove wire:target="storeInstructor">
                                            Create Instructor
                                        </span>
                                            <span wire:loading wire:target="storeInstructor">
                                            Creating...
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@assets
<style>
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .ri-spin {
        display: inline-block;

        animation: spin 1s linear infinite;
    }
</style>
<link href="{{ Vite::asset('resources/assets/admin/libs/filepond/filepond.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link
    href="{{ Vite::asset('resources/assets/admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}"
    rel="stylesheet" type="text/css"/>
<script src="{{ Vite::asset('resources/assets/admin/libs/filepond/filepond.min.js') }}"></script>
<script
    src="{{ Vite::asset('resources/assets/admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
</script>
<script
    src="{{ Vite::asset('resources/assets/admin/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
</script>
<script
    src="{{ Vite::asset('resources/assets/admin/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
</script>
<script
    src="{{ Vite::asset('resources/assets/admin/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
</script>
<script
    src="{{ Vite::asset('resources/assets/admin/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}">
</script>
@endassets

@script
<script>
    (function registerModalFilePond() {
        const modalEl = document.getElementById('create-instructor-modal');
        if (!modalEl) {
            console.warn('Create instructor modal element not found.');
            return;
        }
        if (modalEl.dataset.filepondBound === 'true') return;
        modalEl.dataset.filepondBound = 'true';

        function initFilePond() {
            const inputElement = modalEl.querySelector('input.filepond-input-circle');

            const avatarLinkInput = document.getElementById('avatarLink');

            if (!inputElement || !avatarLinkInput) {
                console.warn('FilePond or AvatarLink input not found.');
                return;
            }

            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType,
                FilePondPluginImageExifOrientation,
                FilePondPluginImagePreview
            );

            if (FilePond.find(inputElement)) return;

            const pond = FilePond.create(inputElement, {
                labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
                imagePreviewHeight: 170,
                imageCropAspectRatio: '1:1',
                imageResizeTargetWidth: 200,
                imageResizeTargetHeight: 200,
                stylePanelLayout: 'compact circle',
                styleLoadIndicatorPosition: 'center bottom',
                styleProgressIndicatorPosition: 'right bottom',
                styleButtonRemoveItemPosition: 'left bottom',
                styleButtonProcessItemPosition: 'right bottom',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'],
                fileValidateTypeLabelExpectedTypes: 'Expects {allButLastType} or {lastType}',
                fileValidateTypeLabelExpectedTypesMap: {
                    'image/png': '.png',
                    'image/jpeg': '.jpg/.jpeg',
                    'image/jpg': '.jpg',
                    'image/webp': '.webp'
                },
                maxFileSize: '5MB',
                labelMaxFileSizeExceeded: 'File is too large',
                labelMaxFileSize: 'Maximum file size is {filesize}',
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort) => {
                        @this.
                        upload('avatar', file,
                            (uploadedFilename) => {
                                load(uploadedFilename);
                            },
                            (err) => {
                                error(err);
                            },
                            (event) => {
                                progress(event.detail.progress);
                            }
                        );
                    },
                    revert: (filename, load) => {
                        @this.
                        removeUpload('avatar', filename, load);
                    }
                }
            });

            pond.on('addfile', (error, file) => {
                if (file) {
                    avatarLinkInput.disabled = true;
                    @this.
                    set('avatarLink', '');
                }
            });

            pond.on('removefile', (error, file) => {
                avatarLinkInput.disabled = false;
            });

            avatarLinkInput.addEventListener('input', (e) => {
                const pondRoot = inputElement.closest('.filepond--root');
                if (e.target.value.length > 0) {
                    pondRoot.style.pointerEvents = 'none';
                    pondRoot.style.opacity = '0.6';

                    if (pond.getFiles().length > 0) {
                        pond.removeFiles();
                    }
                } else {
                    pondRoot.style.pointerEvents = 'auto';
                    pondRoot.style.opacity = '1';
                }
            });
        }

        modalEl.addEventListener('shown.bs.modal', initFilePond);
    })();

    document.addEventListener('livewire:navigated', () => {
        const modalEl = document.getElementById('create-instructor-modal');
        if (modalEl && !modalEl.dataset.filepondBound) {
            modalEl.dataset.filepondBound = 'true';
            modalEl.addEventListener('shown.bs.modal', () => {
                const inputElement = modalEl.querySelector('input.filepond-input-circle');
                if (!inputElement) return;
                if (FilePond.find(inputElement)) return;
                FilePond.registerPlugin(
                    FilePondPluginFileEncode,
                    FilePondPluginFileValidateSize,
                    FilePondPluginFileValidateType,
                    FilePondPluginImageExifOrientation,
                    FilePondPluginImagePreview
                );
                FilePond.create(inputElement, {
                    labelIdle: 'Drag & Drop your picture or <span class="filepond--label-action">Browse</span>',
                    imagePreviewHeight: 170,
                    imageCropAspectRatio: '1:1',
                    imageResizeTargetWidth: 200,
                    imageResizeTargetHeight: 200,
                    stylePanelLayout: 'compact circle',
                    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'],
                    fileValidateTypeLabelExpectedTypes: 'Expects {allButLastType} or {lastType}',
                    maxFileSize: '5MB',
                    server: {
                        process: (fieldName, file, metadata, load, error, progress, abort) => {
                            @this.
                            upload('avatar', file,
                                (uploadedFilename) => {
                                    load(uploadedFilename);
                                },
                                (err) => {
                                    error(err);
                                },
                                (event) => {
                                    progress(event.detail.progress);
                                }
                            );
                        },
                        revert: (filename, load) => {
                            @this.
                            removeUpload('avatar', filename, load);
                        }
                    }
                });
            });
        }
    });
</script>
@endscript
