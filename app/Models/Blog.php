<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public static array $STATUSES = ['draft', 'published', 'rejected', 'pending'];
}
