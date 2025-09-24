<div>
    <h6>Assessment</h6>
    <div class="radio-inputs my-3" :key="'radio-'.$index">
        @foreach(\App\Models\Assessment::$ASSESSMENT_PRACTICE_TYPES as $key => $label)
            <label class="radio">
                <input wire:model.lazy="assessment.type" type="radio" name="assessment.type" value="{{ $key }}">
                <span class="name">{{ $label }}</span>
            </label>
        @endforeach
    </div>
    @if(isset($assessment['type']))
        @if($assessment['type'] === 'quiz')
            <livewire:client.course-creation.components.builders.assessment.quiz
                wire:model="assessment"
            />
        @elseif($assessment['type'] === 'programming')
            <livewire:client.course-creation.components.builders.assessment.programming
                wire:model="assessment"
            />
        @endif
    @endif
</div>
