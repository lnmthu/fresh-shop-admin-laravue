<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table="categories";
    protected $fillable=["id","name","parent_id","description","sort","status"];
    public function product(){
        return $this->hasMany('App/Product','category_id','id');
    }

}



    
