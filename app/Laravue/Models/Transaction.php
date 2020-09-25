<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
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
