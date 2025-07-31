<form wire:submit="save">
    <div class="rbt-accordion-style rbt-accordion-01 rbt-accordion-06 accordion">
        <div class="accordion" id="courseInfo">
            <div class="accordion-item card">
                <h2 class="accordion-header card-header" id="accOne">
                    <button wire:click="setTab('info')"
                            class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#accCollapseOne"
                            aria-expanded="true"
                            aria-controls="accCollapseOne">Course Info
                    </button>
                </h2>
                <div id="accCollapseOne" @class([
                    'accordion-collapse collapse',
                    'show' => in_array('info', $openTabs),
                ])  aria-labelledby="accOne" data-bs-parent="#courseInfo">
                    <div class="accordion-body card-body">
                        <div class="rbt-course-field-wrapper rbt-default-form">
                            <livewire:client.components.text-input label="Course title"
                                                                   wire:model.live.debounce.250ms="title" name="title"
                                                                   placeholder="Enter your course title"/>
                            <div>
                                <small class="d-block mb-3" style="margin-top: -25px">
                                    <i class="feather-info"></i> Permalink: https://codezone.com/course/{{ $slug }}
                                </small>
                            </div>
                            @error('title')
                            <div>
                                <small class="d-block mb-3 text-danger" style="margin-top: -10px"><i
                                        class="feather-alert-triangle"></i> {{ $message }}
                                </small>
                            </div>
                            @enderror

                            <livewire:client.components.text-input label="Course heading" wire:model="heading"
                                                                   name="heading" placeholder="Enter your course heading"/>
                            <div>
                                <small class="d-block mb-3" style="margin-top: -25px">
                                    <i class="feather-info"></i> A catchy, clear headline to attract learners.
                                </small>
                            </div>

                            @error('heading')
                            <small class="d-block mb-5 text-danger" style="margin-top: -10px"><i
                                    class="feather-alert-triangle"></i> {{ $message }}
                            </small>
                            @enderror

                            <div class="course-field mb--15" wire:ignore>
                                <label for="description">About Course</label>
                                <input type="hidden" id="description_input" wire:model="description">
                                <div id="toolbar-container"></div>
                                <div id="description"></div>
                                <small class="d-block mt-3">
                                    <i class="feather-info"></i>Markdown is supported. Use it to describe your course in
                                    detail.
                                </small>
                            </div>

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
                                                    <div class="course-field mb--20">
                                                        <label for="category">Course category</label>
                                                        <div class="rbt-modern-select bg-transparent height-45 mb--10">
                                                            <select wire:model="category" class="w-100"
                                                                    id="category" name="category">
                                                                <option value="">Course category</option>
                                                                @foreach (\App\Models\Category::all() as $category)
                                                                    @foreach ($category->getChildren($category->id) as $children)
                                                                        <option value="{{ $children->id }}">
                                                                            {{ $category->name . '->' . $children->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('category')
                                                        <small class="d-block mb-3 text-danger">
                                                            <i class="feather-alert-triangle"></i> {{ $message }}
                                                        </small>
                                                        @enderror
                                                        <small><i class="feather-info"></i>Choose your course
                                                            category</small>
                                                    </div>

                                                    <livewire:client.components.select-input label="Course Levels"
                                                                                             wire:model="level" name="level" :options="App\Models\Course::$LEVELS"
                                                                                             placeholder="Select Course Level"/>
                                                    @error('level')
                                                    <small class="d-block mb-3 text-danger">
                                                        <i class="feather-alert-triangle"></i> {{ $message }}
                                                    </small>
                                                    @enderror
                                                </div>

                                                @if (auth()->user()->isInstructor())
                                                    <div class="tab-pane fade advance-tab-content-1" id="price"
                                                         role="tabpanel" aria-labelledby="price-tab">
                                                        <div class="course-field mb--15">
                                                            <livewire:client.components.text-input
                                                                label="Regular Price (₫)" wire:model.number="price"
                                                                name="price" placeholder="₫ Regular Price"
                                                                type="number"/>
                                                            @error('price')
                                                            <small class="d-block mb-3 text-danger"
                                                                   style="margin-top: -30px">
                                                                <i class="feather-alert-triangle"></i>
                                                                {{ $message }}
                                                            </small>
                                                            @enderror
                                                            <small class="d-block mt_dec--5">
                                                                <i class="feather-info"></i>The Course Price Includes
                                                                Your Author Fee.
                                                            </small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="tab-pane fade advance-tab-content-1" id="batch"
                                                         role="tabpanel" aria-labelledby="batch-tab">
                                                        <div class="course-field mb--15">
                                                            <livewire:client.components.text-input label="Start time"
                                                                                                   type="date" wire:model="startDate"
                                                                                                   name="start_time"/>
                                                            <small class="d-block mb-5" style="margin-top: -25px">
                                                                <i class="feather-info"></i>Start at 00:00
                                                            </small>
                                                            @error('startDate')
                                                            <small class="d-block mb-3 text-danger"
                                                                   style="margin-top: -30px">
                                                                <i class="feather-alert-triangle"></i>
                                                                {{ $message }}
                                                            </small>
                                                            @enderror

                                                            <livewire:client.components.text-input label="End time"
                                                                                                   type="date" wire:model="endDate"
                                                                                                   name="end_time"/>
                                                            <small class="d-block" style="margin-top: -25px">
                                                                <i class="feather-info"></i>End at 23:59
                                                            </small>
                                                            @error('endDate')
                                                            <small class="d-block mb-3 text-danger">
                                                                <i class="feather-alert-triangle"></i>
                                                                {{ $message }}
                                                            </small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="tab-pane fade advance-tab-content-1" id="information"
                                                     role="tabpanel" aria-labelledby="information-tab">
                                                    <livewire:client.components.textarea-input wire:model="skills"
                                                                                               label="Skills" name="skills"
                                                                                               placeholder="Add your course skills student can gain after your course here."/>
                                                    <livewire:client.components.textarea-input
                                                        wire:model="requirements" label="Requirements"
                                                        name="requirements"
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
                                </div>
                                <small><i class="feather-info"></i> <b>Size:</b> 700x430 pixels, <b>File Support:</b>
                                    JPG, JPEG, PNG, WEBP</small>
                                @error('image')
                            </div>
                            <small class="d-block mb-3 text-danger" style="margin-top: -20px">
                                <i class="feather-alert-triangle"></i> {{ $message }}
                            </small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <livewire:client.components.course.course-builder wire:model="modules"/>

            @if (auth()->user()->isBusiness())
                <div class="accordion" id="learner">
                    <div class="accordion-item card">
                        <h2 class="accordion-header card-header" id="learner">
                            <button wire:click="setTab('learners')" class="accordion-button" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#accCollapseLearner" aria-expanded="true"
                                    aria-controls="">
                                Add learners
                            </button>
                        </h2>
                        <div id="accCollapseLearner" @class([
                            'accordion-collapse collapse',
                            'show' => in_array('learners', $openTabs),
                        ]) aria-labelledby="learner"
                             data-bs-parent="#learner">
                            <livewire:client.business.components.add-learners-builder :openTabs="$openTabs"
                                                                                      wire:model="employeesAssigned"/>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
    <div class="mt--10 row g-5">
        <div class="col-lg-4">
            <button wire:click.prevent="showAlert"
                    class="rbt-btn hover-icon-reverse bg-primary-opacity w-100 text-center" href="">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Preview</span>
                    <span class="btn-icon"><i class="feather-eye"></i></span>
                    <span class="btn-icon"><i class="feather-eye"></i></span>
                </span>
            </button>
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
@script
<script>
    const courseDescriptionInput = document.querySelector('#description_input');
    new EditorView(
        {
            extensions: [
                lineNumbers(),
                markdown(),
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
            parent: document.getElementById('description'),
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
        });
    </script>
@endpush
