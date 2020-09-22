<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
        'parent_id',
        'description',
        'sort',
        'status',
    ];
}
