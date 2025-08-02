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
	    $role = auth()->user()->role;
	    return match ($role) {
		    'student' => view('components.header.student-menu'),
		    'instructor' => view('components.header.instructor-menu'),
		    default => view('components.header.business-menu'),
	    };
    }
}
