<?php

namespace App\Livewire\Client\CourseCreation\Components\Inputs;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SelectInput extends Component
{
    public string $label = '';
    public string $name = '';
    public array|Collection $options;
    #[Modelable]
    public string $model = '';

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.inputs.select-input');
    }
}
