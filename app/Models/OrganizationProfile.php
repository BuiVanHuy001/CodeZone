<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array, string[] $array1)
 */
class OrganizationProfile extends Model
{
	protected $primaryKey = 'user_id';
	public $incrementing = false;
	protected $guarded = [];
    protected $casts = [
        'socials_links' => 'array',
    ];

}
