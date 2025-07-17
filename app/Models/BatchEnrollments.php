<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatchEnrollments extends Model
{
	protected $guarded = [];

    public static array $STATUSES = [
        'completed' => 'Completed',
        'in_progress' => 'In Progress',
        'not_started' => 'Not Started',
        'failed' => 'Failed'
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
