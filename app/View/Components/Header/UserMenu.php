<?php

namespace App\View\Components\Header;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserMenu extends Component {
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $role = auth()->user()->getRole();
        if ($role === 'student') {
            return view('components.header.student-menu');
        } elseif ($role === 'instructor') {
            return view('components.header.instructor-menu');
        }
        return view('components.header.business-menu');

    }
}
