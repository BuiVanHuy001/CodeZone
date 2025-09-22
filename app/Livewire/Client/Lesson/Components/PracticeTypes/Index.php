<?php

namespace App\Livewire\Client\Lesson\Components\PracticeTypes;

use App\Models\Assessment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Index extends Component {
    public array|Collection $practiceExercises;
    public array|Assessment|null $currentPracticeExercise;

    public function showPracticeModel(Assessment $assessment): void
    {
        $this->currentPracticeExercise = $assessment;
        $this->dispatch('open-modal', id: 'practiceExercisesModal');
    }

    public function hidePracticeModel(): void
    {
        $this->currentPracticeExercise = null;
        $this->dispatch('close-modal', id: 'practiceExercisesModal');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.lesson.components.practice-types.index');
    }
}
