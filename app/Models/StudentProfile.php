<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model {
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    const STATUS_RESERVED = 'reserved';
    const STATUS_COMPLETED = 'completed';
    const STATUS_GRADUATED = 'graduated';
    const STATUS_DROPPED = 'dropped';
    const STATUS_PROBATION = 'probation';

    public static array $SPECIFIC_STATUSES = [
        self::STATUS_RESERVED => 'Bảo lưu',
        self::STATUS_GRADUATED => 'Tốt nghiệp',
        self::STATUS_DROPPED => 'Thôi học',
        self::STATUS_COMPLETED => 'Hoàn thành CT',
        self::STATUS_PROBATION => 'Cảnh báo học vụ',
    ];

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
        'enrollment_year' => 'date:Y',
    ];

    public static array $STUDENT_TYPES = [
        'internal' => 'Internal',
        'external' => 'External',
    ];

    public function canTransitionTo(string $newStatus): bool
    {
        if ($this->user->status === $newStatus) {
            return true;
        }

        $current = $this->user->status;

        $validTransitions = [
            User::STATUS_ACTIVE => [
                self::STATUS_PROBATION,
                self::STATUS_RESERVED,
                self::STATUS_DROPPED,
                self::STATUS_COMPLETED,
                User::STATUS_SUSPENDED,
            ],

            self::STATUS_PROBATION => [
                User::STATUS_ACTIVE,
                self::STATUS_DROPPED,
                User::STATUS_SUSPENDED,
            ],

            self::STATUS_RESERVED => [
                User::STATUS_ACTIVE,
                self::STATUS_DROPPED,
            ],

            self::STATUS_COMPLETED => [
                self::STATUS_GRADUATED,
            ],

            self::STATUS_GRADUATED => [],
            self::STATUS_DROPPED => [],

            User::STATUS_SUSPENDED => [
                User::STATUS_ACTIVE,
                self::STATUS_DROPPED,
            ]
        ];

        return in_array($newStatus, $validTransitions[$current] ?? []);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function classRoom(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'class_room_id');
    }

    public function faculty()
    {
        return $this->hasOneThrough(
            Faculty::class,
            Major::class,
            'id',
            'id',
            'major_id',
            'faculty_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function genderLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->gender === 1 ? 'Nữ' : 'Nam'
        );
    }

    protected function dobFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->dob ? $this->dob->format('d/m/Y') : 'N/A'
        );
    }

    protected function enrollmentYearFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->enrollment_year ? $this->enrollment_year->format('Y') : 'N/A'
        );
    }
}
