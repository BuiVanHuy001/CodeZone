<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUUID
{
	public static function bootHasUUID(): void
	{
		static::creating(function (Model $model) {
			if (!$model->getKey()) {
				$model->setAttribute('id', (string)Str::uuid());
			}
		});
	}
}
