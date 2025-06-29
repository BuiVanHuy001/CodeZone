<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    public static array $TYPES = ['file_upload' => 'Assignment', 'multiple_choice' => 'Multiple, Choice', 'true_false ' => 'True/False',];

    public static array $QUIZ_TYPES = ['multiple_choice' => 'Multiple Choice', 'true_false' => 'True/False',];
}
