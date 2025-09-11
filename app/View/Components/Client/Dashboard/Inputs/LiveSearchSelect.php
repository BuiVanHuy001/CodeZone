<?php

namespace App\View\Components\Client\Dashboard\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class LiveSearchSelect extends Component {
    public function __construct(
        public string           $label,
        public string           $title,
        public string           $model,
        public string           $name,
        public array|Collection $options,
        public string           $info,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.inputs.live-search-select');
    }
}
