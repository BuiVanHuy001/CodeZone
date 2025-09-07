<div wire:ignore.self
     class="rbt-default-modal modal fade"
     id="updateModule" tabindex="-1" aria-labelledby="updateModuleLabel"
     aria-hidden="true" data-bs-backdrop="static"
>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        @class([
                            'rbt-round-btn',
                            'disabled' => $errors->has("module.title")
                        ])
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    <i class="feather-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="inner rbt-default-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="modal-title mb--20" id="updateModuleLabel">Update Module </h5>
                            <x-client.dashboard.inputs.text
                                model="moduleTitle"
                                label="Module Title"
                                name="moduleTitle"
                                value="{{ $moduleTitle }}"
                                placeholder="Enter module title"
                                :error="$errors->has('moduleTitle')"
                                info='Enter a descriptive name for this module. E.g: "Introduction to Web Development" or "Advanced Data Analysis Techniques".'
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-circle-shape"></div>
            <div class="modal-footer pt--30">
                <button type="button"
                        wire:click="update"
                    @class([
                        'rbt-btn btn-border btn-md radius-round-10',
                        'disabled' => $errors->has("moduleTitle")
                    ])>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
