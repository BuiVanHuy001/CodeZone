<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Faculty extends Model {
    use HasSlug;

    protected $fillable = ['name', 'slug', 'code'];

    public function majors(): hasMany
    {
        return $this->hasMany(Major::class);
    }

    public function instructors(): HasManyThrough
    {
        return $this->hasManyThrough(
            InstructorProfile::class, Major::class);
    }
}
