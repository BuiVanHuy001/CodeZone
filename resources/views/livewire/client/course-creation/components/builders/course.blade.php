<div class="accordion-item card">
    <h2 class="accordion-header card-header" id="accBuilder">
        <button
            class="accordion-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#accCollapseBuilder"
            aria-expanded="true"
            aria-controls="accCollapseBuilder">
            Course Builder
        </button>
    </h2>
    <div id="accCollapseBuilder" class="accordion-collapse collapse" aria-labelledby="accBuilder" wire:ignore.self>
        <div class="accordion-body card-body">
            @foreach($modules as $moduleIndex => $module)
                <div class="accordion-item card mb--20">
                    <h2 class="accordion-header card-header rbt-course" id="accModules{{ $moduleIndex }}">
                        <button
                            wire:model="modules.{{$moduleIndex}}.title"
                            class="accordion-button collapsed"
                            type="button" data-bs-toggle="collapse"
                            data-bs-target="#accCollapseModules{{ $moduleIndex }}"
                            aria-expanded="false"
                            aria-controls="accCollapseModules{{ $moduleIndex }}">
                            <span wire:text="modules[{{ $moduleIndex }}]['title']"></span>
                        </button>
                        <span wire:click="editModule({{$moduleIndex}})"
                              class="rbt-course-icon rbt-course-edit"
                              data-bs-toggle="modal"
                              data-bs-target="#UpdateModule">
                        </span>
                        <span wire:click="removeModule({{$moduleIndex}})"
                              class="rbt-course-icon rbt-course-del">
                        </span>
                    </h2>
                    <div id="accCollapseModules{{ $moduleIndex }}" class="accordion-collapse collapse" aria-labelledby="accModules{{ $moduleIndex }}" wire:ignore.self>
                        <div class="accordion-body card-body" id="dnd1">
                            @forelse($module['lessons'] as $lessonIndex => $lesson)
                                <div class="d-flex justify-content-between rbt-course-wrape mb-4" role="button">
                                    <div class="col-10 inner d-flex align-items-center gap-2">
                                        <i class="feather-menu cursor-scroll"></i>
                                        <h6 class="rbt-title mb-0" wire:text="modules[{{ $moduleIndex }}]['lessons'][{{ $lessonIndex }}]['title']"></h6>
                                    </div>
                                    <div class="col-2 inner">
                                        <ul class="rbt-list-style-1 rbt-course-list d-flex gap-2">
                                            <li><i class="feather-trash"></i></li>
                                            <li><i class="feather-edit" data-bs-toggle="modal"
                                                   data-bs-target="#Lesson"></i></li>
                                            <li><i class="feather-upload"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="text-muted">No lessons added yet.</span>
                                </div>
                            @endforelse

                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="gap-3 d-flex flex-wrap">
                                    <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
                                            type="button" data-bs-toggle="modal"
                                            data-bs-target="#Lesson"><span
                                            class="icon-reverse-wrapper"><span
                                                class="btn-text">Lesson</span><span
                                                class="btn-icon"><i
                                                    class="feather-plus-square"></i></span><span
                                                class="btn-icon"><i
                                                    class="feather-plus-square"></i></span></span>
                                    </button>
                                    <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2" type="button" data-bs-toggle="modal" data-bs-target="#Assignment"><span
                                            class="icon-reverse-wrapper"><span
                                                class="btn-text">Assignments </span><span
                                                class="btn-icon"><i
                                                    class="feather-plus-square"></i></span><span
                                                class="btn-icon"><i
                                                    class="feather-plus-square"></i></span></span>
                                    </button>
                                </div>
                                <div class="mt-3 mt-md-0">
                                    <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"><span
                                            class="icon-reverse-wrapper"><span
                                                class="btn-text">Import Quiz </span><span
                                                class="btn-icon"><i
                                                    class="feather-download"></i></span><span
                                                class="btn-icon"><i
                                                    class="feather-download"></i></span></span>
                                    </button>
                                    <input type="file" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <button class="rbt-btn btn-md btn-gradient hover-icon-reverse" type="button" data-bs-toggle="modal" data-bs-target="#addModule">
                <span class="icon-reverse-wrapper">
                    <span class="btn-text">Add New Module</span>
                <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                <span class="btn-icon"><i class="feather-plus-circle"></i></span>
                </span>
            </button>
        </div>

    </div>
    <template x-teleport="body">
        <div wire:ignore.self class="rbt-default-modal modal fade" id="addModule" tabindex="-1" aria-labelledby="addModuleLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="feather-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="inner rbt-default-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="modal-title mb--20" id="addModuleLabel">Add Topic</h5>
                                    <div class="course-field mb--20">
                                        <label for="modal-field-1">Module Title</label>
                                        <input id="modal-field-1" type="text" wire:model.lazy="newModuleTitle">
                                        @error("newModuleTitle")
                                        <small class="text-danger d-block">
                                            <i class="feather-alert-triangle"></i> {{ $message }}
                                        </small>
                                        @enderror
                                        <small><i class="feather-info"></i> Enter a descriptive name for this module.
                                            E.g: "Introduction to Web Development" or "Advanced Data Analysis
                                            Techniques".</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top-circle-shape"></div>
                    <div class="modal-footer pt--30">
                        <button wire:click="addModule"
                                type="button" data-bs-dismiss="modal"
                                class="rbt-btn btn-border btn-md radius-round-10">
                            Add
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div wire:ignore.self class="rbt-default-modal modal fade" id="UpdateModule" tabindex="-1" aria-labelledby="UpdateModuleLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"
                                @class([
                                    'rbt-round-btn',
                                    'disabled' => $errors->has("modules.$moduleIndex.title")
                                ])
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            <i class="feather-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="inner rbt-default-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="modal-title mb--20" id="addModuleLabel">Update Module </h5>
                                    <div class="course-field mb--20">
                                        <label for="modal-field-1">Module Title</label>
                                        <input id="modal-field-1" type="text" wire:model.lazy="modules.{{ $selectedModule['index'] }}.title">
                                        @error("modules.$moduleIndex.title")
                                        <small class="text-danger d-block">
                                            <i class="feather-alert-triangle"></i> {{ $message }}
                                        </small>
                                        @enderror
                                        <small><i class="feather-info"></i> Enter a descriptive name for this module.
                                            E.g: "Introduction to Web Development" or "Advanced Data Analysis
                                            Techniques".</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top-circle-shape"></div>
                    <div class="modal-footer pt--30">
                        <button type="button"
                                @class([
                                    'rbt-btn btn-border btn-md radius-round-10',
                                    'disabled' => $errors->has("modules.$moduleIndex.title")
                                ])data-bs-dismiss="modal">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div wire:ignore.self class="rbt-default-modal modal fade" id="Lesson" tabindex="-1" aria-labelledby="LessonLabel" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="feather-x"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="inner rbt-default-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="modal-title mb--20" id="LessonLabel">Add Lesson</h5>
                                    <pre>{{ json_encode($newLesson, JSON_PRETTY_PRINT) }}</pre>
                                    <x-client.dashboard.inputs.text
                                        model="newLesson.title"
                                        name="newLesson.title"
                                        label="Lesson Title"
                                        placeholder="Enter lesson title"
                                        :isError="$errors->has('newLesson.title')"
                                        info="Enter a descriptive lesson title (visible publicly to students)."
                                    />

                                    <x-client.dashboard.inputs.select
                                        wire:model.lazy="newLesson.type"
                                        name="newLesson.type"
                                        label="Lesson Type"
                                        placeholder="Select lesson type"
                                        :isError="$errors->has('newLesson.type')"
                                        :options="\App\Models\Lesson::$TYPES"
                                        info="Select the type of lesson you want to add."
                                    />

                                    @if($newLesson['type'] === 'video')
                                        <livewire:client.course-creation.components.builders.lesson-types.video/>
                                    @elseif($newLesson['type'] === 'document')
                                        <livewire:client.course-creation.components.builders.lesson-types.document wire:model.live="newLesson.document"/>
                                    @elseif($newLesson['type'] === 'assessment')
                                        <livewire:client.course-creation.components.builders.lesson-types.assessment wire:model.defer="newLesson.assessment"/>
                                    @endif

                                    @if($newLesson['type'] !== 'assessment')
                                        <div class="course-field mb--20">
                                            <h6 class="rbt-checkbox-wrapper mb--5 d-flex">
                                                <input wire:model.lazy="newLesson.preview" id="rbt-checkbox-11" name="rbt-checkbox-11" type="checkbox" value="yes">
                                                <label for="rbt-checkbox-11">Enable Lesson Preview</label>
                                            </h6>
                                            <small><i class="feather-info"></i> Allow students to preview this lesson
                                                content before enrollment to help them make informed decisions about the
                                                course.</small>
                                        </div>
                                    @endif

                                    {{--                                    @if(!$newLesson['preview'] && $newLesson['type'] !== 'assessment')--}}
                                    {{--                                        <div class="course-field mb--20" x-data="{ showAssessment: false }">--}}
                                    {{--                                            <h6>Practice Configuration</h6>--}}
                                    {{--                                            @if(isset($newLesson['assessments']))--}}
                                    {{--                                                @foreach($newLesson['assessments'] as $index => $assessment)--}}
                                    {{--                                                    <div wire:key="assessment-{{ $index }}">--}}
                                    {{--                                                        @if($assessment['type'] === 'quiz')--}}
                                    {{--                                                            <livewire:client.course-creation.components.builders.assessment-types.quiz--}}
                                    {{--                                                                wire:model="newLesson.assessments.{{ $index }}"--}}
                                    {{--                                                                :key="'quiz-'.$index"/>--}}
                                    {{--                                                        @elseif($assessment['type'] === 'assignment')--}}
                                    {{--                                                            <livewire:client.course-creation.components.builders.assessment-types.assignment--}}
                                    {{--                                                                wire:model="newLesson.assessments.{{ $index }}"--}}
                                    {{--                                                                :key="'assignment-'.$index"/>--}}
                                    {{--                                                        @elseif($assessment['type'] === 'programming')--}}
                                    {{--                                                            <livewire:client.course-creation.components.builders.assessment-types.programming--}}
                                    {{--                                                                wire:model="newLesson.assessments.{{ $index }}"--}}
                                    {{--                                                                :key="'programming-'.$index"/>--}}
                                    {{--                                                        @endif--}}
                                    {{--                                                        <div class="radio-inputs my-3" :key="'radio-'.$index">--}}
                                    {{--                                                            @foreach(\App\Models\Assessment::$ASSESSMENT_PRACTICE_TYPES as $key => $label)--}}
                                    {{--                                                                <label class="radio">--}}
                                    {{--                                                                    <input wire:model.lazy="newLesson.assessments.{{ $index }}.type" type="radio" name="assessment_type_{{ $index }}" value="{{ $key }}">--}}
                                    {{--                                                                    <span class="name">{{ $label }}</span>--}}
                                    {{--                                                                </label>--}}
                                    {{--                                                            @endforeach--}}
                                    {{--                                                        </div>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                @endforeach--}}
                                    {{--                                            @endif--}}
                                    {{--                                        </div>--}}

                                    {{--                                        <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"--}}
                                    {{--                                                type="button" data-bs-toggle="modal"--}}
                                    {{--                                                data-bs-target=""--}}
                                    {{--                                                wire:click="addAssessment">--}}
                                    {{--                                                <span class="icon-reverse-wrapper">--}}
                                    {{--                                                    <span class="btn-text">Add Practice Assessment</span>--}}
                                    {{--                                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>--}}
                                    {{--                                                    <span class="btn-icon"><i class="feather-plus-square"></i></span>--}}
                                    {{--                                                </span>--}}
                                    {{--                                        </button>--}}
                                    {{--                                    @else--}}
                                    {{--                                        <p>Practice features are disabled when lesson preview is enabled. Disable--}}
                                    {{--                                            preview mode to configure assessments for this lesson.</p>--}}
                                    {{--                                    @endif--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top-circle-shape"></div>
                    <div class="modal-footer pt--30 justify-content-between">
                        <button type="button"
                                class="rbt-btn btn-border btn-md radius-round-10"
                                data-bs-dismiss="modal"
                                wire:click="cancelNewLesson"
                        >Cancel
                        </button>
                        <div class="content">
                            <button type="button"
                                    class="rbt-btn btn-md"
                                    wire:click="addLesson"
                            >Add Lesson
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div wire:ignore.self class="rbt-default-modal modal fade" id="addAssessment" tabindex="-1" aria-labelledby="addAssessmentLabel" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button"
                                @class([
                                    'rbt-round-btn',
                                    'disabled' => $errors->has("modules.$moduleIndex.title")
                                ])
                                data-bs-dismiss="modal"
                                aria-label="Close">
                            <i class="feather-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="inner rbt-default-form">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="modal-title mb--20" id="addModuleLabel">Update Module </h5>
                                    <div class="course-field mb--20">
                                        <label for="modal-field-1">Module Title</label>
                                        <input id="modal-field-1" type="text" wire:model.lazy="modules.{{ $selectedModule['index'] }}.title">
                                        @error("modules.$moduleIndex.title")
                                        <small class="text-danger d-block">
                                            <i class="feather-alert-triangle"></i> {{ $message }}
                                        </small>
                                        @enderror
                                        <small><i class="feather-info"></i> Enter a descriptive name for this module.
                                            E.g: "Introduction to Web Development" or "Advanced Data Analysis
                                            Techniques".</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="top-circle-shape"></div>
                    <div class="modal-footer pt--30">
                        <button type="button"
                                @class([
                                    'rbt-btn btn-border btn-md radius-round-10',
                                    'disabled' => $errors->has("modules.$moduleIndex.title")
                                ])data-bs-dismiss="modal">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
