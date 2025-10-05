<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
	protected $primaryKey = 'assessment_attempt_id';
	public $incrementing = false;

    public $guarded = [];

	protected $casts = [
		'user_answers' => 'array',
	];

    public function assessmentAttempt(): BelongsTo
    {
        return $this->belongsTo(AssessmentAttempt::class);
    }
}
