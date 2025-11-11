<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseBatch extends Model {
    protected $guarded = [];

    public static array $STATUSES = [
        'upcoming' => 'Upcoming',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
    ];

    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
