<?php

namespace App\View\Components\Client\Dashboard\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component {
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string           $name,
        public string           $label,
        public string           $placeholder,
        public array|Collection $options,
        public string $info,
        public bool             $isError = false,
        public string $model = '',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.inputs.select');
    }
}
