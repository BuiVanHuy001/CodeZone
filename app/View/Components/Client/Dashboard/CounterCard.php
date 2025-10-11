<?php

namespace App\View\Components\Client\Dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CounterCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string $count,
        public string $icon,
        public string $bgClass = 'bg-primary-opacity',
        public string $textClass = 'color-primary'
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.dashboard.counter-card');
    }
}
