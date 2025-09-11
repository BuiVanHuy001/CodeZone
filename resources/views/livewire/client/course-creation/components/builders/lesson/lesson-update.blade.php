<div wire:ignore.self class="rbt-default-modal modal fade" id="updateLesson" tabindex="-1" aria-labelledby="LessonLabel"
     data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div @class([
            'modal-content',
            'border border-danger' => $errors->has('lesson.*'),
        ])>
            <div class="modal-header">
                <button type="button"
                        class="rbt-round-btn"
                        wire:click="cancel"
                        aria-label="Close">
                    <i class="feather-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="inner rbt-default-form">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="modal-title mb--20" id="LessonLabel">Update Lesson</h5>
                            <x-client.dashboard.inputs.text
                                model="lesson.title"
                                name="lesson.title"
                                label="Lesson Title"
                                placeholder="Enter lesson title"
                                info="Enter a descriptive lesson title (visible publicly to students)."/>

                            <x-client.dashboard.inputs.select
                                model="lesson.type"
                                name="lesson.type"
                                label="Lesson Type"
                                placeholder="Select lesson type"
                                :options="\App\Models\Lesson::$TYPES"
                                :isBoostrapSelect="false"
                                info="Select the module this lesson belongs to."/>

                            @if (!empty($lesson['type']))
                                <div @class([
                                    'course-field mb--20 mt-3 border p-5 rounded',
                                    'border-danger' => $errors->has([
                                        'lesson.assessment',
                                        'lesson.document',
                                        'lesson.video',
                                    ]),
                                ])>
                                    @switch($lesson['type'])
                                        @case('video')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.video
                                                :storedVideoRelPath="$lesson['video_file_name']"
                                            />
                                            @break

                                        @case('document')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.document
                                                wire:model="lesson.document"/>
                                            @break

                                        @case('assessment')
                                            <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment
                                                wire:model="lesson.assessment"/>
                                            @break
                                    @endswitch
                                </div>
                            @endif

                            @if ($lesson['type'] && $lesson['type'] !== 'assessment')
                                <div class="course-field mb--20">
                                    <h6 class="rbt-checkbox-wrapper mb--5 d-flex">
                                        <input wire:model.lazy="lesson.preview" id="rbt-checkbox-11"
                                               name="rbt-checkbox-11" type="checkbox" value="yes">
                                        <label for="rbt-checkbox-11">Enable Lesson Preview</label>
                                    </h6>
                                    <small><i class="feather-info"></i> Allow students to preview this lesson content
                                        before enrollment to help them make informed decisions about the course.</small>
                                </div>
                                @if (!$lesson['preview'])
                                    <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment-types.practice-assessment
                                        wire:model="lesson.practice_assessments"/>
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
                    <button type="button" class="rbt-btn btn-md" wire:click="updateLesson">Update Lesson</button>
                </div>
            </div>
        </div>
    </div>
</div>
