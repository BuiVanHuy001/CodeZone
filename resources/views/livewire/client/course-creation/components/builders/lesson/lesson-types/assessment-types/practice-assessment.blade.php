<div>
    <div class="course-field mb--20" x-data="{ showAssessment: false }">
        <h6>Practice Configuration</h6>
        @if(isset($practiceAssessments))
            @foreach($practiceAssessments as $index => $assessment)
                <div
                    @class([
                       'course-field mb--20 mt-3 position-relative border p-5 rounded',

                   ])
                    wire:key="practice-assessment-{{ $index }}"
                >
                    <div class="position-absolute" style="right: 10px; top: 10px; cursor: pointer;">
                        <div class="inner">

                            <button type="button"
                                    class="btn quiz-modal__edit-btn dropdown-toggle me-2"
                                    wire:click="removePracticeAssessment({{ $index }})"
                                    aria-expanded="false">
                                <i class="feather-trash"></i>
                            </button>
                        </div>
                    </div>

                    <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment
                        title="Bài luyện tập"
                        unique="practice-{{ $index }}"
                        wire:model="practiceAssessments.{{ $index }}"
                        wire:key="practice-assessment-child-{{ $index }}"
                    />
                </div>
            @endforeach
        @endif
    </div>

    <button class="rbt-btn btn-border hover-icon-reverse rbt-sm-btn-2"
            type="button"
            wire:click="addPracticeAssessment"
    >
    <span class="icon-reverse-wrapper">
        <span class="btn-text">Add Practice Assessment</span>
        <span class="btn-icon"><i class="feather-plus-square"></i></span>
        <span class="btn-icon"><i class="feather-plus-square"></i></span>
    </span>
    </button>
</div>
