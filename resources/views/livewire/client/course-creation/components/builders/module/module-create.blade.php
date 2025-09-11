<div wire:ignore.self class="rbt-default-modal modal fade" id="addModule" tabindex="-1" aria-labelledby="addModuleLabel"
     aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="cancel">
                    <i class="feather-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="inner rbt-default-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="modal-title mb--20" id="addModuleLabel">Add Module </h5>
                            <x-client.dashboard.inputs.text
                                model="moduleTitle"
                                label="Module Title"
                                name="moduleTitle"
                                placeholder="Enter module title"
                                info='Enter a descriptive name for this module. E.g: "Introduction to Web Development" or "Advanced Data Analysis Techniques".'/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-circle-shape"></div>
            <div class="modal-footer pt--30 justify-content-between">
                <button type="button" wire:click="cancel" class="rbt-btn btn-border btn-md radius-round-10">
                    Cancel
                </button>

                <button type="button" wire:click="store" @class([
                    'rbt-btn btn-md radius-round-10',
                    'disabled' => $errors->has('moduleTitle'),
                ])>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>
