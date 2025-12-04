<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class InstructorProfile extends Model {
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $guarded = [];
    protected $casts = [
        'social_links' => 'array',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_REJECTED = 'rejected';

    public static array $SPECIFIC_STATUSES = [
        self::STATUS_PENDING => 'Chờ duyệt hồ sơ',
        self::STATUS_REJECTED => 'Từ chối hồ sơ',
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function faculty(): HasOneThrough
    {
        return $this->hasOneThrough(
            Faculty::class,
            Major::class,
            'id',
            'id',
            'major_id',
            'faculty_id'
        );
    }
}
