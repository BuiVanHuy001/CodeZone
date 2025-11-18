<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model {
    use HasSlug;

    protected $guarded = [];
}
