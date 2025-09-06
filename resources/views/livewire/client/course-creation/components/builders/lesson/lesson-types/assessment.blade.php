<div>
    <h6>{{ $title }}</h6>
    <div class="radio-inputs my-3" :key="'radio-'.$index">
        @foreach(\App\Models\Assessment::$ASSESSMENT_PRACTICE_TYPES as $key => $label)
            <label class="radio">
                <input wire:model.lazy="assessment.type" type="radio" name="{{ $unique }}.type" value="{{ $key }}">
                <span class="name">{{ $label }}</span>
            </label>
        @endforeach
    </div>
    @if(isset($assessment['type']))
        @if($assessment['type'] === 'quiz')
            <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment-types.quiz
                :unique="$unique"
                wire:model="assessment"
            />
        @elseif($assessment['type'] === 'assignment')
            <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment-types.assignment
                :unique="$unique"
                wire:model="assessment"
            />
        @elseif($assessment['type'] === 'programming')
            <livewire:client.course-creation.components.builders.lesson.lesson-types.assessment-types.programming
                :unique="$unique"
                wire:model="assessment"
            />
        @endif
    @endif
</div>
