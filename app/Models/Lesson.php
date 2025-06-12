<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public static array $TYPES = ['video', 'document', 'assessment'];
}
