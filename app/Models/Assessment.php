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
        return $this->hasMany(AssessmentQuestion::class);
    }

	public function lesson(): BelongsTo
	{
		return $this->belongsTo(Lesson::class);
	}

    public function programmingAssigment(): hasOne
    {
        return $this->hasOne(ProgrammingAssignmentDetails::class);
    }

    public function attempts(): hasMany
    {
        return $this->hasMany(AssessmentAttempt::class);
    }

	public function problemDetails(): hasOne
	{
		return $this->hasOne(ProgrammingAssignmentDetails::class, 'assessment_id');
	}

    public function getUserAttempts($user): array
    {
        return $this->attempts()
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($attempt) {
                return [
                    'id' => $attempt->id,
                    'created_at' => $attempt->created_at,
                    'total_questions_count' => $attempt->attemptQuiz?->total_questions_count ?? 0,
                    'correct_answers_count' => $attempt->attemptQuiz?->correct_answers_count ?? 0,
                    'score' => $attempt->total_score,
                    'is_passed' => $attempt->is_passed,
                ];
            })
            ->toArray();
    }

}
