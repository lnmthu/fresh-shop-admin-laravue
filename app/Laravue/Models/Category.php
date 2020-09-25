<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait; 

class Category extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;
    protected $table="categories";
    protected $fillable=["id","name","parent_id","description","sort","status"];
    public function product(){
        return $this->hasMany('App/Product','category_id','id');
    }

}



    
