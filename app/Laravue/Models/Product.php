<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\File;

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;
    protected $table = "products";
    protected $fillable = ["id","unique_id", "name", "sku", "description", "price", "qty", "category_unique_id", "sort", "status"];
    public function category()
    {
        return $this->belongsTo('App\Laravue\Models\Category', 'category_unique_id', 'unique_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Laravue\Models\Order', 'order_items', 'product_id', 'order_id')
            ->withPivot('qty', 'price', 'product_name', 'product_sku', 'product_description')
            ->withTimestamps();
    }
    public function registerMediaCollections()
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/jpg'])
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(270)
                    ->height(270);
            });
    }
}
