<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model {
    protected $fillable = [
        'gender',
        'dob',
        'addition_data',
        'user_id',
    ];

    protected $casts = [
        'addition_data' => 'array',
        'dob' => 'date:d-m-Y',
    ];

    public static array $DEFAULT_COLUMNS = [
        'MAIL' => 'mail',
        'FULL NAME' => 'full_name',
        'DATE OF BIRTH' => 'date_of_birth',
        'GENDER' => 'gender',
        'AVATAR URL' => 'avatar_url',
        'PASSWORD' => 'password'
    ];
}
