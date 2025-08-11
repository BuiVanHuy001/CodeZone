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

    public function __construct()
    {
        $this->categories = Category::fetchCategoriesWithChildren();

    }

    public function render(): View|Closure|string
    {
	    return view('components.client.header.index');
    }
}
