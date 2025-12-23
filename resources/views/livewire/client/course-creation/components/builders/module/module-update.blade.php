<div wire:ignore.self class="rbt-default-modal modal fade" id="updateModule" tabindex="-1"
     aria-labelledby="updateModuleLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button wire:click="cancel" type="button" class="rbt-round-btn">
                    <i class="feather-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="inner rbt-default-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="modal-title mb--20" id="updateModuleLabel">Cập nhật chương học</h5>
                            <x-client.dashboard.inputs.text
                                model="moduleTitle"
                                label="Tên chương học"
                                name="moduleTitle"
                                placeholder="Nhập tên chương học"
                                info='Nhập tên mô tả ngắn gọn nội dung của chương này. Ví dụ: "Tổng quan về phát triển Web" hoặc "Kỹ thuật phân tích dữ liệu nâng cao".'/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-circle-shape"></div>
            <div class="modal-footer pt--30 justify-content-between">
                <button type="button" wire:click="cancel" class="rbt-btn btn-border btn-md radius-round-10">
                    Hủy bỏ
                </button>

                <button type="button" wire:click="update" class="rbt-btn btn-md radius-round-10">
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</div>
