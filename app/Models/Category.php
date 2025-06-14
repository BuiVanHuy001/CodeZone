<?php

namespace App\Models;

use App\Models\database\factories\CategoriesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<CategoriesFactory> */
    use HasFactory;

    public function scopeGetParents($query)
    {
        return $query->whereNull('parent_id')->get();
    }

    public function scopeGetChildren($query, $parentId)
    {
        return $query->where('parent_id', $parentId)->get();
    }
}
