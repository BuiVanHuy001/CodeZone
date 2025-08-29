<div @class([
       'course-field mb--20 mt-3 position-relative border p-5 rounded',
       'border-danger' => $errors->has('quiz.*'),
   ])
     x-data="{ step: 1 }"
>
    <h6>Quiz: <span wire:text="quiz.title"></span></h6>
    <div class="position-absolute" style="right: 10px; top: 10px; cursor: pointer;">
        <div class="inner">
            <ul class="rbt-list-style-1 rbt-course-list d-flex gap-3 align-items-center">
                <li>
                    <button type="button" class="btn quiz-modal__edit-btn dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="feather-more-horizontal"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a wire:click="toggleShowDetail" class="dropdown-item" href="#" type="button">
                                @if($showDetail)
                                    <i class="feather-eye-off"></i>
                                    Hide detail
                                @else
                                    <i class="feather-edit-2"></i>
                                    Show detail
                                @endif
                            </a>
                        </li>
                        <li>
                            <a wire:click.prevent="removeQuiz" class="dropdown-item delete-item" href="#">
                                <i class="feather-trash"></i>
                                Delete
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    @if($showDetail)
        <div class="tab-1 question" x-show="step === 1">
            <x-client.dashboard.inputs.text
                model="quiz.title"
                name="quiz.title"
                label="Quiz Title"
                placeholder="Enter quiz title"
                info="Provide a clear, descriptive title for this quiz assessment."
                :isError="$errors->has('quiz.title')"
            />

            <x-client.dashboard.inputs.markdown-area
                id="quiz-description"
                label="Quiz Description"
                info="Markdown is supported"
            />
            <div class="d-flex pt--30 justify-content-between">
                <div class="content">
                    <button type="button" class="awe-btn bg-danger">
                        Cancel
                    </button>
                </div>
                <div class="content">
                    <button class="awe-btn" @click="$wire.validateStep1().then(ok => ok && (step = 2))">Next</button>
                </div>
            </div>
        </div>
        <div class="question tab-2" x-show="step === 2">
            @error('quiz.assessments_questions')
            <small class="text-danger">
                <i class="feather-alert-triangle"></i> {{ $message }}
            </small>
            @enderror
            <div class="course-field mb--20">
                @foreach($quiz['assessments_questions'] ?? [] as $questionIndex => $question)
                    <div x-data="{ open: false }"
                         class="rbt-course-wrape mb-4"
                         @style([
                             'border-color: red !important' => $errors->has("quiz.assessments_questions.$questionIndex.*"),
                         ])
                         wire:key="question-{{ $questionIndex }}"
                    >
                        <div class="d-flex justify-content-between">
                            <div class="inner d-flex align-items-center gap-2">
                                <h6 class="rbt-title mb-0">
                                    <strong>Question No.{{ $loop->iteration }}: </strong>{{ $question['content'] }}
                                </h6>
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
                                                <a wire:click.prevent="deleteQuestion({{ $questionIndex }})" class="dropdown-item delete-item" href="#">
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
                            <x-client.dashboard.inputs.text
                                model="quiz.assessments_questions.{{ $questionIndex }}.content"
                                name="quiz.assessments_questions.{{ $questionIndex }}.content"
                                label="Write your question here"
                                placeholder="Enter course title"
                                info="Provide a clear, descriptive title for this quiz assessment."
                                :isError="$errors->has('quiz.assessments_questions.'.$questionIndex.'.title')"
                            />

                            <x-client.dashboard.inputs.select
                                name="quiz.assessments_questions.{{ $questionIndex }}.type"
                                label="Select your question type"
                                placeholder="Select Question Type"
                                :options="\App\Models\AssessmentQuestion::$TYPES"
                                info="Select the type of question you want to create."
                                wire:model.lazy="quiz.assessments_questions.{{ $questionIndex }}.type"
                                :isError="$errors->has('quiz.assessments_questions.'.$questionIndex.'.type')"
                            />

                            <div class="course-field mb--20">
                                <h6>Options </h6>
                                @error("quiz.assessments_questions.$questionIndex.question_options")
                                <small class="text-danger d-block">
                                    <i class="feather-alert-triangle"></i> {{ $message }}
                                </small>
                                @enderror
                                <div class="course-field rbt-lesson-rightsidebar d-block mt--20">
                                    @foreach($question['question_options'] as $optionIndex => $option)
                                        <div wire:key="question-{{ $questionIndex }}-{{ $optionIndex }}"
                                             class="row mb-5 rbt-course-wrape"
                                             wire:ignore.self
                                            @style([
                                               'border-color: red !important' => $errors->has("quiz.assessments_questions.$questionIndex.question_options.$optionIndex.*"),
                                           ])
                                        >
                                            <div class="d-flex justify-content-between mb-2">
                                                <h6>Option {{ $loop->iteration }}</h6>
                                                <a wire:click.prevent="deleteOption({{ $loop->parent->index }}, {{ $optionIndex }})">
                                                    <i class="feather-trash me-auto"></i>
                                                </a>
                                            </div>
                                            <div class="col-lg-9  mb--20">
                                                <label class="form-label">Answer Content</label>
                                                <input class="mb-0"
                                                       type="text"
                                                       wire:model="quiz.assessments_questions.{{ $questionIndex }}.question_options.{{ $optionIndex }}.content"
                                                       placeholder="Type answer option here">
                                                @error("quiz.assessments_questions.$questionIndex.question_options.$optionIndex.content")
                                                <small class="text-danger">
                                                    <i class="feather-alert-triangle"></i> {{ $message }}
                                                </small>
                                                @enderror
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="rbt-form-check">
                                                    <input class="form-check-input"
                                                           wire:model="quiz.assessments_questions.{{ $questionIndex }}.question_options.{{ $optionIndex }}.is_correct"
                                                           type="checkbox" name="rbt-radio"
                                                           id="question-{{ $questionIndex }}-option-{{ $optionIndex }}.is_correct"
                                                    >
                                                    <label class="form-check-label"
                                                           for="question-{{ $questionIndex }}-option-{{ $optionIndex }}.is_correct">
                                                        Mark as correct answer
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="course-field">
                                                <h6 class="mb-3">Answer explanation</h6>
                                                <textarea wire:model="quiz.assessments_questions.{{ $questionIndex }}.question_options.{{ $optionIndex }}.explanation"></textarea>
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

                                @unless($errors->has("quiz.assessments_questions.$questionIndex.*"))
                                    <button @click="open = false" type="button" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Save Question</span>
                                            <span class="btn-icon"><i class="feather-save"></i></span>
                                            <span class="btn-icon"><i class="feather-save"></i></span>
                                        </span>
                                    </button>
                                @endunless
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
            <div class="d-flex pt--30 justify-content-between">
                <div class="content">
                    <button type="button"
                            class="awe-btn bg-danger"
                            wire:click="cancelQuizCreation">
                        Cancel
                    </button>
                </div>
                <div class="content">
                    <button type="button" class="awe-btn bg-info"
                            @click="step = 1">
                        Back
                    </button>

                    <button
                        type="button"
                        class="awe-btn"
                        @disabled($errors->has('quiz.title'))
                        wire:click="saveQuiz">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
@script
<script>
    const assignmentDescriptionEditor = document.getElementById('quiz-description-editor');
    new EditorView(
        {
            extensions: [
                lineNumbers(),
                markdown(),
                highlightActiveLineGutter(),
                highlightActiveLine(),
                highlightSpecialChars(),
                EditorView.lineWrapping,
                EditorView.domEventHandlers({
                    blur: (event, view) => {
                        $wire.set('quiz.description', view.state.doc.toString());
                    }
                }),
                EditorView.theme({
                    "&": {
                        height: "200px",
                        width: "100%",
                        border: "1px solid #ddd",
                        borderRadius: "4px",
                        padding: "10px",
                        fontSize: "13px",
                    },
                    ".cm-content": {
                        caretColor: "#000",
                    },
                }),
            ],
            doc: '',
            parent: assignmentDescriptionEditor,
        }
    )
</script>
@endscript
