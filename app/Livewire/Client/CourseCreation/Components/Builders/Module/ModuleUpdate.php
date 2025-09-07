<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Module;

use App\Validator\ModulesBuilderValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ModuleUpdate extends Component {
    #[Modelable]
    #[Validate]
    public string $moduleTitle;

    public array $rules;
    public array $messages;

    public function mount(): void
    {
        $this->rules = ModulesBuilderValidator::rules();
        $this->messages = ModulesBuilderValidator::$MESSAGES;
    }

    public function update(): void
    {
        $this->validate();
        $this->dispatch('close-modal', id: 'updateModule');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.module.module-update');
    }
}
