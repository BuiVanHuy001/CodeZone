<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson;

use App\Traits\HasErrors;
use App\Traits\WithLessonForm;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Attributes\On;

class LessonUpdate extends Component {
    use HasErrors, WithLessonForm;

    #[Validate]
    public array $lesson = [
        'title' => '',
        'type' => '',
        'content' => '',
        'preview' => false,
        'duration' => 0,
        'video_file_name' => '',
        'document' => '',
        'assessment' => [],
        'practice_assessments' => [],
    ];
    public string|int $moduleIndex;
    public string|int $lessonIndex;

    public function mount(): void
    {
        $this->mountLessonForm();
    }

    public function updated(): void
    {
        $this->validate();
    }

    #[On('edit-lesson')]
    public function receiveDataFormParent(array $lesson, string|int $moduleIndex, string|int $lessonIndex): void
    {
        $this->lesson = $lesson;
        $this->moduleIndex = $moduleIndex;
        $this->lessonIndex = $lessonIndex;
    }

    public function updateLesson(): void
    {
        $this->validate();
        $this->dispatch('lesson-updated',
            lesson: $this->lesson,
            moduleIndex: $this->moduleIndex,
            lessonIndex: $this->lessonIndex,
        );
    }

    public function cancel(): void
    {
        $this->resetErrorBag();
        $this->dispatch('close-modal', id: 'updateLesson');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-update');
    }
}
