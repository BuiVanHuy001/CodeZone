<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Course extends Model
{
    use HasFactory, HasSlug, HasUUID, HasDuration;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $STATUSES = ['draft', 'published', 'pending', 'rejected'];

    public static array $LEVELS = ['beginner', 'intermediate', 'advanced'];

    protected $casts = [
        'requirements' => 'array',
        'skills' => 'array',
        'target_audiences' => 'array',
    ];

    public function modules(): hasMany
    {
        return $this->hasMany(Module::class);
    }

    public function lessons(): HasManyThrough|Course
    {
        return $this->hasManyThrough(
            Lesson::class,
            Module::class,
            'course_id',
            'module_id',
            'id',
            'id'
        );
    }

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }

    public function enrollments(): hasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function trackingProgresses(): HasManyThrough
    {
        return $this->hasManyThrough(TrackingProgress::class, Module::class);
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }
}
