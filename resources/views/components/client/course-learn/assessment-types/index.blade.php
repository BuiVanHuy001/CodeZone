@if ($assessment->type === 'quiz')
    <livewire:client.lesson.components.assessment-types.quiz :quiz="$assessment"/>
@elseif($assessment->type === 'assignment')
    <livewire:client.lesson.components.assessment-types.assignment :assignment="$assessment"/>
@elseif($assessment->type === 'programming')
    <livewire:client.lesson.components.assessment-types.programming :problem="$assessment"/>
@endif
