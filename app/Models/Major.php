<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Major extends Model {
    use HasSlug;

    protected $fillable = ['name', 'slug',
        'code',
        'faculty_id'
    ];

    public function instructorProfiles()
    {
        return $this->hasMany(InstructorProfile::class);
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function studentProfiles(): HasMany
    {
        return $this->hasMany(StudentProfile::class, 'major_id');
    }

    public function classRooms(): hasMany
    {
        return $this->hasMany(ClassRoom::class);
    }

    public function slugSourceField(): string
    {
        return $this->name;
    }
}
