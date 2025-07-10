<?php

namespace App\Models;

use App\Traits\HasSlug;
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
}
