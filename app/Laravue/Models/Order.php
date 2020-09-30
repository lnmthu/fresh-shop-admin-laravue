<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    //
    protected $fillable = [
        'unique_id', 'code', 'user_id', 'total_price', 'sub_total', 'shipping_fee', 'shipping_address', 'full_name', 'email', 'phone_number', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Laravue\Models\User', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Laravue\Models\Product', 'order_items', 'order_id', 'product_id')
            ->withPivot('qty', 'price', 'product_name', 'product_sku', 'product_description')
            ->withTimestamps();;
    }

    public function transaction()
    {
        return $this->hasOne('App\Laravue\Models\Transaction');
    }
}
