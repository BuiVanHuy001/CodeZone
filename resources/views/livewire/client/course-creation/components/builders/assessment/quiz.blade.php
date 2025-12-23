<x-client.dashboard.course-creation.builders.assessment-types.base
    title="Trắc nghiệm"
    name="quiz">
    <div x-show="step === 1">
        <x-client.dashboard.inputs.text
            model="quiz.title" name="quiz.title"
            label="Tiêu đề bài trắc nghiệm" placeholder="Nhập tiêu đề..."/>

        <div class="mt--20">
            <livewire:client.shared.markdown-editor
                wire:model="quiz.description"
                label="Mô tả"
                name="quiz.description"
                :errorMessage="$errors->first('quiz.description')"
            />
        </div>

        <div class="d-flex pt--30 justify-content-between">
            <button wire:click="remove" type="button" class="rbt-btn btn-border btn-md radius-round-10 bg-white text-danger">
                Hủy bỏ
            </button>
            <button class="rbt-btn btn-md radius-round-10 btn-gradient hover-icon-reverse"
                    @click.prevent="$wire.validateStep1().then(ok => ok && (step = 2))">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Tiếp theo</span>
                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                </span>
            </button>
        </div>
    </div>

    <div x-show="step === 2">
        <div class="d-flex flex-column gap-4">
            @foreach($quiz['assessments_questions'] ?? [] as $index => $question)
                <div class="rbt-single-quiz p-4 border bg-white rounded-3 shadow-sm position-relative">

                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="mb-0 w-75" style="line-height: 1.5;">
                            <span class="text-primary me-2">Câu {{ $loop->iteration }}:</span>
                            {{ $question['content'] ?: 'Chưa nhập nội dung...' }}
                        </h5>

                        <div class="d-flex gap-2">
                            <button wire:click="editQuestion({{ $index }})"
                                    class="rbt-btn btn-xs btn-white hover-icon-reverse radius-round-10"
                                    title="Chỉnh sửa">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Sửa</span>
                                    <span class="btn-icon"><i class="feather-edit"></i></span>
                                    <span class="btn-icon"><i class="feather-edit"></i></span>
                                </span>
                            </button>

                            <button wire:confirm="Xóa câu hỏi này?" wire:click="deleteQuestion({{ $index }})"
                                    class="rbt-btn btn-xs btn-white hover-icon-reverse radius-round-10 color-danger"
                                    title="Xóa">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Xóa</span>
                                    <span class="btn-icon"><i class="feather-trash-2"></i></span>
                                    <span class="btn-icon"><i class="feather-trash-2"></i></span>
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="row g-3">
                        @foreach($question['question_options'] as $opt)
                            <div class="col-lg-6">
                                <div class="rbt-form-check d-flex align-items-center p-3 rounded-2 border
                                     {{ !empty($opt['is_correct']) ? 'bg-color-primary-opacity border-primary' : 'bg-light' }}">

                                    <div class="d-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                        @if(!empty($opt['is_correct']))
                                            <i class="feather-check-circle text-primary fs-5"></i>
                                        @else
                                            <i class="feather-circle text-secondary opacity-50 fs-5"></i>
                                        @endif
                                    </div>
                                    <span class="ms-2 {{ !empty($opt['is_correct']) ? 'fw-bold text-primary' : '' }}">
                                        {{ $opt['content'] ?: '(Trống)' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 p-4 border-dashed rounded-3 bg-light d-flex justify-content-center gap-3 flex-wrap">
            <button wire:click="createQuestion" class="rbt-btn btn-white hover-icon-reverse radius-round-10 shadow-sm text-primary">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Thêm câu hỏi mới</span>
                    <span class="btn-icon"><i class="feather-plus"></i></span>
                    <span class="btn-icon"><i class="feather-plus"></i></span>
                </span>
            </button>

            <input wire:model="excelFile" type="file" style="display:none" x-ref="fileInput" accept=".xlsx,.csv">
            <button @click="$refs.fileInput.click()" class="rbt-btn btn-white hover-icon-reverse radius-round-10 shadow-sm text-success">
                 <span class="icon-reverse-wrapper">
                    <span class="btn-text">Import Excel</span>
                    <span class="btn-icon"><i class="feather-upload"></i></span>
                    <span class="btn-icon"><i class="feather-upload"></i></span>
                 </span>
            </button>
        </div>

        <div class="d-flex pt--30 justify-content-between">
            <button type="button" class="rbt-btn btn-border btn-md radius-round-10" @click="step = 1">Quay lại</button>
            <button class="rbt-btn btn-md radius-round-10 btn-gradient hover-icon-reverse" wire:click="saveQuiz">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Lưu bài trắc nghiệm</span>
                    <span class="btn-icon"><i class="feather-save"></i></span>
                    <span class="btn-icon"><i class="feather-save"></i></span>
                </span>
            </button>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="quizQuestionModal" tabindex="-1" data-bs-backdrop="static" style="z-index: 1060;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">
                        {{ $editingIndex === -1 ? 'Thêm câu hỏi mới' : 'Chỉnh sửa câu hỏi' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="$dispatch('close-modal', {id: 'quizQuestionModal'})" aria-label="Close"></button>
                </div>

                <div class="modal-body rbt-default-form bg-light">
                    <div class="p-4 bg-white rounded-3 border mb-4 shadow-sm">
                        <label class="form-label font-system-bold">Nội dung câu hỏi
                            <span class="text-danger">*</span></label>
                        <input type="text" wire:model="editingQuestion.content" class="form-control" placeholder="Nhập câu hỏi..." style="background: #f9f9f9;">
                    </div>

                    <label class="form-label font-system-bold px-1">Các lựa chọn trả lời</label>
                    <div class="d-flex flex-column gap-3">
                        @if(isset($editingQuestion['question_options']))
                            @foreach($editingQuestion['question_options'] as $optIndex => $opt)
                                <div class="option-item-wrapper d-flex align-items-center rounded-3 bg-white overflow-hidden {{ !empty($opt['is_correct']) ? 'is-correct' : '' }}">

                                    <div class="custom-check-circle"
                                         data-bs-toggle="tooltip"
                                         data-bs-placement="top"
                                         title="Tích chọn nếu đây là đáp án đúng">
                                        <input class="custom-check-input d-none" type="checkbox"
                                               id="opt-check-{{ $optIndex }}"
                                               wire:model="editingQuestion.question_options.{{ $optIndex }}.is_correct">
                                        <label class="custom-check-label mb-0 cursor-pointer" for="opt-check-{{ $optIndex }}">
                                            <i class="feather-check-circle fs-5"></i>
                                        </label>
                                    </div>

                                    <div class="flex-grow-1 px-3 py-2">
                                        <input type="text" class="form-control border-0 shadow-none p-0 bg-transparent"
                                               style="height: auto;"
                                               wire:model="editingQuestion.question_options.{{ $optIndex }}.content"
                                               placeholder="Nhập nội dung đáp án {{ $loop->iteration }}...">
                                    </div>

                                    <div class="pe-3">
                                        <button wire:click="deleteOptionFromEditing({{ $optIndex }})"
                                                class="rbt-btn btn-xs btn-white hover-icon-reverse radius-round-10 color-danger"
                                                title="Xóa lựa chọn này">
                                            <i class="feather-trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <button wire:click="addOptionToEditing" class="rbt-btn-link mt-3 font-system-bold text-primary">
                        <i class="feather-plus-circle"></i> Thêm lựa chọn khác
                    </button>
                </div>

                <div class="modal-footer border-top bg-white">
                    <button type="button" class="rbt-btn btn-sm btn-border radius-round-10" wire:click="$dispatch('close-modal', {id: 'quizQuestionModal'})">
                        Đóng
                    </button>
                    <button type="button" wire:click="saveQuestionFromModal" class="rbt-btn btn-sm btn-gradient radius-round-10">
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-client.dashboard.course-creation.builders.assessment-types.base>

@script
<script>
    const modalEl = document.getElementById('quizQuestionModal');
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            const parentModal = document.getElementById('addLesson');
            if (parentModal && parentModal.classList.contains('show')) {
                document.body.classList.add('modal-open');
            }
        });
    }
</script>
@endscript
