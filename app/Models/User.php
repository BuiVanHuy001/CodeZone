<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\View\Components\banner;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasSlug;

    protected $fillable = ['name', 'email', 'password', 'slug', 'avatar_url'];

    protected $hidden = ['password', 'remember_token',];

    public static array $ROLES = ['student', 'admin', 'instructor', 'super_admin', 'organization'];

    public static array $STATUSES = ['active', 'pending', 'banned', 'suspended', 'rejected', 'deleted'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function batchEnrollments(): hasMany
    {
        return $this->hasMany(BatchEnrollments::class, 'user_id');
    }

    /**
     * Get all courses that user enrolled include business and normal courses.
     *
     * @return HasMany
     */
    public function getAllEnrollmentCourse()
    {
        //
    }

    /**
     * Get all courses that user enrolled normal courses.
     *
     * @return HasMany
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    public function isBusiness(): bool
    {
        return $this->role === 'organization';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function idEmployee(User $organization): bool
    {
        return OrganizationUsers::where('organization_id', $organization->id)->where('user_id', $this->id)->exists();
    }

    public function isEmployeeOfThisBusiness(User $user)
    {
        return OrganizationUsers::where('organization_id', $this->id)->where('user_id', $user->id)->exists();
    }

    public function isEnrolledThisCourse(Course $course): bool
    {
        $isReviewable = false;
        foreach ($this->batchEnrollments as $enrollment) {
            if ($enrollment->batch->course_id === $course->id) {
                $isReviewable = $enrollment->batch->course->where('id', $course->id)->exists();
                break;
            }
        }
        return $isReviewable;
    }

    public function getAvatarPath(): string
    {
        return $this->avatar_url ?? asset('images/team/temp-avatar.webp');
    }

    public function slugSourceField(): string
    {
        return $this->name;
    }

    public function getRole(): string
    {
        return $this->role;
    }
    public function reviews(): hasMany
    {
        return $this->hasMany(Review::class, with("user_id"));
    }
}
