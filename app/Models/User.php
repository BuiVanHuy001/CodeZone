<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Database\Eloquent\Relations\MorphMany;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;

    class User extends Authenticatable
    {
        use HasApiTokens, HasFactory, Notifiable, softDeletes;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */

        public $incrementing = false;
        protected $keyType = 'string';
        protected $fillable = [
            'name',
            'email',
            'password',
            'role',
            'status',
            'slug',
            'avatar',
            'status',
            'role',
            'gender',
            'dob',
        ];

        /**
         * The attributes that should be hidden for serialization.
         *
         * @var array<int, string>
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * The attributes that should be cast.
         *
         * @var array<string, string>
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];

        public function student(): HasOne
        {
            return $this->hasOne(Student::class, 'user_id');
        }

        public function instructor(): HasOne
        {
            return $this->hasOne(Instructor::class, 'user_id');
        }

        public function admin(): HasOne
        {
            return $this->hasOne(Admin::class, 'user_id');
        }

        public function blogs(): HasMany
        {
            return $this->hasMany(Blog::class, 'user_id');
        }

        public function likes(): MorphMany
        {
            return $this->morphMany(Like::class, 'likeable');
        }

        public function dislikes(): MorphMany
        {
            return $this->morphMany(Dislike::class, 'dislikeable');
        }

        public function avatarPath(): string
        {
            $avatarPath = env('AVATAR_FOLDER_PATH') . $this->avatar;

            if (!is_null($this->avatar) && file_exists(public_path($avatarPath))) {
                return asset($avatarPath);
            }

            return asset('client_assets/images/avatar/default-avatar.png');
        }

        public function deleteAvatar(): void
        {
            if ($this->avatar) {
                $avatarPath = env('AVATAR_FOLDER_PATH') . $this->avatar;
                if (file_exists(public_path($avatarPath))) {
                    unlink(public_path($avatarPath));
                    $this->avatar = null;
                    $this->save();
                }
            }
        }

        public function isStudent(): bool
        {
            return $this->role === 'student';
        }

        public function isInstructor(): bool
        {
            return $this->role === 'instructor';
        }

        public function isAdmin(): bool
        {
            return $this->role === 'admin';
        }
    }
