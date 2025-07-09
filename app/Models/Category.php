<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

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

	public function children()
	{
		return $this->hasMany(Category::class, 'parent_id');
	}
}
