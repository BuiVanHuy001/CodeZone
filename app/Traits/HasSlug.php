<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(static function (Model $model) {
            if (empty($model->slug)) {
                $slug = Str::slug($model->slugSourceField() ?? $this->name);
                $originalSlug = $slug;
                $count = 1;

                while ($model::where('slug', $slug)->exists()) {
                    $slug = "{$originalSlug}-{$count}";
                    $count++;
                }

                $model->slug = $slug;
            }
        });
    }
}
