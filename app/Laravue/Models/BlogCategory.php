<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'sort'
    ];

    public function blogItems()
    {
        return $this->hasMany(BlogItem::class)->orderBy('sort', 'asc');;
    }
}
