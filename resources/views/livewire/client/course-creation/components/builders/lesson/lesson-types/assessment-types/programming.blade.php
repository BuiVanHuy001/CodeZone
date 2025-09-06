<x-client.dashboard.course-creation.builders.assessment-types.base
    title="Programming"
    name="programming">
    <div x-show="showDetail">
        <div class="tab-1" x-show="step === 1">
            <x-client.dashboard.inputs.text
                model="programming.title"
                name="programming.title"
                label="Problem Title"
                placeholder="e.g., Two Sum, Valid Parentheses, Longest Substring"
                info="Enter a concise, descriptive title for your coding problem."
                :isError="$errors->has('programming.title')"
            />

            <x-client.dashboard.inputs.markdown-area
                id="programming-description{{ !empty($unique) ? '-' . $unique : '' }}"
                name="programming.description"
                label="Problem Description"
                info="Describe the problem statement, constraints, and examples. Markdown formatting is supported."
                :isError="$errors->has('programming.description')"
            />

            <div class="d-flex pt--30 justify-content-between">
                <div class="content">
                    <button wire:click="remove" type="button" class="awe-btn bg-danger">
                        Cancel
                    </button>
                </div>
                <div class="content">
                    <button class="awe-btn" @click="$wire.validateStep1().then(ok => ok && (step = 2))">Next</button>
                </div>
            </div>
        </div>
        <div class="tab-2 row" x-show="step === 2">
            <x-client.dashboard.inputs.text
                model="problem.function_name"
                class="col-lg-6"
                name="problem.function_name"
                label="Method Signature"
                placeholder="e.g., twoSum, findMedian, longestSubstring"
                info="Enter the main method name in camelCase format (e.g., twoSum, reverseList)."
                :isError="$errors->has('problem.function_name')"
            />

            <x-client.dashboard.inputs.select
                wire:model.lazy="problem.return_type"
                class="col-lg-6"
                name="problem.return_type"
                label="Return Type"
                :options="$typeMap"
                placeholder="Select a data type"
                info="Select the expected return type of the method."
                :isError="$errors->has('problem.return_type')"
            />

            <div class="course-field mb--20 col-lg-6">
                <label>Parameter List</label>
                <ul class="list-group list-group-flush">
                    @forelse($problem['params'] as $index => $param)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <code>{{ $typeMap[$param['type']]['label'] }}</code> {{ $param['name'] }}
                            <button
                                type="button"
                                class="btn btn-md btn-danger"
                                wire:click="removeParameter({{ $index }})"
                            >
                                <i class="feather-trash-2"></i>
                            </button>
                        </li>
                    @empty
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            No parameters added yet.
                        </li>
                    @endforelse
                </ul>
                <div class="row">
                    <div class="col-12 row">
                        @error('newParam.*')
                        <small class="text-danger d-block mb-2">
                            <i class="feather-alert-triangle"></i> {{ $message }}
                        </small>
                        @enderror
                        @error('problem.params')
                        <small class="text-danger d-block mb-2">
                            <i class="feather-alert-triangle"></i> {{ $message }}
                        </small>
                        @enderror
                        <div class="col-3 p-0">
                            <label>
                                <select
                                    style="height: 50px"
                                    wire:model.lazy="newParam.type"
                                    @class([
                                        'border-danger' => $errors->has('newParam.type')
                                    ])
                                >
                                    <option value="">Select a data type</option>
                                    @foreach($typeMap as $key => $type)
                                        <option value="{{ $key }}">{{ $type['label'] }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <div class="col-7 p-0">
                            <input
                                wire:model.lazy="newParam.name"
                                type="text"
                                placeholder="Param name"
                                @class([
                                        'form-control',
                                        'border-danger' => $errors->has('newParam.name')
                                ])/>
                        </div>
                        <div class="col-2 p-0">
                            <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                    type="button"
                                    wire:click="addParameter"
                                    style="height: 50px"
                            >
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Add</span>
                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="course-field mb--20 col-lg-6">
                <label>Testcases List</label>
                @error('newTestCase.output.*')
                <small class="text-danger d-block mb-2">
                    <i class="feather-alert-triangle"></i> {{ $message }}
                </small>
                @enderror
                <ul class="list-group list-group-flush">
                    @forelse($problem['test_cases'] as $index => $testCase)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Inputs:
                            <ul>
                                @foreach($testCase['inputs'] as $i => $input)
                                    <li class="list-group-item">
                                        <code>{{ $typeMap[$testCase['inputs'][$i]['type']]['label'] }}</code> {{ $testCase['inputs'][$i]['name'] }}
                                        =
                                        <code>{{ $testCase['inputs'][$i]['value'] }}</code>
                                    </li>
                                @endforeach
                            </ul>
                            Output:
                            <ul>
                                <li class="list-group-item">
                                    @if(isset($testCase['output']))
                                        <code>{{ $typeMap[$problem['return_type']]['label'] }}</code> expected =
                                        <code>{{ $testCase['output']['value'] }}</code>
                                    @endif
                                </li>
                            </ul>
                            <button
                                type="button"
                                class="btn btn-md btn-danger"
                                wire:click="removeTestCase({{ $index }})"
                            >
                                <i class="feather-trash-2"></i>
                            </button>
                        </li>
                    @empty
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            You need to add at least one parameter to create a test case.
                        </li>
                    @endforelse
                </ul>

                @if($problem['params'])
                    <div class="row">
                        <div class="col-12 row">
                            @foreach($this->newTestCase['inputs'] as $index => $param)
                                <x-client.dashboard.inputs.text
                                    model="newTestCase.inputs.{{ $index }}.value"
                                    name="newTestCase.inputs.{{ $index }}.value"
                                    label="{{ $param['name'] }}"
                                    info="Enter the input value for parameter '{{ $param['name'] }}' as {{ $typeMap[$param['type']]['label'] }} format (e.g: {{ $typeMap[$param['type']]['example'] }})."
                                    :isError="$errors->has('newTestCase.inputs.' . $index . '.value')"
                                />

                            @endforeach
                            @if(isset($newTestCase['output']))
                                <x-client.dashboard.inputs.text
                                    model="newTestCase.output.value"
                                    name="newTestCase.output.value"
                                    label="Expected Output"
                                    info="Enter the expected output value as {{ $typeMap[$problem['return_type']]['label'] }} format (e.g: {{ $typeMap[$problem['return_type']]['example'] }})."
                                    :isError="$errors->has('newTestCase.output.value')"
                                />
                            @endif
                            <div class="col-2 p-0">
                                <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                        type="button"
                                        wire:click="addTestCase"
                                        style="height: 50px"
                                >
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Add</span>
                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if($this->canSelectLanguages)
                <x-client.dashboard.inputs.live-search-select
                    model="problem.allowed_languages"
                    title="Allowed Languages"
                    class="col-lg-6"
                    name="problem.allowed_languages"
                    label="Allowed Languages"
                    placeholder="e.g., int, string"
                    info="Select the allowed programming languages for this problem."
                    :options="\App\Models\ProgrammingAssignmentDetails::$SUPPORTED_LANGUAGES"
                />
            @endif

            <div class="d-flex pt--30 justify-content-between">
                <div class="content">
                    <button wire:click="remove" type="button" class="awe-btn bg-danger">Cancel</button>
                </div>
                <div class="content">
                    <button type="button" class="awe-btn bg-info" @click="step = 1">Back</button>

                    <button wire:click="saveProgramming" type="button" class="awe-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
</x-client.dashboard.course-creation.builders.assessment-types.base>

@script
<script>
    new EditorView({
        extensions: [
            lineNumbers(),
            markdown(),
            highlightActiveLineGutter(),
            highlightActiveLine(),
            highlightSpecialChars(),
            EditorView.lineWrapping,
            EditorView.domEventHandlers({
                blur: (event, view) => {
                    $wire.set('programming.description', view.state.doc.toString());
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
        parent: document.getElementById('programming-description{{ !empty($unique) ? '-' . $unique : '' }}-editor')
    });
</script>
@endscript
