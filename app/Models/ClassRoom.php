<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassRoom extends Model {
    use HasSlug;

    protected $guarded = [];

    public function studentProfiles(): hasMany
    {
        return $this->hasMany(StudentProfile::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function slugSourceField()
    {
        return $this->name;
    }
}
