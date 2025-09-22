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

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
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
            if ($this->type === 'quiz') {
                return 'help-circle';
            }

            if ($this->type === 'assignment') {
                return 'book-open';
            }

            return 'code';
        }

        return 'file-text';
    }
}
