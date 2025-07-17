<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public static array $STATUSES = ['processing', 'completed', 'cancelled', 'refunded', 'failed'];

    public static array $PAYMENT_METHODS = ['VNPay', 'Momo'];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'order_id');
    }
}
