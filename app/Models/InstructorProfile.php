<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorProfile extends Model
{
	protected $primaryKey = 'user_id';
	public $incrementing = false;
	protected $guarded = [];
	protected $casts = [
        'social_links' => 'array',
	];
}
