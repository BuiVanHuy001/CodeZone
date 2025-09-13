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
    public array|Assessment $currentPracticeExercise;

    public function mount(): void
    {
        $this->currentPracticeExercise = $this->practiceExercises[0];
    }

    public function showPracticeModel(): void
    {
        $this->dispatch('open-modal', id: 'practiceExercisesModal');
    }

    public function hidePracticeModel(): void
    {
        $this->dispatch('close-modal', id: 'practiceExercisesModal');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.lesson.components.practice-types.index');
    }
}
