<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
	protected $guarded = [];

	public static array $TYPES = ['quiz' => 'Quiz', 'assignment' => 'Assignment',];
}
