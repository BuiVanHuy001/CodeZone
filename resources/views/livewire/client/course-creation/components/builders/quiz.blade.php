<div x-data="{ activeQuestion: 1 }" class="ms-5 mt-4 w-100 quiz-section rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20 d-flex justify-content-between align-items-center">
        <div>Quiz</div>
        <div>
            <i wire:click="removeQuiz" @click="activeTab = null" class="feather-trash me-auto"></i>
        </div>
    </h5>
    <div id="question-{{ $lessonIndex }}-1" class="question" x-show="activeQuestion === 1">
        <div class="course-field mb--10">
            <label for="">Quiz Title</label>
            <input id="" wire:model="quiz.title" type="text" placeholder="Type your quiz title here">
        </div>
        <div class="course-field mb--20">
            <label for="modal-field-2">Quiz Description</label>
            <textarea wire:model="quiz.description" id="modal-field-2"></textarea>
            <small><i class="feather-info"></i>
                Add a summary of short text to prepare students for the
                activities for the Quiz. The text is shown on the course
                page beside the tooltip beside the Quiz name.
            </small>
        </div>
    </div>
    <div id="question-{{ $lessonIndex }}-2" class="question" x-show="activeQuestion === 2">
        <div class="course-field mb--20">
            @foreach($quiz['assessments_questions'] as $questionKey => $question)
                <div x-data="{ open: false }" class="rbt-course-wrape mb-4">
                    <div class="d-flex justify-content-between" style="cursor: auto;">
                        <div class="inner d-flex align-items-center gap-2">
                            <h6 class="rbt-title mb-0"><strong>Question No.{{ $questionKey + 1 }}
                                    : </strong> {{ $question['content'] }}</h6>
                        </div>
                        <div class="inner">
                            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-3 align-items-center">
                                <li>
                                    <button type="button" class="btn quiz-modal__edit-btn dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="feather-edit"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a @click.prevent="open = true" class="dropdown-item" href="#" type="button">
                                                <i class="feather-edit-2"></i>
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a wire:click.prevent="removeQuestion({{$questionKey}})" class="dropdown-item delete-item" href="#">
                                                <i class="feather-trash"></i>
                                                Delete
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div x-show="open">
                        <div class="course-field mb--20 mt-3">
                            <label for="">Write your question here</label>
                            <input id="" wire:model="quiz.assessments_questions.{{ $questionKey }}.content" type="text" placeholder="Type question here">
                        </div>
                        <div class="course-field mb--20">
                            <h6>Select your question type</h6>
                            <div class="rbt-modern-select bg-transparent height-45 w-100 mb--10">
                                <select id="questionType" wire:model="quiz.assessments_questions.{{ $questionKey }}.type" class="w-100">
                                    <option value="" disabled selected>Select Question Type</option>
                                    @foreach(\App\Models\AssessmentQuestion::$TYPES as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="course-field mb--20">
                            <h6>Options </h6>
                            <div class="course-field rbt-lesson-rightsidebar d-block mt--20">
                                @foreach($question['question_options'] as $optionIndex => $option)
                                    <div class="row mb-5 rbt-course-wrape">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label for="">Option {{ $optionIndex + 1 }}</label>
                                            <a href="#" wire:click.prevent="removeOption({{ $loop->parent->index }}, {{ $optionIndex }})"><i class="feather-trash me-auto"></i></a>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="text" wire:model="quiz.assessments_questions.{{ $questionKey }}.question_options.{{ $optionIndex }}.content" placeholder="Type answer option here">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="rbt-form-check">
                                                <input class="form-check-input" wire:model="quiz.assessments_questions.{{ $questionKey }}.question_options.{{ $optionIndex }}.is_correct" type="checkbox" name="rbt-radio" id="question-{{ $questionKey }}-option-{{ $optionIndex }}">
                                                <label class="form-check-label" for="question-{{ $questionKey }}-option-{{ $optionIndex }}">Mark
                                                    as correct answer</label>
                                            </div>
                                        </div>
                                        <div class="course-field">
                                            <h6 class="mb-3">Add answer explanation</h6>
                                            <textarea wire:model="quiz.assessments_questions.{{ $questionKey }}.question_options.{{ $optionIndex }}.explanation"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button wire:click="addOption({{ $loop->index }})" type="button" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Option</span>
                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                </span>
                            </button>

                            <button @click="open = false" type="button" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Save Question</span>
                                    <span class="btn-icon"><i class="feather-save"></i></span>
                                    <span class="btn-icon"><i class="feather-save"></i></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="course-field" x-data>
            <button wire:click="addQuestion" class="rbt-btn btn-active hover-icon-reverse rbt-sm-btn-2 btn-1" type="button" id="next-btn-2">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Add Question</span>
                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                </span>
            </button>

            <input wire:model="excelFile" type="file" accept=".xlsx,.csv,.xls,.json" style="display: none;" x-ref="fileInput">

            <button type="button" @click="$refs.fileInput.click()" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Import form File</span>
                    <span class="btn-icon"><i class="feather-download"></i></span>
                    <span class="btn-icon"><i class="feather-download"></i></span>
                </span>
            </button>

            <a href="{{ asset('excel_file/SampleImportQuiz.xlsx') }}" download class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Download Sample File</span>
                    <span class="btn-icon"><i class="feather-download"></i></span>
                    <span class="btn-icon"><i class="feather-download"></i></span>
                </span>
            </a>

        </div>
    </div>

    <div class="d-flex pt--30 justify-content-between">
        <div class="content">
            <button type="button"
                    wire:click="removeQuiz"
                    class="rbt-btn btn-border btn-md radius-round-10"
                    @click="activeTab = null">
                Cancel
            </button>
        </div>
        <div class="content">
            <button type="button"
                    class="rbt-btn btn-border btn-md radius-round-10 mr--10"
                    id="prev-btn"
                    @click="if (activeQuestion > 1) activeQuestion--">Back
            </button>
            <button type="button"
                    class="rbt-btn btn-md radius-round-10 d-inline-block"
                    @click="
            if (activeQuestion < 2) {
                activeQuestion++;
            } else {
                $wire.saveQuiz();
            }
        ">
                <span x-text="activeQuestion <= 1 ? 'Save & Next' : 'Save'"></span>
            </button>

        </div>
    </div>
</div>
