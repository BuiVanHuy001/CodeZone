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

    public function getAvatarPath(): string
    {
        return $this->avatar_url ?? asset('images/team/temp-avatar.webp');
    }

    public function slugSourceField(): string
    {
        return $this->name;
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    public function isBusiness(): bool
    {
        return $this->role === 'organization';
    }

    public function idEmployee(User $organization): bool
    {
        return OrganizationUsers::where('organization_id', $organization->id)->where('user_id', $this->id)->exists();
    }

    public function isEmployeeOfThisBusiness(User $user)
    {
        return OrganizationUsers::where('organization_id', $this->id)->where('user_id', $user->id)->exists();
    }
}
