<x-client.dashboard.course-creation.builders.assessment-types.base
    title="Bài tập nộp file (Assignment)"
    name="assignment">

    <div x-show="showDetail">
        <div class="row g-4 mb-4">
            <div class="col-12">
                <x-client.dashboard.inputs.text
                    model="assignment.title"
                    name="assignment.title"
                    label="Tiêu đề bài tập"
                    placeholder="Ví dụ: Nộp báo cáo cuối kỳ, Đồ án thiết kế..."
                    info="Đặt tên gợi nhớ để sinh viên dễ dàng nhận biết."
                />
            </div>

            <div class="col-12">
                <livewire:client.shared.markdown-editor
                    wire:model="assignment.description"
                    label="Mô tả yêu cầu / Đề bài"
                    name="assignment.description"
                    :errorMessage="$errors->first('assignment.description')"
                    placeholder="Nhập chi tiết yêu cầu, hướng dẫn làm bài..."
                    info="Hỗ trợ định dạng Markdown."
                />
            </div>
        </div>

        <div class="d-flex pt--30 justify-content-between">
            <div class="content">
                <button type="button" class="rbt-btn btn-border btn-md radius-round-10 bg-white text-danger" wire:click="remove">
                    Hủy bỏ
                </button>
            </div>

            <div class="content">
                <button type="button" class="rbt-btn btn-md radius-round-10 btn-gradient hover-icon-reverse" wire:click="save">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Lưu bài tập</span>
                        <span class="btn-icon"><i class="feather-save"></i></span>
                        <span class="btn-icon"><i class="feather-save"></i></span>
                    </span>
                </button>
            </div>
        </div>

    </div>
</x-client.dashboard.course-creation.builders.assessment-types.base>

