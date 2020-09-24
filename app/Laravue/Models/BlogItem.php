<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'body', 'sort', 'user_id', 'blog_category_id', 'status'
    ];

    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id')->orderBy('sort', 'ASC');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
