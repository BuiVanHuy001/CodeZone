<div wire:ignore.self class="rbt-default-modal modal fade" id="addLesson" tabindex="-1" aria-labelledby="LessonLabel"
     data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
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
                            <h5 class="modal-title mb--20" id="LessonLabel">Thêm bài học mới</h5>
                            <x-client.dashboard.inputs.text
                                model="lesson.title"
                                name="lesson.title"
                                label="Tiêu đề bài học"
                                placeholder="Ví dụ: Tổng quan về lập trình hướng đối tượng"
                                info="Nhập tên bài học mô tả rõ nội dung để sinh viên dễ dàng theo dõi."/>

                            <x-client.dashboard.inputs.select
                                name="lesson.type"
                                wire:model="lesson.type"
                                label="Định dạng bài học"
                                placeholder="-- Chọn loại bài học --"
                                :options="\App\Models\Lesson::$TYPES"
                                info="Chọn phương thức truyền tải nội dung phù hợp cho bài học này."/>

                            @if (!empty($lesson['type']))
                                <div @class([
                                    'course-field mb--20 mt-3 border p-5 rounded',
                                    'border-danger' => $errors->has([
                                        'lesson.assessment',
                                        'lesson.document',
                                        'lesson.video',
                                    ]),
                                ])>
                                    @switch($lesson['type'])
                                        @case('video')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.video/>
                                            @break

                                        @case('document')
                                            <livewire:client.shared.markdown-editor
                                                wire:model.blur="lesson.document"
                                                label="Nội dung bài học (Văn bản)"
                                                name="lesson.document"
                                                id="lesson-document-editor"
                                                info="Hệ thống hỗ trợ định dạng Markdown. Đây là nội dung chi tiết sẽ được hiển thị trực tiếp cho sinh viên trong bài học này!"
                                                :error-message="$errors->first('lesson.document')"
                                            />
                                            @break

                                        @case('assessment')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment
                                                wire:model="lesson.assessment"/>
                                            @break
                                    @endswitch
                                </div>
                            @endif

                            @if ($lesson['type'] && $lesson['type'] !== 'assessment')
                                <div class="course-field mb--20">
                                    <h6 class="rbt-checkbox-wrapper mb--5 d-flex align-items-center">
                                        <input wire:model.lazy="lesson.preview" id="rbt-checkbox-11"
                                               name="rbt-checkbox-11" type="checkbox" value="yes">
                                        <label for="rbt-checkbox-11" class="ms-2">Cho phép học thử</label>
                                    </h6>
                                    <small><i class="feather-info"></i> Sinh viên có thể xem trước nội dung bài học này
                                        để trải nghiệm phương pháp giảng dạy trước khi chính thức ghi danh.</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-circle-shape"></div>
            <div class="modal-footer pt--30 justify-content-between">
                <button type="button" class="rbt-btn btn-border btn-md radius-round-10" wire:click="cancel">
                    Hủy bỏ
                </button>
                <button type="button" class="rbt-btn btn-md radius-round-10" wire:click="addLesson">
                    Lưu bài học
                </button>
            </div>
        </div>
    </div>
</div>
