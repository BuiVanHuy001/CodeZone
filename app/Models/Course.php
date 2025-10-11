<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasNumberFormat;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory, HasSlug, HasUUID, HasDuration, HasNumberFormat;

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

    public function batches(): hasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function enrollments(): hasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }

    public function getThumbnailPath(): string
    {
        if ($this->thumbnail) {
            if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
                return $this->thumbnail;
            }
            return Storage::url('course/thumbnails/' . $this->thumbnail);
        }
        return asset('images/others/thumbnail-placeholder.svg');
    }

    public function getFormattedPrice(): string
    {
        if ($this->price === 0) {
            return 'Free';
        }

        return $this->formatCurrency($this->price);
    }
}
