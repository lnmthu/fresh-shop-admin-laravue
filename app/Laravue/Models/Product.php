<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;

    public function orders()
    {
        return $this->belongsToMany('App\Laravue\Models\Order', 'order_items', 'product_id', 'order_id')
            ->withPivot('qty', 'price', 'product_name', 'product_sku', 'product_description')
            ->withTimestamps();
    }
}
