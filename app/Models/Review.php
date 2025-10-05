<?php

namespace App\Models;

use App\Traits\HasNumberFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasNumberFormat;

    protected $fillable = [
        'user_id',
        'reviewable_type',
        'reviewable_id',
        'rating',
        'content',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCourse($query)
    {
        return $query->where('reviewable_type', Course::class);
    }

    public function scopeInstructor($query)
    {
        return $query->where('reviewable_type', User::class);
    }

    public function getFormattedCount(int $count, string $type = 'short'): string
    {
        return $type === 'short' ? $this->formatShort($count) : $this->formatNumber($count);
    }
}
