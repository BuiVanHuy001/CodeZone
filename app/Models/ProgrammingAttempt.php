<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgrammingAttempt extends Model
{
    protected $guarded = [];

    public function assessmentAttempt(): BelongsTo
    {
        return $this->belongsTo(AssessmentAttempt::class);
    }
}
