<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Lesson extends Model
{
    use HasUUID, HasDuration;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $TYPES = [
        'video' => 'Video',
        'document' => 'Document',
        'assessment' => 'Assessment',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function course(): HasOneThrough|Lesson
    {
        return $this->hasOneThrough(
            Course::class,
            Module::class,
            'id',
            'id',
            'module_id',
            'course_id'
        );
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactionable');
    }

    public function trackingProgresses(): HasMany
    {
        return $this->hasMany(TrackingProgress::class);
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }

    public function getIcon(): string
    {
        if ($this->type === 'video' && $this->video_file_name !== '') {
            return 'video';
        }

        if ($this->type === 'assessment') {
            if ($this->assessment->type === 'quiz') {
                return 'help-circle';
            }

            return 'code';
        }

        return 'file-text';
    }
}
