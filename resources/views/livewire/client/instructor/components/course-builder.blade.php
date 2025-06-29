<div class="card">
    <h2 class="card-header">
        <button type="button" class="accordion-button">Course Builder</button>
    </h2>
    <div>
        <div class="card-body">
            <div class="accordion-item card mb--10 p-3">
                <label for="import-file" class="form-label fw-bold">Import Course Structure</label>
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <input type="file" id="import-file" class="form-control" accept=".xlsx,.csv,.xls,.json" style="display: none;">
                        <button type="button" onclick="document.getElementById('import-file').click()" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                           <span class="icon-reverse-wrapper">
                               <span class="btn-text">Accepted formats: .xlsx, .csv, .json</span>
                               <span class="btn-icon"><i class="feather-download"></i></span>
                               <span class="btn-icon"><i class="feather-download"></i></span>
                           </span>
                        </button>
                    </div>
                    <div>
                        <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                           <span class="icon-reverse-wrapper">
                               <span class="btn-text">Download Sample File</span>
                               <span class="btn-icon"><i class="feather-download"></i></span>
                               <span class="btn-icon"><i class="feather-download"></i></span>
                           </span>
                        </button>
                    </div>
                </div>
            </div>

            @foreach ($modules as $module)
                <div class="accordion-item card mb--20 rbt-default-form">
                    <h6 class="card-header">
                        {{ empty($module['title']) || $module['title'] === "Example Module" ? 'Module ' . $loop->iteration : $module['title'] }}
                        <span class="rbt-course-icon rbt-course-edit"></span>
                        <span class="rbt-course-icon rbt-course-del"></span>
                    </h6>
                    <div>
                        <div class="course-field card-body">
                            <label for="modules.{{ $loop->index }}">Module title</label>
                            <div class="d-flex justify-content-between rbt-course-wrape mb-4">
                                <div class="col-10 inner d-flex align-items-center gap-2">
                                    <input wire:model.live.debounce.450ms="modules.{{ $loop->index }}.title" id="modules.{{ $loop->index }}" class="rbt-title mb-0" value="" placeholder="Enter {{('module ' . $loop->iteration)}} title"/>
                                </div>
                                <div class="col-2 inner">
                                    <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                        <li><i wire:click="removeModule({{ $loop->index }})" class="feather-trash"></i>
                                        </li>
                                        <li><i class="feather-edit"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <label>Module lessons</label>
                            @foreach ($module['lessons'] as $lesson)
                                <div class="d-flex justify-content-between flex-wrap rbt-course-wrape mb-4 ms-5">
                                    <div class="col-10 inner d-flex align-items-center gap-2">
                                        <input class="rbt-title mb-0" wire:model="modules.{{ $loop->parent->index }}.lessons.{{ $loop->index }}.title" id="modules.{{ $loop->parent->index }}.lessons{{ $loop->index }}.title" name="modules.{{ $loop->parent->index }}.lessons{{ $loop->index }}.title" placeholder="{{ $lesson['title'] }}"/>
                                    </div>
                                    <div class="col-2 inner">
                                        <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                            <li>
                                                <i wire:click="removeLesson({{ $loop->parent->index }}, {{ $loop->index }})" class="feather-trash"></i>
                                            </li>
                                            <li>
                                                <div class="rbt-checkbox">
                                                    <input type="checkbox" id="modules.{{ $loop->parent->index }}.lessons.{{ $loop->index }}.preview" name="modules.{{ $loop->parent->index }}.lessons.{{ $loop->index }}.preview" wire:model="modules.{{ $loop->parent->index }}.lessons.{{ $loop->index }}.preview">
                                                    <label for="modules.{{ $loop->parent->index }}.lessons.{{ $loop->index }}.preview">Preview</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-12 my-3 d-flex flex-wrap justify-content-between align-items-center" x-data="{ activeTab: null }">
                                        <div class="gap-3 d-flex flex-wrap">
                                            <button wire:click="addQuiz({{ $loop->parent->index . ',' . $loop->index }})" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button"
                                                    @click="activeTab = 'quiz'">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Quiz</span>
                                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                </span>
                                            </button>

                                            <button wire:click="addAssignment" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button"
                                                    @click="activeTab = 'assignment'">
                                                    <span class="icon-reverse-wrapper">
                                                        <span class="btn-text">Assignments</span>
                                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    </span>
                                            </button>

                                            <button wire:click="addContent" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button"
                                                    @click="activeTab = 'content'">
                                                            <span class="icon-reverse-wrapper">
                                                                <span class="btn-text">Content</span>
                                                                <span class="btn-icon"><i class="feather-book-open"></i></span>
                                                                <span class="btn-icon"><i class="feather-book-open"></i></span>
                                                            </span>
                                            </button>

                                            <button wire:click="addVideo" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" @click="activeTab = 'upload-video'">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Upload video</span>
                                                    <span class="btn-icon"><i class="feather-video"></i></span>
                                                    <span class="btn-icon"><i class="feather-video"></i></span>
                                                </span>
                                            </button>
                                        </div>

                                        @if($showQuiz && isset($lesson['assessments']))
                                            <livewire:client.instructor.components.quiz-builder
                                                :moduleIndex="$loop->parent->index"
                                                :lessonIndex="$loop->index"
                                                wire:model="modules.{{ $loop->parent->index }}.lessons.{{ $loop->index }}.assessments"
                                                :key="'quiz-' . $loop->parent->index . '-' . $loop->index"/>
                                        @endif

                                        @if($showAssignment)
                                            <div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape" x-show="activeTab === 'assignment'" x-transition>
                                                <h5 class="modal-title mb--20" id="LessonLabel">Assignment</h5>
                                                <div class="course-field mb--20"><label for="">Assignment
                                                        Title</label><input id="" type="text" placeholder="Assignments">
                                                </div>
                                                <div class="course-field mb--30">
                                                    <label for="modal-field-3">Summary</label>
                                                    <textarea id="editor3"></textarea>
                                                </div>
                                                <div class="d-flex pt--30 justify-content-between">
                                                    <button type="button" class="rbt-btn btn-border btn-md radius-round-10" @click="activeTab = null">
                                                        Cancel
                                                    </button>

                                                    <button type="button" class="rbt-btn btn-md radius-round-10">Save
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        @if($showContent)
                                            <div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape" x-show="activeTab === 'content'" x-transition>
                                                <h5 class="modal-title mb--20" id="LessonLabel">Lesson content</h5>
                                                <div class="course-field mb--30"><label for="modal-field-3">Summary
                                                        about lesson</label>
                                                    <textarea id="" rows="15"></textarea>
                                                </div>

                                                <div class="d-flex pt--30 justify-content-between">
                                                    <button type="button" class="rbt-btn btn-border btn-md radius-round-10" @click="activeTab = null">
                                                        Cancel
                                                    </button>
                                                    <button type="button" class="rbt-btn btn-md radius-round-10">Save
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        @if($showVideo)
                                            <div class="w-100 row assignment-section mt-4 inner rbt-default-form ms-5 rbt-default-form rbt-course-wrape" x-show="activeTab === 'upload-video'" x-transition>
                                                <h5 class="modal-title mb--20" id="LessonLabel">Lesson video</h5>
                                                <div class="rbt-create-course-thumbnail p-4 rounded border text-center">
                                                    <div x-data
                                                         x-on:click="$refs.videoInput.click()"
                                                         class="d-flex flex-column align-items-center justify-content-center"
                                                         style="min-height: 220px; cursor: pointer;">

                                                        <div class="upload-area__icon mb-3">
                                                            <i class="feather-video" style="font-size: 3rem; color: #0d6efd;"></i>
                                                        </div>

                                                        <div class="upload-area__text">
                                                            <h6 class="mb-4 fw-bold">Drag & Drop your video here</h6>
                                                            <input type="file"
                                                                   id="video-upload"
                                                                   accept="video/mp4,video/mov"
                                                                   style="display: none;"
                                                                   x-ref="videoInput">

                                                            <button class="rbt-btn btn-md btn-gradient hover-icon-reverse"
                                                                    type="button">
                                                            <span class="icon-reverse-wrapper">
                                                                <span class="btn-text">Browse Files</span>
                                                                <span class="btn-icon"><i class="feather-folder-plus"></i></span>
                                                                <span class="btn-icon"><i class="feather-folder-plus"></i></span>
                                                            </span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                                <small class="d-block mt-2 text-muted">
                                                    <i class="feather-info"></i>
                                                    <b>File Support:</b> MP4, MOV
                                                </small>
                                                <div class="d-flex pt--30 justify-content-between">
                                                    <button type="button" class="rbt-btn btn-border btn-md radius-round-10" @click="activeTab = null">
                                                        Cancel
                                                    </button>
                                                    <button type="button" class="rbt-btn btn-md radius-round-10">Save
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="button" wire:click="addLesson({{ $loop->index }})" class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Lesson</span>
                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <button class="rbt-btn btn-md btn-gradient hover-icon-reverse" type="button" wire:click="addModule">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Add New Module</span>
                    <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                    <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                </span>
            </button>
        </div>
    </div>
</div>
