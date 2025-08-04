<?php

namespace App\Livewire\Client\CourseCreation\Components\Inputs;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class TextareaInput extends Component
{
    public string $label = '';
    public string $name = '';
    public string $placeholder = '';
    #[Modelable]
    public string $model;
    public string $rows = '5';

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.inputs.textarea-input');
    }
}
