<?php

namespace App\View\Components\Client\Dashboard\Inputs;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Text extends Component {
    public function __construct(
        public string $model,
        public string $name,
        public string $label = '',
        public string $placeholder = '',
        public string $type = 'text',
        public bool   $isError = false,
        public string $info = '',
        public string $slug = '',
    ) {}

    public function render(): View|string
    {
        return view('components.client.dashboard.inputs.text');
    }
}
