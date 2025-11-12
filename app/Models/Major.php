<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Major extends Model {
    use HasSlug;

    protected $fillable = ['name', 'slug'];

    public function instructors()
    {
        return $this->hasMany(InstructorProfile::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
}
