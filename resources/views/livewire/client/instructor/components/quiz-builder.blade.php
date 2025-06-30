<div x-data="{ activeQuestion: 1 }" class="ms-5 mt-4 w-100 quiz-section rbt-default-form rbt-course-wrape" x-show="activeTab === 'quiz'" x-transition>
    <h5 class="modal-title mb--20 d-flex justify-content-between align-items-center">
        <div>Quiz</div>
        <div><i class="feather-trash me-auto"></i></div>
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
            @foreach($quiz['assessments_questions'] as $key => $question)
                <div x-data="{ open: true }" class="rbt-course-wrape mb-4">
                    <div class="d-flex justify-content-between" style="cursor: auto;">
                        <div class="inner d-flex align-items-center gap-2">
                            <h6 class="rbt-title mb-0"><strong>Question No.0{{ $key + 1 }}
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
                                            <a class="dropdown-item delete-item" href="#">
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
                            <input id="" wire:model="quiz.assessments_questions.{{ $key }}.content" type="text" placeholder="Type question here">
                        </div>
                        <div class="course-field mb--20">
                            <h6>Select your question type</h6>
                            <div class="rbt-modern-select bg-transparent height-45 w-100 mb--10">
                                <select id="questionType" wire:model="quiz.assessments_questions.{{ $key }}.type" class="w-100">
                                    <option value="" disabled selected>Select Question Type</option>
                                    @foreach(\App\Models\Assessment::$QUIZ_TYPES as $value => $label)
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
                                            <input id="" type="text" wire:model="quiz.assessments_questions.{{ $key }}.question_options.{{$optionIndex}}.content" placeholder="Type answer option here">
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="rbt-form-check">
                                                <input class="form-check-input" wire:model="quiz.assessments_questions.{{ $key }}.question_options.{{$optionIndex}}.is_correct" type="checkbox" name="rbt-radio" id="question-{{ $key }}-option-{{ $optionIndex }}">
                                                <label class="form-check-label" for="question-{{ $key }}-option-{{ $optionIndex }}">Mark
                                                    as correct answer</label>
                                            </div>
                                        </div>
                                        <div class="course-field">
                                            <h6 class="mb-3">Add answer explanation</h6>
                                            <textarea wire:model="quiz.assessments_questions.{{ $key }}.question_options.{{$optionIndex}}.explanation" id=""></textarea>
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
        <div class="course-field">
            <button wire:click="addQuestion" class="rbt-btn btn-active hover-icon-reverse rbt-sm-btn-2 btn-1" type="button" id="next-btn-2">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Add Question</span>
                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                </span>
            </button>
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

            <button type="button"
                    class="rbt-btn btn-border btn-md radius-round-10">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Import Quiz</span>
                    <span class="btn-icon"><i class="feather-download"></i></span>
                </span>
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
                    @click="if (activeQuestion < 2) activeQuestion++">Save & Next
            </button>
        </div>
    </div>
</div>
