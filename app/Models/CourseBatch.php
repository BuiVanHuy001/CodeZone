<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseBatch extends Model {
    protected $guarded = [];

    public static array $STATUSES = [
        'upcoming' => 'Upcoming',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
