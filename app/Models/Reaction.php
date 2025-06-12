<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    public static array $ACTIONS = ['like', 'dislike'];

    public static array $REACTABLE_TYPES = ['comment', 'course', 'review', 'blogs'];
}
