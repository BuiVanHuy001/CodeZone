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

    public static array $ROLES = ['student', 'admin', 'instructor', 'super_admin'];

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
        if ($this->isStudent()) {
            return $this->studentProfile();
        }

        return $this->instructorProfile();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
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

    public function slugSourceField(): string
    {
        return $this->name;
    }

    public function reviews(): MorphMany
    {
        return $this->MorphMany('App\Models\Review', with('reviewable'));
    }
}
