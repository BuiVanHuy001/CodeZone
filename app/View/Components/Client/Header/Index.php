<?php

namespace App\View\Components\Client\Header;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Collection;

class Index extends Component
{
	public Collection $categories;
	public string $menuView;

    public function __construct()
    {
        $this->categories = Category::fetchCategoriesWithChildren();

	    $role = auth()->user()?->role ?? 'guest';

	    $this->menuView = match ($role) {
		    'student' => 'components.client.header.menus.student',
		    'instructor' => 'components.client.header.menus.instructor',
		    default => 'components.client.header.menus.business',
	    };
    }

    public function render(): View|Closure|string
    {
	    return view('components.client.header.index');
    }
}
