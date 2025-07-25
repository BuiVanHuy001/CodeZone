<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptAnswer extends Model {
    public $guarded = [];

    public function assessmentAttempt(): BelongsTo
    {
        return $this->belongsTo(AssessmentAttempt::class);
    }
}
