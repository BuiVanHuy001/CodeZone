<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammingAssignmentDetails extends Model {
    protected $guarded = [];

    public static array $SUPPORTED_LANGUAGES = [
        'python' => 'Python',
        'javascript' => 'JavaScript',
        'java' => 'Java',
        'c++' => 'C++',
        'php' => 'PHP',
    ];
}
