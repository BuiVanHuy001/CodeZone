<div class="card">
    <h2 class="card-header">
        <button type="button" class="accordion-button">Course Builder</button>
    </h2>
    <div>
        <div class="card-body">
            @foreach ($modules as $moduleIndex => $module)
                <div class="accordion-item card mb--20 rbt-default-form" wire:key="module-{{ $moduleIndex }}">
                    <h6 class="card-header">
                        {{ empty($module['title']) || $module['title'] === 'Example Module' ? 'Module ' . $moduleIndex + 1 : $module['title'] }}
                        <span class="rbt-course-icon rbt-course-edit"></span>
                        <span class="rbt-course-icon rbt-course-del"></span>
                    </h6>
                    <div>
                        <div class="course-field card-body">
                            <label for="modules.{{ $moduleIndex }}">Module title</label>
                            <div class="d-flex justify-content-between rbt-course-wrape mb-4 flex-wrap">
                                <div class="col-10 inner d-flex align-items-center gap-2">
                                    <input wire:model.blur="modules.{{ $moduleIndex }}.title"
                                        id="modules.{{ $moduleIndex }}" class="rbt-title mb-0"
                                           placeholder="Enter module {{ $loop->iteration }} title"/>
                                </div>
                                <div class="col-2 inner">
                                    <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                        <li><i wire:click="removeModule({{ $moduleIndex }})" class="feather-trash"></i>
                                        </li>
                                        <li><i class="feather-edit"></i></li>
                                    </ul>
                                </div>
                            </div>
                            @error("parent.modules.$moduleIndex.title")
                            <div class="col-12">
                                <small class="text-danger">
                                    <i class="feather-info"></i>
                                    {{ $message }}
                                </small>
                            </div>
                            @enderror

                            <label>Module lessons</label>
                            @foreach ($module['lessons'] as $lessonIndex => $lesson)
                                <div class="d-flex justify-content-between flex-wrap rbt-course-wrape mb-4 ms-5" wire:key="lesson-{{ $moduleIndex }}-{{ $lessonIndex }}">
                                    <div class="col-10 inner d-flex align-items-center gap-2">
                                        <input class="rbt-title mb-0"
                                               wire:model.blur="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.title"
                                               id="modules.{{ $moduleIndex }}.lessons{{ $lessonIndex }}.title"
                                               name="modules.{{ $moduleIndex }}.lessons{{ $lessonIndex }}.title"
                                               placeholder="Enter lesson {{ $lessonIndex + 1 }} title"/>
                                    </div>
                                    <div class="col-2 inner">
                                        <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                            <li>
                                                <i wire:click="removeLesson({{ $moduleIndex }}, {{ $lessonIndex }})"
                                                   class="feather-trash"></i>
                                            </li>
                                            <li>
                                                <div class="rbt-checkbox">
                                                    <input type="checkbox"
                                                           id="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview"
                                                           name="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview"
                                                           wire:model="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview">
                                                    <label
                                                        for="modules.{{ $moduleIndex }}.lessons.{{ $lessonIndex }}.preview">Preview</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div
                                    @error("parent.modules.$moduleIndex.lessons.$lessonIndex.title")
                                    <div class="col-12">
                                        <small class="text-danger">
                                            <i class="feather-info"></i>
                                            {{ $message }}
                                        </small>
                                    </div>
                                    @enderror

                                    <div class="col-12 my-3 d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="gap-3 d-flex flex-wrap">
                                            <button wire:click="addQuiz({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Quiz</span>
                                                    @if (isset($module['lessons'][$lessonIndex]['assessments']) &&
                                                            $module['lessons'][$lessonIndex]['assessments']['type'] === 'quiz')
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="feather-help-circle"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i
                                                                class="feather-help-circle"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>

                                            <button wire:click="addAssignment({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Assignments</span>
                                                    @if (isset($module['lessons'][$lessonIndex]['assessments']) &&
                                                            $module['lessons'][$lessonIndex]['assessments']['type'] === 'assignment')
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-book"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-book"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>

                                            <button wire:click="addDocument({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Document</span>
                                                    @if (!empty($module['lessons'][$lessonIndex]['content']))
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-book-open"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-book-open"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>

                                            <button wire:click="addVideo({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Upload video</span>
                                                    @if (!empty($module['lessons'][$lessonIndex]['video_url']))
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-video"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-video"></i></span>
                                                        <span class="btn-icon"><i
                                                                class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>

                                            <button wire:click="addProgrammingPractice({{ $moduleIndex . ',' . $lessonIndex }})"
                                                    class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                                    type="button">
                                                <span class="icon-reverse-wrapper">
                                                    <span class="btn-text">Programming</span>
                                                    @if (!empty($module['lessons'][$lessonIndex]['video_url']))
                                                        <span class="btn-icon"><i class="feather-eye"></i></span>
                                                        <span class="btn-icon"><i class="feather-code"></i></span>
                                                    @else
                                                        <span class="btn-icon"><i class="feather-code"></i></span>
                                                        <span class="btn-icon"><i class="feather-plus-square"></i></span>
                                                    @endif
                                                </span>
                                            </button>
                                        </div>

                                        @if (($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'quiz')
                                            <livewire:client.course-creation.components.builders.quiz
                                                :$moduleIndex
                                                :$lessonIndex
                                                :quiz="$modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']"
                                                wire:key="quiz-{{ $moduleIndex }}-{{ $lessonIndex }}"
                                            />
                                        @endif

                                        @if (($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'assignment')
                                            <livewire:client.course-creation.components.builders.assignment
                                                :$moduleIndex
                                                :$lessonIndex
                                                :assignment="$modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']"
                                                wire:key="assignment-{{ $moduleIndex }}-{{ $lessonIndex }}"/>
                                        @endif

                                        @if (($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'document')
                                            <livewire:client.course-creation.components.builders.document
                                                :$moduleIndex
                                                :$lessonIndex
                                                :document="$modules[$moduleIndex]['lessons'][$lessonIndex]['content']"
                                                wire:key="document-{{ $moduleIndex }}-{{ $lessonIndex }}"
                                            />
                                        @endif

                                        @if (($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'upload-video')
                                            <livewire:client.course-creation.components.builders.video
                                                :$moduleIndex
                                                :$lessonIndex
                                                :videoURL="$modules[$moduleIndex]['lessons'][$lessonIndex]['video_url']"
                                                wire:key="video-{{ $moduleIndex }}-{{ $lessonIndex }}"/>
                                        @endif

                                        @if(($activeTabs["$moduleIndex-$lessonIndex"] ?? '') === 'programming-practice')
                                            <livewire:client.course-creation.components.builders.programming-practice
                                                :$moduleIndex
                                                :$lessonIndex
                                                :programmingPractice="$modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']"
                                                wire:key="programming-practice-{{ $moduleIndex }}-{{ $lessonIndex }}"
                                            />
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="button" wire:click="addLesson({{ $loop->index }})"
                                        class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2">
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
