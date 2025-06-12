<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    public static array $TYPES = ['text', 'file_upload', 'multiple_choice', 'true_false'];
}
