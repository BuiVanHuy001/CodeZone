<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentQuestionOptions extends Model
{
	protected $guarded = [];

	public function assessmentQuestion(): BelongsTo
	{
		return $this->belongsTo(AssessmentQuestion::class, 'assessment_question_id');
	}
}
