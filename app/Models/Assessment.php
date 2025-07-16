<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
	protected $guarded = [];

	public static array $TYPES = [
		'quiz' => 'Quiz',
		'assignment' => 'Assignment'
	];

    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class);
    }
}
