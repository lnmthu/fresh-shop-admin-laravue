<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;  

class Product extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;
    protected $table="products";
    protected $fillable=["id","name","sku","description","price","qty","category_id","sort","status"];
    public function category(){
        return $this->belongsTo('App/Category','category_id','id');
    }
}
