<main class="rbt-main-wrapper">
    <div class="rbt-create-course-area bg-color-white rbt-section-gap position-relative">

        <a class="rbt-btn btn-gradient btn-sm hover-icon-reverse position-absolute"
           style="top: 10px; right: 10px"
           href="javascript:void(0);"
           onclick="window.history.back();"
        >
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Quay lại</span>
                <span class="btn-icon"><i class="feather-corner-down-left"></i></span>
                <span class="btn-icon"><i class="feather-corner-down-left"></i></span>
            </span>
        </a>

        <div class="container">
            <div class="row">
                <form wire:submit.prevent>
                    <div class="rbt-accordion-style rbt-accordion-01 rbt-accordion-06 accordion">
                        <div class="accordion" id="courseCreation">

                            <div @class([
                                   'accordion-item card',
                                   'border border-danger' => $errors->hasAny(['title', 'heading', 'description', 'category', 'level', 'price', 'startDate', 'endDate', 'image']),
                                ]) >
                                <h2 class="accordion-header card-header" id="accInfo">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#accCollapseInfo"
                                        aria-expanded="true"
                                        aria-controls="accCollapseInfo">
                                        Thông tin cơ bản
                                    </button>
                                </h2>
                                <div wire:ignore.self
                                     id="accCollapseInfo"
                                     class="accordion-collapse collapse show"
                                     aria-labelledby="accInfo"
                                     data-bs-parent="#courseCreation">
                                    <div class="accordion-body card-body">
                                        <div class="rbt-course-field-wrapper rbt-default-form">
                                            <x-client.dashboard.inputs.text
                                                model="title"
                                                name="title"
                                                label="Tiêu đề khóa học/Môn học"
                                                placeholder="Nhập tên khóa học"
                                                :$slug
                                            />

                                            <x-client.dashboard.inputs.text
                                                model="heading"
                                                name="heading"
                                                label="Mô tả tóm tắt"
                                                placeholder="Nhập một câu tóm tắt hấp dẫn"
                                                info="Dòng giới thiệu ngắn (heading) rõ ràng để thu hút sinh viên."
                                            />

                                            <livewire:client.shared.markdown-editor
                                                wire:model="description"
                                                label="Nội dung chi tiết khóa học"
                                                name="description"
                                                id="course-desc-editor"
                                                info="Hỗ trợ Markdown. Viết thoải mái nhé!"
                                                :error-message="$errors->first('description')"
                                            />

                                            <x-client.dashboard.course-creation.components.course-settings :$courseType/>

                                            <livewire:client.course-creation.components.course-thumbnail wire:model="thumbnail"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:client.course-creation.components.builders.course-builder wire:model="modules"/>
                        </div>
                    </div>

                    <div class="mt--10 row g-5">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                            <button type="button" wire:click="store" class="rbt-btn btn-gradient hover-icon-reverse w-100 text-center">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Lưu và Xuất bản </span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
