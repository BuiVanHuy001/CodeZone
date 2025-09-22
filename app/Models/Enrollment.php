<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Enrollment extends Model {
    protected $guarded = [];

    public static array $STATUSES = [
        'not_started' => 'Not Started',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
