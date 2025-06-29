<?php

namespace App\Livewire\Client\Instructor\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class CourseBuilder extends Component
{
    #[Modelable]
    public array $modules;
    public bool $showQuiz = false;
    public bool $showAssignment = false;
    public bool $showContent = false;
    public bool $showVideo = false;

    public function addQuiz(int $moduleIndex, int $lessonIndex): void
    {
        if (!isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'])) {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'] = ['title' => '', 'description' => '', 'assessments_questions' => [['content' => '', 'type' => '', 'question_options' => [['content' => '', 'is_correct' => false, 'explanation' => '', 'position' => 1,],],],],];
            $this->showQuiz = true;
        }
    }

    public function addAssignment(): void
    {
        $this->showAssignment = true;
    }

    public function addContent(): void
    {
        $this->showContent = true;
    }

    public function addVideo(): void
    {
        $this->showVideo = true;
    }

    public function addModule(): void
    {
        $this->modules[] = ['title' => 'Module ' . (count($this->modules) + 1), 'position' => count($this->modules) + 1, 'lessons' => [['title' => 'Lesson 1', 'position' => 1, 'description' => '', 'video_url' => '', 'content' => '',

        ],],];
    }

    public function removeModule(int $index): void
    {
        if (isset($this->modules[$index])) {
            unset($this->modules[$index]);
            $this->modules = array_values($this->modules);
        }
    }

    public function addLesson(int $moduleIndex): void
    {
        $this->modules[$moduleIndex]['lessons'][] = ['title' => 'Lesson ' . (count($this->modules[$moduleIndex]['lessons']) + 1), 'position' => count($this->modules[$moduleIndex]['lessons']) + 1, 'description' => '', 'video_url' => '', 'content' => '', 'preview' => false,];
    }

    public function removeLesson(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]);
            $this->modules[$moduleIndex]['lessons'] = array_values($this->modules[$moduleIndex]['lessons']);
        }
    }

    #[On('quiz-removed')]
    public function removeQuiz(int $moduleIndex, int $lessonIndex): void
    {
        $this->showQuiz = false;
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']);
        }
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.instructor.components.course-builder');
    }
}
