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
    public array $activeTabs = [];


    public function addQuiz(int $moduleIndex, int $lessonIndex): void
    {
        if ($this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] !== 'assessment' || $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['type'] !== 'quiz') {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'assessment';
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'] = ['title' => '', 'description' => '', 'assessments_questions' => [['content' => '', 'type' => '', 'question_options' => [['content' => '', 'is_correct' => false, 'explanation' => '', 'position' => 1,],],],],];
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['type'] = 'quiz';
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'quiz';
    }

	#[On('quiz-removed')]
	public function removeQuiz(int $moduleIndex, int $lessonIndex): void
	{
		if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'])) {
			unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']);
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'video';
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    #[On('quiz-saved')]
    public function saveQuiz(int $moduleIndex, int $lessonIndex): void
    {
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    public function addAssignment(int $moduleIndex, int $lessonIndex): void
    {
        if ($this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] !== 'assessment' || $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['type'] !== 'assignment') {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'assessment';
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'] = ['title' => '', 'description' => '', 'assessments_questions' => [['content' => '', 'type' => 'file_upload', 'position' => 1,],],];
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['type'] = 'file_upload';
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'assignment';
    }

    #[On('assignment-removed')]
    public function removeAssignment(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']);
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'video';
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    #[On('assignment-saved')]
    public function saveAssignment(int $moduleIndex, int $lessonIndex): void
    {
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    public function addContent(int $moduleIndex, int $lessonIndex): void
    {
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'content';
    }

    #[On('content-saved')]
    public function saveContent(int $moduleIndex, int $lessonIndex): void
    {
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    #[On('content-removed')]
    public function removeContent(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['content'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['content']);
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    public function addVideo(int $moduleIndex, int $lessonIndex): void
    {
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'upload-video';
    }

    #[On('video-saved')]
    public function saveVideo(int $moduleIndex, int $lessonIndex, int $videoDuration): void
    {
        if ($this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration'] === 0 && $this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration'] !== $videoDuration) {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration'] = $videoDuration;
        }

        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    #[On('video-deleted')]
    public function deleteVideo(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['video_url'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['video_url']);
        }
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration']);
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    public function addModule(): void
    {
        $this->modules[] = ['title' => 'Module ' . (count($this->modules) + 1), 'position' => count($this->modules) + 1, 'lessons' => [['title' => 'Lesson 1', 'position' => 1, 'description' => '', 'video_url' => '', 'content' => '', 'preview' => false, 'type' => 'video', 'duration' => 0,],],];
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
        $this->modules[$moduleIndex]['lessons'][] = ['title' => 'Lesson ' . (count($this->modules[$moduleIndex]['lessons']) + 1), 'position' => count($this->modules[$moduleIndex]['lessons']) + 1, 'description' => '', 'video_url' => '', 'content' => '', 'preview' => false, 'duration' => 0, 'type' => 'video',];
    }

    public function removeLesson(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]);
            $this->modules[$moduleIndex]['lessons'] = array_values($this->modules[$moduleIndex]['lessons']);
        }
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.instructor.components.course-builder');
    }
}
