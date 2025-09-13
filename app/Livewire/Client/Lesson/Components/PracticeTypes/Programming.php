<?php

namespace App\Livewire\Client\Lesson\Components\PracticeTypes;

use App\Models\Assessment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Programming extends Component {
    public array|Assessment $programmingPractice;
    public array $allowedLanguages;
    public string $languageSelected;
    public string $template;
    public array $codeTemplates;
    public string $userCode;

    public function mount(): void
    {
        $this->codeTemplates = json_decode($this->programmingPractice->problemDetails->code_templates, true);
        $this->allowedLanguages = array_keys($this->codeTemplates);
        $this->languageSelected = $this->allowedLanguages[0];
        $this->template = $this->codeTemplates[$this->languageSelected];
    }

    public function updatedLanguageSelected(): void
    {
        $this->template = $this->codeTemplates[$this->languageSelected];
        $this->dispatch('language-changed', doc: $this->template, language: $this->languageSelected);
    }

    public function cancel(): void
    {
        $this->dispatch('close-modal', id: 'programingPractice');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.lesson.components.practice-types.programming');
    }
}
