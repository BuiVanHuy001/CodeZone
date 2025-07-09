<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentQuestion extends Model
{
	protected $guarded = [];

	public static array $TYPES = ["Multiple Choice" => 'multiple_choice', "True/False" => 'true_false', "File Upload" => 'file_upload'];

	public static array $QUIZ_TYPES = ["Multiple Choice" => 'multiple_choice', "True/False" => 'true_false',];

	public function options(): hasMany
	{
		return $this->hasMany(AssessmentQuestionOptions::class, 'assessment_question_id');
	}

}
