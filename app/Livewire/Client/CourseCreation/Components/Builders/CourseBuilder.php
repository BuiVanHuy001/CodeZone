<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class CourseBuilder extends Component {
    #[Modelable]
    public array $modules;

    public string|int $selectedModule;

    public function createModule(): void
    {
        $this->dispatch('open-modal', id: 'addModule');
    }

    public function editModule($index): void
    {
        $this->dispatch('open-modal', id: 'updateModule');
        $this->dispatch('edit-module', index: $index, title: $this->modules[$index]['title']);
    }

    #[On('module-created')]
    public function storeModule(string $title): void
    {
        $this->modules[] = [
            'title' => $title,
            'lesson_count' => 0,
            'lessons' => []
        ];
    }

    #[On('module-updated')]
    public function updateModuleTitle(string|int $index, string $title): void
    {
        if (isset($this->modules[$index])) {
            $this->modules[$index]['title'] = $title;
        }
    }

    public function destroyModule(string|int $index): void
    {
        if (count($this->modules) <= 1) {
            $this->dispatch('swal', [
                'title' => 'Minimum Modules Required',
                'text' => 'You must have at least one module in your course.',
                'icon' => 'warning',
            ]);
        } else {
            if (isset($this->modules[$index])) {
                unset($this->modules[$index]);
                $this->modules = array_values($this->modules);
                $this->dispatch('swal', [
                    'title' => 'Module Removed',
                    'text' => 'The module has been successfully removed.',
                    'icon' => 'success',
                ]);
            }
        }
    }

    public function createLesson(string|int $moduleIndex): void
    {
        $this->dispatch('open-modal', id: 'addLesson');
        $this->dispatch('create-lesson', moduleIndex: $moduleIndex);
    }

    public function editLesson(string|int $moduleIndex, string|int $lessonIndex): void
    {
        $this->dispatch('open-modal', id: 'updateLesson');

        $this->dispatch('edit-lesson',
            lesson: $this->modules[$moduleIndex]['lessons'][$lessonIndex],
            moduleIndex: $moduleIndex,
            lessonIndex: $lessonIndex
        );
    }

    #[On('lesson-updated')]
    public function updateLesson(array $lesson, string|int $moduleIndex, string|int $lessonIndex): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex] = $lesson;
        $this->dispatch('swal', [
            'title' => 'Lesson Updated',
            'text' => 'The lesson has been successfully updated.',
            'icon' => 'success',
        ]);
        $this->dispatch('close-modal', id: 'updateLesson');
    }

    #[On('lesson-added')]
    public function storeLesson(array $newLesson, string|int $moduleIndex): void
    {
        $this->modules[$moduleIndex]['lessons'][] = $newLesson;

        $this->dispatch('swal', [
            'title' => 'Lesson Added',
            'text' => 'The lesson has been successfully added.',
            'icon' => 'success',
        ]);
    }

    public function destroyLesson(string|int $moduleIndex, string|int $lessonIndex): void
    {
        if (count($this->modules[$moduleIndex]['lessons']) <= 1) {
            $this->dispatch('swal', [
                'title' => 'Minimum Lessons Required',
                'text' => 'You must have at least one lesson in your module.',
                'icon' => 'warning',
            ]);
        } else {
            if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex])) {
                if ($this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] === 'video') {
                    Storage::disk('public')->delete('course/videos/' . $this->modules[$moduleIndex]['lessons'][$lessonIndex]['video_file_name']);
                }

                unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]);

                $this->modules[$moduleIndex]['lessons'] = array_values($this->modules[$moduleIndex]['lessons']);
                $this->dispatch('swal', [
                    'title' => 'Lesson Removed',
                    'text' => 'The lesson has been successfully removed.',
                    'icon' => 'success',
                ]);
            }
        }
    }

    #[On('document-changed')]
    public function documentChange($document): void
    {
        $this->newLesson['document'] = $document;
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.course-builder');
    }
}
