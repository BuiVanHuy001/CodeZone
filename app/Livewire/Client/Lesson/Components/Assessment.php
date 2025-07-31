<?php

namespace App\Livewire\Client\Lesson\Components;

use App\Models\AssessmentAttempt;
use App\Models\AssessmentQuestion;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Assessment extends Component {
    public \App\Models\Assessment $assessment;
    public array $allowedProgrammingLanguages = [];
    public array $correctAnswers = [];
    public $answers = [];
    public $results = [];

    public function mount(): void
    {
        $this->correctAnswers = $this->assessment->questions->mapWithKeys(function ($question) {
            $correctOptionIds = $question->options
                ->where('is_correct', true)->pluck('id')->mapWithKeys(fn($id) => [$id => true])->toArray();
            return [$question->id => $correctOptionIds];
        })->toArray();
        if ($this->assessment->type === 'programming') {
            $problemDetailsArray = json_decode($this->assessment->programmingAssigment->problem_details, true);
            $this->allowedProgrammingLanguages = array_keys($problemDetailsArray['allowedLanguages']);
            $this->dispatch('assignment-programming-ready');
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment');
    }
}
