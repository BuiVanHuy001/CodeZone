<?php

namespace App\View\Components\Client\Dashboard\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Livewire\Attributes\Modelable;

class TextArea extends Component {
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $label = '',
        public string $name = '',
        public string $placeholder = '',
        public string $rows = '5',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public
    function render(): View|Closure|string
    {
        return view('components.client.dashboard.inputs.text-area');
    }
}
