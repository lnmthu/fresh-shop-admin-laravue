<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait; 
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\File;

class Category extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;
    protected $table="categories";
    protected $fillable=["id","unique_id","name",'sku',"parent_id","description","sort","status"];
    public function product(){
        return $this->hasMany('App\Laravue\Models\Product','category_unique_id','unique_id');
    }
    public function registerMediaCollections()
    {
        $this->addMediaCollection('images')
        ->acceptsMimeTypes(['image/jpeg','image/png','image/jpg'])
        ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(270)
                    ->height(270);
            });
    }

}



    
