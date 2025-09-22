<?php

namespace App\Livewire\Client\Lesson\Components\PracticeTypes;

use App\Models\Assessment;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use JsonException;
use Livewire\Component;

class Programming extends Component
{
    public array|Assessment $programmingPractice;
    public array $allowedLanguages;
    public string $languageSelected;
    public string $template;
    public array $codeTemplates = [];
    public string $userCode = '';

    /**
     * @throws JsonException
     */
    public function mount(): void
    {
        $codeTemplatesData = $this->programmingPractice->problemDetails->code_templates;

        if (is_string($codeTemplatesData)) {
            $this->codeTemplates = json_decode($codeTemplatesData, true, 512, JSON_THROW_ON_ERROR) ?? [];
        } else {
            $this->codeTemplates = $codeTemplatesData ?? [];
        }

        $this->allowedLanguages = array_keys($this->codeTemplates);
        $this->languageSelected = $this->allowedLanguages[0] ?? '';
        $this->template = $this->codeTemplates[$this->languageSelected] ?? '';
    }

    public function updatedLanguageSelected(): void
    {
        $this->template = $this->codeTemplates[$this->languageSelected] ?? '';
        $this->dispatch('language-changed', doc: $this->template, language: $this->languageSelected);
    }

    public function submitCode(): void
    {
        dd($this->userCode);
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
