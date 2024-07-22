<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, softDeletes;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    private array $badgeColor = [
        'pending' => 'badge-warning',
        'active' => 'badge-success',
        'suspended' => 'badge-danger'
    ];
    private array $statusName = [
        'pending' => 'Chờ phê duyệt',
        'active' => 'Hoạt động',
        'suspended' => 'Khóa'
    ];
    public function getBadgeColor(): string
    {
        return $this->badgeColor[$this->user->status];
    }
    public function getStatusName(): string
    {
        return $this->statusName[$this->user->status];
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function courses(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
    public function checkStudentIsEnrolled(string $id): bool
    {
        return $this->courses->contains('course_id', $id);
    }
}
