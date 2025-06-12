<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static array $STATUSES = ['processing', 'completed', 'cancelled', 'refunded', 'failed'];

    public static array $PAYMENT_METHODS = ['VNPay', 'Momo'];

}
