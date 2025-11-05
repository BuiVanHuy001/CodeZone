<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use LaravelIdea\Helper\App\Models\_IH_Category_C;
use LaravelIdea\Helper\App\Models\_IH_Category_QB;

class Category extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(static function (self $category) {
            Cache::forget('categories_with_children');
        });

        static::deleted(static function (self $category) {
            Cache::forget('categories_with_children');
        });
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
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

    public static function fetchCategoriesWithChildren(): Collection
    {
        return Cache::rememberForever('categories_with_children', static function (): Collection {
            return self::whereNull('parent_id')
                ->with('children')
                ->orderBy('position')
                ->get();
        });
    }
}
