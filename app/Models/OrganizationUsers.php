<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationUsers extends Model
{
	protected $guarded = [];

	public static array $STATUSES = ['active' => 'Active', 'inactive' => 'Inactive', 'pending' => 'Pending',];
}
