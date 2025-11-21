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

    public function studentProfiles(): HasManyThrough
    {
        return $this->hasManyThrough(
            StudentProfile::class,
            Major::class,
            'faculty_id',
            'major_id',
            'id',
            'id'
        );
    }

    public function instructorProfiles(): HasManyThrough
    {
        return $this->hasManyThrough(
            InstructorProfile::class,
            Major::class,
            'faculty_id',
            'major_id',
            'id',
            'id'
        );
    }
}
