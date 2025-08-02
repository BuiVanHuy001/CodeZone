<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationUser extends Model
{
	protected $guarded = [];

	public static array $STATUSES = [
		'active' => 'Active',
		'inactive' => 'Inactive',
		'pending' => 'Pending'
	];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organization_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
