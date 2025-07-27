<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammingAssignmentDetails extends Model {
    protected $guarded = [];

    public static array $SUPPORTED_LANGUAGES = [
        'python' => 'Python',
        'js' => 'JavaScript',
        'java' => 'Java',
        'cpp' => 'C++',
        'php' => 'PHP',
    ];
}
