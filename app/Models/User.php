<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasSlug;

    protected $fillable = [
        'name',
        'email',
        'password',
        'slug',
        'user_id',
        'gender',
        'dob',
        'addition_data',
        'avatar'
    ];

    protected $hidden = ['password', 'remember_token',];

    public static array $ROLES = ['student', 'admin', 'instructor', 'super_admin', 'organization'];

    public static array $STATUSES = [
        'active' => [
            'label' => 'Active',
            'class' => 'bg-color-success-opacity color-success'
        ],
        'pending' => [
            'label' => 'Pending',
            'class' => 'bg-color-warning-opacity color-warning'
        ],
        'banned' => [
            'label' => 'Banned',
            'class' => 'bg-color-danger-opacity color-danger'
        ],
        'suspended' => [
            'label' => 'Suspended',
            'class' => 'bg-color-danger-opacity color-danger'
        ],
        'rejected' => [
            'label' => 'Rejected',
            'class' => 'bg-color-secondary-opacity color-secondary'
        ],
        'deleted' => [
            'label' => 'Deleted',
            'class' => 'bg-color-secondary-opacity color-secondary'
        ],
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organization_users', 'user_id', 'organization_id');
    }

    public function batchEnrollments(): hasMany
    {
        return $this->hasMany(BatchEnrollments::class);
    }

    public function progressTracking(): HasMany
    {
        return $this->hasMany(TrackingProgress::class);
    }

    public function enrollments(): User|HasMany
    {
        return $this->hasMany(Enrollment::class, 'user_id');
    }

    public function getStatusClassAttribute(): string
    {
        return self::$STATUSES[$this->status]['class'] ?? 'bg-color-secondary-opacity color-secondary';
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$STATUSES[$this->status]['label'] ?? 'Unknown';
    }

    public function calculateCourseProgress(Course $course): float|int
    {
        $totalLessons = $course->lesson_count;

        if ($totalLessons === 0) {
            return 0;
        }

        $completedLessons = $this
            ->progressTracking()
            ->whereHas('lesson', function ($query) use ($course) {
                $query->whereIn('module_id', $course->modules->pluck('id'));
            })
            ->where('is_completed', true)
            ->count();

        return round(($completedLessons / $totalLessons) * 100, 2);
    }

    public function organizationProfile(): HasOne
    {
        return $this->hasOne(OrganizationProfile::class, 'user_id');
    }

    public function instructorProfile(): HasOne
    {
        return $this->hasOne(InstructorProfile::class, 'user_id');
    }

    public function studentProfile(): HasOne|User
    {
        return $this->hasOne(StudentProfile::class, 'user_id');
    }

    public function getProfile(): HasOne
    {
        if ($this->isOrganization()) {
            return $this->organizationProfile();
        } elseif ($this->isStudent()) {
            return $this->studentProfile();
        } else {
            return $this->instructorProfile();
        }

    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    public function isOrganization(): bool
    {
        return $this->role === 'organization';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isMemberOfOrganization(string $userId, string $organizationId): bool
    {
        return OrganizationUser::where('organization_id', $organizationId)
            ->where('user_id', $userId)
            ->exists();
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
        $avatarFileName = $this->avatar;

        if (filter_var($avatarFileName, FILTER_VALIDATE_URL)) {
            return $avatarFileName;
        }

        if ($avatarFileName && Storage::disk('public')->exists('avatars/' . $avatarFileName)) {
            return asset('storage/avatars/' . $avatarFileName);
        }

        return asset('images/team/temp-avatar.webp');
    }

    public function getDashboardMenu(): array
    {
        return config("menus.$this->role", []);
    }

    public function getOrganizationOfUser(): string
    {
        $organizations = $this->relationLoaded('organizations')
            ? $this->organizations
            : $this->organizations()->select('users.id', 'users.name')->get();

        return $organizations
            ->pluck('name')
            ->filter()
            ->unique()
            ->implode(', ');
    }

    public function slugSourceField(): string
    {
        return $this->name;
    }

    public function scopeWithName($query, $name): Builder|QueryBuilder
    {
        return $query->where('name', 'like', "%$name%");
    }

    public function scopeWithEmail($query, $email): Builder|QueryBuilder
    {
        return $query->where('email', 'like', "%$email%");
    }

    public function reviews(): MorphMany
    {
        return $this->MorphMany('App\Models\Review', with('reviewable'));
    }
}
