<?php

namespace App\Models;

use App\Traits\HasDuration;
use App\Traits\HasSlug;
use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasSlug, HasUUID, HasDuration;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $TYPES = ['video', 'document', 'assessment'];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    //    public function assessments()
    //    {
    //
    //    }

    public function slugSourceField(): string
    {
        return $this->title;
    }
}
