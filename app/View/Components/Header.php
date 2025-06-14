<?php

namespace App\View\Components;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Header extends Component
{
     public Collection $categories;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = $this->fetchCategoriesWithChildren();
    }

    public function fetchCategoriesWithChildren(): Collection
    {
        $categories = Category::getParents();
        foreach ($categories as $category) {
            $category->children = Category::getChildren($category->id);
        }
        return $categories;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header');
    }
}
