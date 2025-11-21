<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasCodeNormalization {
    protected function normalizeCode(string $code): string
    {
        $cleanCode = Str::slug($code, '');
        return strtoupper($cleanCode);
    }
}
