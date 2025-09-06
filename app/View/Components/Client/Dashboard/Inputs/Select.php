<?php

namespace App\View\Components\Client\Dashboard\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component {
    public function __construct(
        public string           $name,
        public string           $label,
        public string           $placeholder,
        public array|Collection $options,
        public string $info,
        public bool             $isError = false,
        public string $model = '',
        public bool   $isBoostrapSelect = true,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.inputs.select');
    }
}
