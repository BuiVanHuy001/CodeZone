<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasUUID;

    protected $guarded = [];

    public $incrementing = false;
    protected $keyType = 'string';

    public static array $STATUSES = ['processing', 'completed', 'cancelled', 'cart', 'failed'];

    public static array $PAYMENT_METHODS = ['VNPay', 'Momo'];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'order_id');
    }

    public function items(): hasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
