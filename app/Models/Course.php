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
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory, HasSlug, HasUUID, HasDuration;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $STATUSES = ['draft', 'published', 'pending', 'rejected', 'deleted'];

    public static array $LEVELS = ['beginner', 'intermediate', 'advanced'];

    protected $casts = [
        'requirements' => 'array',
        'skills' => 'array',
        'target_audiences' => 'array',
    ];

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

    public function enrollments(): hasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }

    public function getThumbnailPath(): string
    {
        if ($this->thumbnail) {
            return Storage::url('course/thumbnails/' . $this->thumbnail);
        }
        return asset('images/others/thumbnail-placeholder.svg');
    }

    public function getFormattedPrice(): string
    {
        if ($this->price === 0) {
            return 'Free';
        }

        return number_format($this->price) . '₫';
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
                if (($lesson->type === 'assessment') && $lesson->assessment->type === 'quiz') {
                    $quiz_count++;
                }
            }
        }
        return $quiz_count;
    }

    public function getFormattedLesson(): string
    {
        return $this->lesson_count . ' ' . Str::plural('Lesson', $this->lesson_count);
    }

    public function getFormattedEnrollment(): string
    {
        return $this->enrollments()->count() . ' ' . Str::plural('student', $this->enrollments()->count());
    }

    public function getFormattedReview(): string
    {
        return $this->reviews()->count() . ' ' . Str::plural('review', $this->reviews()->count());
    }

    public function reviews(): hasMany
    {
        return $this->hasMany(Review::class, with("reviewable_id"));
    }

}
