<main class="rbt-main-wrapper">
    <div class="rbt-create-course-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row">
                <form wire:submit="save">
                    <div class="rbt-accordion-style rbt-accordion-01 rbt-accordion-06 accordion">
                        <div class="accordion" id="courseCreation">
                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="accInfo">
                                    <button
                                        class="accordion-button"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#accCollapseInfo"
                                        aria-expanded="true"
                                        aria-controls="accCollapseInfo">
                                        Course Info
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
                                                label="Course Title"
                                                placeholder="Enter course title"
                                                :isError="$errors->has('title')"
                                                :$slug
                                            />

                                            <x-client.dashboard.inputs.text
                                                model="heading"
                                                name="heading"
                                                label="Course heading"
                                                placeholder="Enter your course heading"
                                                :isError="$errors->has('heading')"
                                                info="A catchy, clear headline to attract learners."
                                            />

                                            <x-client.dashboard.inputs.markdown-area
                                                id="description"
                                                label="About course"
                                                name="description"
                                                :isError="$errors->has('description')"
                                                info="Markdown is supported. Use it to describe your course in detail."
                                            />

                                            <div class="course-field mb--15 edu-bg-gray">
                                                <h6>Course Settings</h6>
                                                <div class="rbt-course-settings-content">
                                                    <div class="row g-5">
                                                        <div class="col-lg-4">
                                                            <div class="advance-tab-button advance-tab-button-1">
                                                                <ul class="rbt-default-tab-button nav nav-tabs" id="courseSetting"
                                                                    role="tablist">
                                                                    <li class="nav-item w-100" role="presentation">
                                                                        <a href="#" class="active" id="general-tab"
                                                                           data-bs-toggle="tab" data-bs-target="#general"
                                                                           role="tab" aria-controls="general" aria-selected="true">
                                                                            <span>General</span>
                                                                        </a>
                                                                    </li>
                                                                    @if (auth()->user()->isInstructor())
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#" id="price-tab" data-bs-toggle="tab"
                                                                               data-bs-target="#price" role="tab"
                                                                               aria-controls="price" aria-selected="true">
                                                                                <span>Price</span>
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li class="nav-item w-100" role="presentation">
                                                                            <a href="#" id="batch-tab" data-bs-toggle="tab"
                                                                               data-bs-target="#batch" role="tab"
                                                                               aria-controls="batch" aria-selected="true">
                                                                                <span>Batch time</span>
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    <li class="nav-item w-100" role="presentation">
                                                                        <a href="#" id="information-tab" data-bs-toggle="tab"
                                                                           data-bs-target="#information" role="tab"
                                                                           aria-controls="information" aria-selected="true">
                                                                            <span>Additional Information</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <div class="tab-content">
                                                                <div class="tab-pane fade advance-tab-content-1 active show"
                                                                     id="general" role="tabpanel" aria-labelledby="general-tab">
                                                                    <x-client.dashboard.inputs.select
                                                                        wire:model="category"
                                                                        placeholder="Select Course Category"
                                                                        label="Course Categories"
                                                                        name="category"
                                                                        info="Select the category of your course."
                                                                        :isError="$errors->has('category')"
                                                                        :options="App\Models\Category::all()"
                                                                    />

                                                                    <x-client.dashboard.inputs.select
                                                                        wire:model="level"
                                                                        placeholder="Select Course Level"
                                                                        label="Course Levels"
                                                                        name="level"
                                                                        info="Select the level of your course."
                                                                        :isError="$errors->has('level')"
                                                                        :options="App\Models\Course::$LEVELS"
                                                                    />
                                                                </div>

                                                                @if (auth()->user()->isInstructor())
                                                                    <div class="tab-pane fade advance-tab-content-1" id="price"
                                                                         role="tabpanel" aria-labelledby="price-tab">
                                                                        <div class="course-field mb--15">
                                                                            <x-client.dashboard.inputs.text
                                                                                wire:model.number="price"
                                                                                label="Regular Price (₫)"
                                                                                name="price"
                                                                                placeholder="₫ Regular Price"
                                                                                type="number"
                                                                                :isError="$errors->has('price')"
                                                                                info="The Course Price Includes Your Author Fee."
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="tab-pane fade advance-tab-content-1" id="batch"
                                                                         role="tabpanel" aria-labelledby="batch-tab">
                                                                        <div class="course-field mb--15">
                                                                            <x-client.dashboard.inputs.text
                                                                                model="startDate"
                                                                                type="date"
                                                                                label="Start time"
                                                                                name="start_time"
                                                                                info="Start at 00:00"
                                                                                :isError="$errors->has('startDate')"
                                                                            />

                                                                            <x-client.dashboard.inputs.text
                                                                                model="endDate"
                                                                                label="End time"
                                                                                type="date"
                                                                                name="end_time"
                                                                                info="End at 23:59"
                                                                                :isError="$errors->has('endDate')"
                                                                            />
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <div class="tab-pane fade advance-tab-content-1" id="information"
                                                                     role="tabpanel" aria-labelledby="information-tab">
                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="skills"
                                                                        label="Skills" name="skills"
                                                                        placeholder="Add your course skills student can gain after your course here."/>
                                                                    <x-client.dashboard.inputs.text-area
                                                                        wire:model="requirements"
                                                                        label="Requirements" name="requirements"
                                                                        placeholder="Add your course requirements here."/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="course-field mb--20">
                                                <h6>Course Thumbnail</h6>
                                                <div class="rbt-create-course-thumbnail upload-area">
                                                    <div class="upload-area">
                                                        <div class="brows-file-wrapper" data-black-overlay="9">
                                                            @if ($imageUrl)
                                                                <img src="{{ $imageUrl }}" alt="preview">
                                                                <button style="z-index: 999" type="button" wire:click="deleteImage">
                                                                    Cancel Button
                                                                </button>
                                                            @else
                                                                <img src="{{ asset('images/others/thumbnail-placeholder.svg') }}"
                                                                     alt="placeholder">
                                                            @endif

                                                            <input wire:model="image" id="createinputfile" name="thumbnail_url"
                                                                   type="file" class="inputfile"
                                                                   accept="image/png,image/jpeg,image/webp,image/jpg"/>
                                                            <label class="d-flex" for="createinputfile" title="No File Chosen">
                                                                <i class="feather-upload"></i>
                                                                <span class="text-center">Choose your course thumbnail</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <small><i class="feather-info"></i> <b>Size:</b> 700x430 pixels, <b>File
                                                            Support:</b>
                                                        JPG, JPEG, PNG, WEBP</small>
                                                </div>
                                            </div>
                                            @error('image')
                                            <small class="d-block mb-3 text-danger" style="margin-top: -20px">
                                                <i class="feather-alert-triangle"></i> {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:client.course-creation.components.builders.course wire:model="modules"/>

                            @if (auth()->user()->isOrganization())
                                <div class="accordion-item card">
                                    <h2 class="accordion-header card-header" id="accMembers">
                                        <button class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accCollapseMembers"
                                                aria-expanded="true"
                                                aria-controls="accCollapseMembers">
                                            Add members to course
                                        </button>
                                    </h2>
                                    <div wire:ignore.self
                                         id="accCollapseMembers"
                                         class="accordion-collapse collapse"
                                         aria-labelledby="accMembers"
                                         data-bs-parent="#courseCreation">
                                        <livewire:client.organization.components.add-learners-builder wire:model="employeesAssigned"/>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="mt--10 row g-5">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-8">
                            <button type="submit" class="rbt-btn btn-gradient hover-icon-reverse w-100 text-center">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Create Course</span>
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
@script
<script>
    new EditorView(
        {
            extensions: [
                lineNumbers(),
                markdown(),
                highlightSpecialChars(),
                EditorView.lineWrapping,
                EditorView.updateListener.of(update => {
                    if (update.docChanged) {
                        $wire.description = update.state.doc.toString();
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
            parent: document.getElementById('description-editor'),
        }
    );
</script>
@endscript

@push('scripts')
    <script type="module">
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('assignment-programming-ready', () => {
                const assignmentProgrammingDesc = document.getElementById('description-editor');
                const courseDescriptionInput = document.getElementById('input-description-editor');
                if (assignmentProgrammingDesc && !assignmentProgrammingDesc.querySelector('.cm-editor')) {
                    new EditorView(
                        {
                            extensions: [
                                lineNumbers(),
                                python(),
                                highlightSpecialChars(),
                                EditorView.lineWrapping,
                                EditorView.updateListener.of(update => {
                                    if (update.docChanged) {
                                        courseDescriptionInput.value = update.state.doc.toString();
                                        courseDescriptionInput.dispatchEvent(new Event('input'));
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
                            parent: assignmentProgrammingDesc,
                        }
                    );
                }
            });
            Livewire.on('assignment-programming-updated', function (data) {
                const codeTemplates = JSON.parse(data.codeTemplate);
                const languages = Object.keys(codeTemplates);
                console.log("Programming languages available:", languages);
                console.log(codeTemplates);
                setTimeout(() => {
                    languages.forEach(function (langKey) {
                        const editorId = `code-editor-${langKey}`;
                        const parentElement = document.getElementById(editorId);

                        if (parentElement && !parentElement.querySelector('.cm-editor')) {
                            let languageExtension;
                            switch (langKey) {
                                case 'python':
                                    languageExtension = python();
                                    break;
                                case 'js':
                                    languageExtension = javascript();
                                    break;
                                case 'java':
                                    languageExtension = java();
                                    break;
                                case 'cpp':
                                    languageExtension = cpp();
                                    break;
                                case 'php':
                                    languageExtension = php();
                                    break;
                                default:
                                    languageExtension = [];
                            }

                            new EditorView({
                                extensions: [
                                    lineNumbers(),
                                    foldGutter(),
                                    autocompletion(),
                                    CodeMirrorHistory(),
                                    languageExtension,
                                    highlightActiveLine(),
                                    highlightActiveLineGutter(),
                                    oneDark,
                                    keymap.of([...defaultKeymap, ...historyKeymap]),
                                    EditorView.lineWrapping,
                                    EditorView.theme({
                                        "&": {
                                            height: "300px",
                                            width: "100%",
                                            border: "1px solid #ddd",
                                            borderRadius: "4px",
                                            padding: "10px",
                                            fontSize: "13px",
                                        },
                                        ".cm-content": {
                                            caretColor: "#fff",
                                        },
                                    }),
                                ],
                                doc: codeTemplates[langKey],
                                parent: parentElement
                            });
                        }
                    });
                }, 500);
            });

            Livewire.on('test', function (data) {
                console.log(data);
            })
        });
    </script>
@endpush
