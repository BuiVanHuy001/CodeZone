<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Module;

use App\Validator\ModulesBuilderValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModuleCreate extends Component {
    #[Validate]
    public string $moduleTitle;

    public array $rules;
    public array $message;

    public function mount(): void
    {
        $this->rules = ModulesBuilderValidator::rules();
        $this->message = ModulesBuilderValidator::$MESSAGES;
    }

    public function save(): void
    {
        $this->validate();
        $this->dispatch('module-created', title: $this->moduleTitle);
        $this->dispatch('close-modal', id: 'addModule');
        $this->reset('moduleTitle');
    }

    public function cancel(): void
    {
        $this->reset('moduleTitle');
        $this->resetErrorBag();
        $this->dispatch('close-modal', id: 'addModule');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.module.module-create');
    }
}
