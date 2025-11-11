<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model {
    protected $primaryKey = 'user_id';
    public $incrementing = false;

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

    public static array $STUDENT_TYPES = [
        'internal' => 'Internal',
        'external' => 'External',
    ];
}
