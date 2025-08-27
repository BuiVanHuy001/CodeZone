<?php

namespace App\View\Components\Client\Dashboard\Inputs;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MarkdownArea extends Component {
    public function __construct(
        public string $label = '',
        public string $id = '',
        public string $name = '',
        public string $placeholder = '',
        public string $info = '',
        public bool   $isError = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.inputs.markdown-area');
    }
}
