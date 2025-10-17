<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use LaravelIdea\Helper\App\Models\_IH_Category_C;
use LaravelIdea\Helper\App\Models\_IH_Category_QB;

class Category extends Model
{
    use HasFactory;

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function scopeGetParents($query)
    {
        return $query->whereNull('parent_id')->get();
    }

    public function scopeGetChildren($query, $parentId)
    {
        return $query->where('parent_id', $parentId)->get();
    }

    public function scopeParents(): _IH_Category_C|array
    {
		return $this->where('parent_id', null)->get();
	}

    public static function fetchCategoriesWithChildren(): _IH_Category_QB|Collection
    {
        $categories = Category::getParents();
        foreach ($categories as $category) {
            $category->children = Category::with('children')->getChildren($category->id);
        }
        return $categories;
    }
}
