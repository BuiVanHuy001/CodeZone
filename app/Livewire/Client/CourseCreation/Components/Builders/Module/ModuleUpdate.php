<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Module;

use App\Validator\ModulesBuilderValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModuleUpdate extends Component {
    #[Validate]
    public string $moduleTitle = '';
    public string|int $moduleIndex;

    public array $rules;
    public array $message;

    protected function rules(): array
    {
        return ModulesBuilderValidator::rules();
    }

    protected function messages(): array
    {
        return ModulesBuilderValidator::$MESSAGES;
    }

    #[On('edit-module')]
    public function receiveDataFormParent($index, $title): void
    {
        $this->moduleIndex = $index;
        $this->moduleTitle = $title;
    }

    public function update(): void
    {
        $this->validate($this->rules(), $this->messages());
        $this->dispatch('module-updated', index: $this->moduleIndex, title: $this->moduleTitle);
        $this->dispatch('close-modal', id: 'updateModule');
    }

    public function cancel(): void
    {
        $this->resetErrorBag();
        $this->dispatch('close-modal', id: 'updateModule');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.module.module-update');
    }
}
