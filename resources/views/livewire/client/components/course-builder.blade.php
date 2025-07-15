<div class="card">
    <h2 class="card-header">
        <button type="button" class="accordion-button">Course Builder</button>
    </h2>
    <div>
        <div class="card-body">
            @foreach ($modules as $moduleIndex => $module)
                <div class="accordion-item card mb--20 rbt-default-form">
                    <h6 class="card-header">
                        {{ empty($module['title']) || $module['title'] === "Example Module" ? 'Module ' . $moduleIndex + 1 : $module['title'] }}
                        <span class="rbt-course-icon rbt-course-edit"></span>
                        <span class="rbt-course-icon rbt-course-del"></span>
                    </h6>
                    <div>
                        <div class="course-field card-body">
                            <label for="modules.{{ $moduleIndex }}">Module title</label>
                            <div class="d-flex justify-content-between rbt-course-wrape mb-4">
                                <div class="col-10 inner d-flex align-items-center gap-2">
                                    <input
                                        wire:model.defer="modules.{{ $moduleIndex }}.title"
                                        id="modules.{{ $moduleIndex }}" class="rbt-title mb-0"
                                        placeholder="Enter module {{ $loop->iteration }} title"
                                    />
                                </div>
                                <div class="col-2 inner">
                                    <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                        <li><i wire:click="removeModule({{ $moduleIndex }})" class="feather-trash"></i>
                                        </li>
                                        <li><i class="feather-edit"></i></li>
                                    </ul>
                                </div>
                            </div>
                            <label>Module lessons</label>
                            @foreach ($module['lessons'] as $lessonIndex => $lesson)
                                <div class="d-flex justify-content-between flex-wrap rbt-course-wrape mb-4 ms-5">
                                    <div class="col-10 inner d-flex align-items-center gap-2">
                                        <input class="rbt-title mb-0"
                                               wire:model="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.title"
                                               id="modules.{{ $moduleIndex }}.lessons{{ $lessonIndex }}.title"
                                               name="modules.{{ $moduleIndex }}.lessons{{ $lessonIndex }}.title"
                                               placeholder="Enter lesson {{ $lessonIndex + 1 }} title"
                                        />
                                    </div>
                                    <div class="col-2 inner">
                                        <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                            <li>
                                                <i wire:click="removeLesson({{ $moduleIndex }}, {{ $lessonIndex }})" class="feather-trash"></i>
                                            </li>
                                            <li>
                                                <div class="rbt-checkbox">
                                                    <input type="checkbox" id="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview" name="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview" wire:model="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview">
                                                    <label for="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview">Preview</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-12 my-3 d-flex flex-wrap justify-content-between align-items-center" x-data="{ activeTab: null }">
                                        <div class="gap-3 d-flex flex-wrap">
                                            <button wire:click="addQuiz({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Quiz</span>
                                                    @if(isset($module['lessons'][$lessonIndex]['assessments']) && $module['lessons'][$lessonIndex]['assessments']['type'] === 'quiz')
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-help-circle"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-help-circle"></i></span>
                                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>

                                            <button wire:click="addAssignment({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Assignments</span>
                                                    @if(isset($module['lessons'][$lessonIndex]['assessments']) && $module['lessons'][$lessonIndex]['assessments']['type'] === 'assignment')
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-book"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-book"></i></span>
                                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>

                                            <button wire:click="addContent({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button"
                                                    @click="activeTab = 'content'">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Content</span>
                                                    @if(!empty($module['lessons'][$lessonIndex]['content']))
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-book-open"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-book-open"></i></span>
                                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>

                                            <button wire:click="addVideo({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button"
                                                    @click="activeTab = 'upload-video'">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Upload video</span>
                                                    @if(!empty($module['lessons'][$lessonIndex]['video_url']))
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-video"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-video"></i></span>
                                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>
                                        </div>

                                        @if(($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'quiz')
                                            <livewire:client.components.quiz-builder
                                                :$moduleIndex
                                                :$lessonIndex
                                                wire:model="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.assessments"
                                            />
                                        @endif

                                        @if(($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'assignment')
                                            <livewire:client.components.assignment-builder
                                                :$moduleIndex
                                                :$lessonIndex
                                                wire:model="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.assessments"
                                            />
                                        @endif

                                        @if(($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'content')
                                            <livewire:client.components.course-content-builder
                                                :$moduleIndex
                                                :$lessonIndex
                                                wire:model="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.content"
                                            />
                                        @endif

                                        @if(($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'upload-video')
                                            <livewire:client.components.course-video-builder
                                                :$moduleIndex
                                                :$lessonIndex
                                                wire:model="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}"
                                            />
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
