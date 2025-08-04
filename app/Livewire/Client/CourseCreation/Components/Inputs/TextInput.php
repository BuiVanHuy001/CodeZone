<?php

namespace App\Livewire\Client\CourseCreation\Components\Inputs;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class TextInput extends Component
{
    public string $label = '';
    public string $name = '';
    #[Modelable]
    public string $model = '';
    public string $placeholder = '';
    public string $type = 'text';

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.inputs.text-input');
    }
}
