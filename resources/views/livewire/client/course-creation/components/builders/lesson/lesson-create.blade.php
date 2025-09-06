<div wire:ignore.self
     class="rbt-default-modal modal fade"
     id="addLessonModal" tabindex="-1" aria-labelledby="LessonLabel"
     data-bs-backdrop="static" x-data @lesson-added.window="$('#addLessonModal').modal('hide')">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div @class([
                            'modal-content',
                            'border border-danger' => $errors->has('newLesson.*')
                            ])>
            <div class="modal-header">
                <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="feather-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="inner rbt-default-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="modal-title mb--20" id="LessonLabel">Add Lesson</h5>
                            <x-client.dashboard.inputs.text
                                model="newLesson.title"
                                name="newLesson.title"
                                label="Lesson Title"
                                placeholder="Enter lesson title"
                                :isError="$errors->has('newLesson.title')"
                                info="Enter a descriptive lesson title (visible publicly to students)."
                            />

                            <x-client.dashboard.inputs.select
                                model="newLesson.type"
                                name="newLesson.type"
                                label="Lesson Type"
                                placeholder="Select lesson type"
                                :options="\App\Models\Lesson::$TYPES"
                                :isBoostrapSelect="false"
                                :isError="$errors->has('newLesson.type')"
                                info="Select the module this lesson belongs to."
                            />

                            @if(!empty($newLesson['type']))
                                <div @class([
                                           'course-field mb--20 mt-3 border p-5 rounded',
                                           'border-danger' => $errors->has(['lesson.assessment', 'lesson.document', 'lesson.video'])
                                       ])>
                                    @switch($newLesson['type'])
                                        @case('video')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.video/>
                                            @break
                                        @case('document')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.document
                                                wire:model="newLesson.document"
                                            />
                                            @break
                                        @case('assessment')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment
                                                wire:model="newLesson.assessment"
                                            />
                                            @break
                                    @endswitch
                                </div>
                            @endif

                            @if($newLesson['type'] && $newLesson['type'] !== 'assessment')
                                <div class="course-field mb--20">
                                    <h6 class="rbt-checkbox-wrapper mb--5 d-flex">
                                        <input wire:model.lazy="newLesson.preview" id="rbt-checkbox-11" name="rbt-checkbox-11" type="checkbox" value="yes">
                                        <label for="rbt-checkbox-11">Enable Lesson Preview</label>
                                    </h6>
                                    <small><i class="feather-info"></i> Allow students to preview this lesson content
                                        before enrollment to help them make informed decisions about the course.</small>
                                </div>
                                @if(!$newLesson['preview'])
                                    <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment-types.practice-assessment
                                        wire:model="newLesson.practice_assessments"/>
                                @else
                                    <p>Practice features are disabled when lesson preview is enabled. Disable preview
                                        mode to configure assessments for this lesson.</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-circle-shape"></div>
            <div class="modal-footer pt--30 justify-content-between">
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
