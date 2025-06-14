<?php

namespace App\Models;

use App\Models\database\factories\CourseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory, SoftDeletes;

    public static array $STATUSES = ['draft', 'published', 'pending', 'rejected', 'deleted'];

    public static array $LEVELS = ['beginner', 'intermediate', 'advanced'];
}
