<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class PopupMobileMenu extends Component
{
    /**
     * Create a new components instance.
     */
    public function __construct(public Collection $categories)
    {
        //
    }

    /**
     * Get the view / contents that represent the components.
     */
    public function render(): View|Closure|string
    {
        return view('components.popup-mobile-menu');
    }
}
