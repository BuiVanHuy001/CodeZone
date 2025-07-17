<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeGetParents($query)
    {
        return $query->whereNull('parent_id')->get();
    }

    public function scopeGetChildren($query, $parentId)
    {
        return $query->where('parent_id', $parentId)->get();
    }

	public function scopeParents()
	{
		return $this->where('parent_id', null)->get();
	}

    public static function fetchCategoriesWithChildren(): Collection
    {
        $categories = Category::getParents();
        foreach ($categories as $category) {
            $category->children = Category::with('children')->getChildren($category->id);
        }
        return $categories;
    }
}
