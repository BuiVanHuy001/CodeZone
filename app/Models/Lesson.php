<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    use HasSlug, HasUUID, HasDuration;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $TYPES = ['video', 'document', 'assessment'];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function assessment(): HasOne
    {
        return $this->hasOne(Assessment::class);
    }

    public function trackingProgresses(): HasMany
    {
        return $this->hasMany(TrackingProgress::class);
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }

    public function getIcon()
    {
        if ($this->type === 'video' && $this->video_url !== '') {
            return 'video';
        } elseif ($this->type === 'assessment') {
            if ($this->assessment->type === 'quiz') {
                return 'help-circle';
            } elseif ($this->assessment->type === 'assignment') {
                return 'book-open';
            }
        } else {
            return 'file-text';
        }
    }
}
