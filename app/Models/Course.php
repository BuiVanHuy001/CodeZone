<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function batches(): hasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }

    public function getThumbnailPath(): string
    {
        if ($this->thumbnail_url) {
            return Storage::url('course/thumbnails/' . $this->thumbnail_url);
        }
        return asset('images/others/thumbnail-placeholder.svg');
    }

    public function getIntroductionVideo(): string
    {
        $introductionVideoUrl = '';
        foreach ($this->modules as $module) {
            foreach ($module->lessons as $lesson) {
                if ($lesson->preview) {
                    $introductionVideoUrl = $lesson->video_file_name;
                    break 2;
                }
            }
        }
        return Storage::url('course/videos/' . $introductionVideoUrl);
    }

    public function getQuizCount(): int
    {
        $quiz_count = 0;
        foreach ($this->modules as $module) {
            foreach ($module->lessons as $lesson) {
                if ($lesson->type === 'assessment') {
                    foreach ($lesson->assessments as $assessment) {
                        if ($assessment->type === 'quiz') {
                            $quiz_count++;
                        }
                    }
                }
            }
        }
        return $quiz_count;
    }
   public function reviews(): hasMany
    {
        return $this->hasMany(Review::class, with("reviewable_id"));
    }

}
