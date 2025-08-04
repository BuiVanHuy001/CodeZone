<div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape">
    <h5 class="modal-title mb--20" id="LessonLabel">Programming Assessment</h5>
    <div class="course-field mb--20">
        <label for="{{ "assessment-title-$moduleIndex-$lessonIndex" }}">Title</label>
        <input id="{{ "assessment-title-$moduleIndex-$lessonIndex" }}" wire:model="programmingPractice.title" type="text" placeholder="Type your assignments title">
    </div>

    <div class="course-field mb--30" wire:ignore>
        <label>Description</label>
        <div id="programming-practice-description-{{ $moduleIndex }}-{{ $lessonIndex }}-editor"></div>
        <input wire:model="programmingPractice.description" type="hidden" id="programming-practice-description-{{ $moduleIndex }}-{{ $lessonIndex }}-input"/>
        <small>Markdown is supported.</small>
    </div>

    <div class="course-field mb--20 col-lg-6">
        <label>Function name</label>
        <input type="text"
               wire:model.blur="problemDetails.functionName"
               placeholder="Type the function name">
    </div>

    <div class="course-field mb--20 col-lg-6">
        <label>Function return type</label>
        <select wire:model="problemDetails.returnType" class="h-auto">
            @foreach($typeMap as $label => $type)
                <option value="{{ $label }}">{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div x-data="{ addParameterButton: true, parameterForm: false }" class="course-field mb--20 col-lg-6">
        <label>Parameter List</label>
        <div class="row">
            @forelse($problemDetails['params'] as $index => $param)
                <div class="col-9">
                    <p class="mb-0"><code>{{ $param['type'] }}</code> {{ $param['name'] }}</p>
                </div>
                <div class="col-3">
                    <i class="feather-trash" wire:click="removeParameter({{ $index }})"></i>
                </div>
            @empty
                <div class="col-12">
                    <small class="mb-0">No parameters added yet.</small>
                </div>
            @endforelse
        </div>

        <template x-if="parameterForm">
            <div class="d-flex justify-center flex-wrap mt-2" x-data="{ type: '', name: '' }">
                <div class="w-50">
                    <select class="h-auto" x-model="type">
                        <option value="" disabled selected>Data type</option>
                        @foreach($typeMap as $label => $type)
                            <option value="{{ $label }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-50">
                    <input class="mb-0" type="text" placeholder="paramName" x-model="name">
                </div>
                <div class="w-100 mt-2">
                    <button type="button"
                            class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                            @click="parameterForm = false; addParameterButton = true;">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Cancel</span>
                        <span class="btn-icon"><i class="feather-x-square"></i></span>
                        <span class="btn-icon"><i class="feather-x-square"></i></span>
                    </span>
                    </button>
                    <button type="button"
                            class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                            @click="parameterForm = false; addParameterButton = true;
                                    $wire.addParameter(type, name); type = ''; name = ''">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Add</span>
                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                    </span>
                    </button>
                </div>
            </div>
        </template>

        <template x-if="addParameterButton">
            <button @click="parameterForm = true; addParameterButton = false"
                    type="button"
                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2 w-100 mt-3">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Add Parameter</span>
                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                    </span>
            </button>
        </template>
    </div>

    <div class="course-field mb--20 col-lg-6" x-data="{testCaseForm: false, addTestCaseButton: true}">
        <label>TestCase list</label>
        <div>
            @forelse($testCases as $index => $testCase)
                <ul>
                    <li x-data="{ open: false }" wire:key="testcase-list-{{ $index }}" class="mb-2">
                        <div @click="open = !open" class="d-flex justify-content-between align-items-center" style="cursor: pointer;">
                            <strong>TestCase {{ $index + 1 }}</strong>
                            <div>
                                <i class="feather-trash me-2" wire:click.stop="removeTestCase({{ $index }})"></i>
                                <i :class="open ? 'feather-chevron-up' : 'feather-chevron-down'"></i>
                            </div>
                        </div>
                        <ul x-show="open" style="display: none;" class="mt-2 ps-4">
                            <li>
                                <strong>Input:</strong>
                                <ul class="ps-4">
                                    @foreach($testCase['input'] as $paramName => $paramDetails)
                                        <li>
                                            <code>{{ $paramDetails['type'] }}</code>
                                            {{ $paramName }} =
                                            <code>{{ is_array($paramDetails['value']) ? json_encode($paramDetails['value']) : $paramDetails['value'] }}</code>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="mt-1">
                                <strong>Output:</strong>
                                <code>{{ $this->problemDetails['returnType'] }}</code> =
                                <code>{{ is_array($testCase['output']['value']) ? json_encode($testCase['output']['value']) : $testCase['output']['value'] }}</code>
                            </li>
                        </ul>
                    </li>
                </ul>
            @empty
                <small class="mb-0">No test cases added yet.</small>
            @endforelse
        </div>

        @if(!empty($this->problemDetails['params']))
            <div x-show="testCaseForm">
                <h6 class="mt-3 mb-0 text-center">Add a new TestCase</h6>
                <ul>
                    <li>
                        <strong>Input</strong>
                        @foreach($this->problemDetails['params'] as $index => $param)
                            <div class="mb-2" wire:key="new-testcase-param-{{ $index }}-{{ $param['name'] }}">
                                <p class="m-0"><code>{{ $param['type'] }}</code> {{ $param['name'] }}
                                    <small>(<strong>Example:</strong>
                                        <code style="color: #d63384">{{ $typeMap[$param['type']]['example'] }}</code>)</small>
                                </p>
                                <input id="param-value-{{ $param['name'] }}"
                                       type="text"
                                       class="h-auto"
                                       wire:model="newTestCase.input.{{ $param['name'] }}.value"
                                       placeholder="Enter value for {{ $param['name'] }}">
                            </div>
                        @endforeach
                    </li>
                    <li>
                        <strong>Output</strong>
                        <p class="m-0"><code>{{ $problemDetails['returnType'] }}</code>
                            <small>(<strong>Example:</strong>
                                <code style="color: #d63384">{{ $typeMap[$problemDetails['returnType']]['example'] }}</code>)</small>
                        </p>
                        <input type="text"
                               class="h-auto"
                               wire:model="newTestCase.output.value"
                               placeholder="Type the expected output">
                    </li>
                </ul>
                <div class="row">
                    <button @click="testCaseForm = false; addTestCaseButton = true;"
                            type="button"
                            class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2 mt-3 col-4">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Cancel</span>
                        <span class="btn-icon"><i class="feather-x-square"></i></span>
                        <span class="btn-icon"><i class="feather-x-square"></i></span>
                    </span>
                    </button>
                    <button @click="testCaseForm = false; addTestCaseButton = true; $wire.addTestCase()"
                            type="button"
                            class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2 mt-3 col-8">
                    <span class="icon-reverse-wrapper">
                        <span class="btn-text">Save</span>
                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                    </span>
                    </button>
                </div>
            </div>

            <template x-if="addTestCaseButton">
                <button @click="testCaseForm = true; addTestCaseButton = false"
                        type="button"
                        class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2 w-100 mt-3">
            <span class="icon-reverse-wrapper">
                <span class="btn-text">Add a TestCase</span>
                <span class="btn-icon"><i class="feather-plus-square"></i></span>
                <span class="btn-icon"><i class="feather-plus-square"></i></span>
            </span>
                </button>
            </template>
        @endif
    </div>

    <div class="course-field mb--20 col-lg-6">
        <label>Allowed Programming Languages</label>
        <div wire:ignore x-data x-init="$nextTick(() => $('select[data-live-search]').selectpicker('render'))"
             x-show="true"
             class="rbt-modern-select b-g-transparent height-45 w-100">
            <select class="w-100" data-live-search="true"
                    wire:model.live.debounce.250ms="languages"
                    title="Select Language"
                    multiple data-size="7"
                    data-actions-box="true"
                    data-selected-text-format="count > 2">
                @foreach(\App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @foreach($languages as  $language)
        <div class="col-12">
            <label class="mt-3" for="code-editor-{{ $language }}">Code template
                for {{ \App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES[$language] }}</label>
            <div id="code-editor-{{ $language }}"></div>
            <input type="hidden" id="input-code-editor-{{ $language }}"/>
        </div>
    @endforeach

    <div class="d-flex pt--30 justify-content-between">
        <button type="button" class="rbt-btn btn-border btn-md radius-round-10">Cancel</button>
        <button type="button" class="rbt-btn btn-md radius-round-10" wire:click="saveProblemDetails">Save</button>
    </div>
</div>
@script
<script>
    const programmingPracticeDescriptionEditor = document.getElementById('programming-practice-description-{{ $moduleIndex }}-{{ $lessonIndex }}-editor');
    const programmingPracticeDescriptionInput = document.getElementById('programming-practice-description-{{ $moduleIndex }}-{{ $lessonIndex }}-input');
    new EditorView(
        {
            extensions: [
                lineNumbers(),
                markdown(),
                highlightActiveLineGutter(),
                highlightActiveLine(),
                highlightSpecialChars(),
                EditorView.lineWrapping,
                EditorView.updateListener.of(update => {
                    if (update.docChanged) {
                        programmingPracticeDescriptionInput.value = update.state.doc.toString();
                        programmingPracticeDescriptionInput.dispatchEvent(new Event('input'));
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
            doc: programmingPracticeDescriptionInput.value,
            parent: programmingPracticeDescriptionEditor,
        });
</script>
@endscript
