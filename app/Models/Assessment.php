<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessment extends Model
{
	protected $guarded = [];

    public static array $ASSESSMENT_PRACTICE_TYPES = [
		'quiz' => 'Quiz',
        'programming' => 'Programming'
	];

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

	public function lesson(): BelongsTo
	{
		return $this->belongsTo(Lesson::class);
	}

    public function programmingAssigment(): hasOne
    {
        return $this->hasOne(ProgrammingProblems::class);
    }

    public function attempts(): hasMany
    {
        return $this->hasMany(AssessmentAttempt::class);
    }

	public function problemDetails(): hasOne
	{
        return $this->hasOne(ProgrammingProblems::class, 'assessment_id');
	}
}
