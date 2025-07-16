<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchEnrollments extends Model
{
	protected $guarded = [];

    public static array $STATUSES = [
        'completed' => 'Completed',
        'in_progress' => 'In Progress',
        'not_started' => 'Not Started',
        'failed' => 'Failed'
    ];
}
