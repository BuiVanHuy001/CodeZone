<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatchEnrollment extends Model {
    protected $guarded = [];

    public static array $STATUSES = [
        'not_started' => 'Not Started',
        'completed' => 'Completed',
        'in_progress' => 'In Progress',
        'dropped' => 'Dropped',
    ];

    public function courseBatch(): BelongsTo
    {
        return $this->belongsTo(CourseBatch::class);
    }
}
