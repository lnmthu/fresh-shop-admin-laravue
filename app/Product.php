<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table="products";
    protected $fillable=["id","name","sku","description","price","qty","category_id","sort"];
    public function category(){
        return $this->belongsTo('App/Category','category_id','id');
    }
}
