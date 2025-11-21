<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model {
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'gender',
        'dob',
        'addition_data',
        'user_id',
        'major_id',
        'class_room_id',
        'student_code',
        'enrollment_year',
        'student_type',
    ];

    protected $casts = [
        'addition_data' => 'array',
        'dob' => 'date:d-m-Y',
    ];

    public static array $STUDENT_TYPES = [
        'internal' => 'Internal',
        'external' => 'External',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
