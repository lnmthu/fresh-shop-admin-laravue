<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    const STATUS_PENDING = 0;
    const STATUS_COMPLETED = 1;
    const STATUS_CANCELED = 2;

    protected $fillable = [
        'unique_id',
        'code',
        'order_id',
        'total_price',
        'sub_total',
        'payment_code',
        'payment_status',
    ];

    public function order()
    {
        return $this->belongsTo('App\Laravue\Models\Order');
    }
}
