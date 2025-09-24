@switch($assessment->type)
    @case('quiz')
        <livewire:client.lesson.components.assessment-types.quiz :quiz="$assessment"/>
        @break
    @case('programming')
        <livewire:client.lesson.components.assessment-types.programming :problem="$assessment"/>
        @break
@endswitch
