<div>
    <ol class="list-group list-group-numbered content">
        @foreach($practiceExercises as $assessment)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto cursor-pointer" wire:click="showPracticeModel({{ $assessment }})">
                    <div class="fw-bold">{{ $assessment->title }}</div>
                </div>
                <span class="badge bg-danger text-bg-primary rounded-pill">Pass</span>
            </li>
        @endforeach
    </ol>
    <div class="rbt-default-modal modal fade"
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
                        @unless(is_null($currentPracticeExercise))
                            @switch($currentPracticeExercise->type)
                                @case('quiz')
                                    <livewire:client.lesson.components.assessment-types.quiz :quiz="$currentPracticeExercise"/>
                                    @break

                                @case('assignment')
                                    <livewire:client.lesson.components.assessment-types.assignment :assignment="$currentPracticeExercise"/>
                                    @break

                                @case('programming')
                                    <livewire:client.lesson.components.practice-types.programming :programmingPractice="$currentPracticeExercise"/>
                                    @break
                            @endswitch
                        @endunless
                    </div>
                </div>
                <div class="top-circle-shape"></div>
            </div>
        </div>
    </div>
</div>
