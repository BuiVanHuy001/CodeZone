<?php

namespace App\View\Components\Admin\SharedUi;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CounterCard extends Component {
    public function __construct(
        public string           $title,
        public string|int|float $count,
        public string           $icon,
        public string           $color = 'text-muted',
        public bool             $border = true,
    )
    {
        $this->count = (string)$count;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.shared-ui.counter-card');
    }
}
