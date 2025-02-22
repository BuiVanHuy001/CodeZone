<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Builder;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function scopeSubCategories($query)
    {
        return $query->where('parent_id', $this->id);
    }

    public function scopeParentCategories($query)
    {
        return $query->whereNull('parent_id');
    }
}
