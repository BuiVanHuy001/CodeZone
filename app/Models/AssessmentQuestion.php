<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentQuestion extends Model
{
	protected $guarded = [];

	public static array $TYPES = ['multiple_choice' => 'Multiple Choice', 'true_false' => 'True/False',];

	public function options(): hasMany
	{
		return $this->hasMany(AssessmentQuestionOptions::class, 'assessment_question_id');
	}

}
