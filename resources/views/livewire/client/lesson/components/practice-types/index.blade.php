<div>
    <ol class="list-group list-group-numbered content">
        @foreach($practiceExercises as $assessment)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto cursor-pointer" wire:click="showPracticeModel">
                    <div class="fw-bold">{{ $assessment->title }}</div>
                </div>
                <span class="badge bg-danger text-bg-primary rounded-pill">Pass</span>
            </li>
        @endforeach
    </ol>
    <div wire:ignore.self class="rbt-default-modal modal fade"
         style="padding: 0 !important;"
         id="practiceExercisesModal" tabindex="-1"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="hidePracticeModel" type="button" class="rbt-round-btn">
                        <i class="feather-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="inner rbt-default-form">
                        @if($currentPracticeExercise === 'quiz')
                            <livewire:client.lesson.components.assessment-types.quiz :quiz="$currentPracticeExercise"/>
                        @elseif($currentPracticeExercise === 'assignment')
                            <livewire:client.lesson.components.assessment-types.assignment :assignment="$currentPracticeExercise"/>
                        @else
                            <livewire:client.lesson.components.practice-types.programming :programmingPractice="$currentPracticeExercise"/>
                        @endif
                    </div>
                </div>
                <div class="top-circle-shape"></div>
                <div class="modal-footer pt--30 justify-content-between">
                </div>
            </div>
        </div>
    </div>
</div>
