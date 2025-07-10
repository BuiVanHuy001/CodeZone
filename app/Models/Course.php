<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
	use HasFactory, HasSlug, HasUUID, HasDuration;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $STATUSES = ['draft', 'published', 'pending', 'rejected', 'deleted'];

    public static array $LEVELS = ['beginner', 'intermediate', 'advanced'];

    public function modules(): hasMany
    {
        return $this->hasMany(Module::class);
    }

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }

    public function getThumbnailPath(): string
    {
        if ($this->thumbnail_url) {
            return asset($this->thumbnail_url);
        }
        return asset('images/course/default-thumbnail.webp');
    }

}
