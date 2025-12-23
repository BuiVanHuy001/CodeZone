<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model {
    use HasFactory, HasSlug, HasUUID, HasDuration, SoftDeletes;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $STATUSES = [
        'published' => ['label' => 'Công khai', 'class' => 'success'],
        'draft' => ['label' => 'Bản nháp', 'class' => 'secondary'],
        'pending' => ['label' => 'Chờ duyệt', 'class' => 'warning'],
        'rejected' => ['label' => 'Từ chối', 'class' => 'danger'],
        'suspended' => ['label' => 'Đã khóa', 'class' => 'dark']
    ];

    public static array $LEVELS = [
        'beginner' => ['label' => 'Cơ bản', 'class' => 'info'],
        'intermediate' => ['label' => 'Trung cấp', 'class' => 'primary'],
        'advanced' => ['label' => 'Nâng cao', 'class' => 'danger'],
        'all_levels' => ['label' => 'Tất cả', 'class' => 'success']
    ];

    public static array $TYPES = [
        'free' => 'Miễn phí',
        'paid' => 'Trả phí',
        'internal' => 'Chính quy',
    ];

    protected $casts = [
        'requirements' => 'array',
        'skills' => 'array',
        'target_audiences' => 'array',
    ];

    public function modules(): hasMany
    {
        return $this->hasMany(Module::class);
    }

    public function lessons(): HasManyThrough|Course
    {
        return $this->hasManyThrough(
            Lesson::class,
            Module::class,
            'course_id',
            'module_id',
            'id',
            'id'
        );
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'course_id');
    }

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany('App\Models\Review', 'reviewable');
    }

    public function enrollments(): hasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function trackingProgresses(): HasManyThrough
    {
        return $this->hasManyThrough(TrackingProgress::class, Module::class);
    }

    public function lessonsThroughModules(): HasManyThrough
    {
        return $this->hasManyThrough(
            Lesson::class,
            Module::class,
            'course_id',
            'module_id',
            'id',
            'id'
        );
    }

    public function slugSourceField(): string
    {
        return $this->title;
    }

    public function getThumbnailPath(): string
    {
        if ($this->thumbnail) {
            if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
                return $this->thumbnail;
            }

            if (str_starts_with($this->thumbnail, '/storage/')) {
                return $this->thumbnail;
            }

            if (str_starts_with($this->thumbnail, 'storage/')) {
                return '/' . $this->thumbnail;
            }

            return Storage::url('course/thumbnails/' . $this->thumbnail);
        }
        return asset('images/others/thumbnail-placeholder.svg');
    }

    public function detailsPageUrl(): Attribute
    {
        return Attribute::get(fn() => route('page.course_detail', $this->slug));
    }
}
