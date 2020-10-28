<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->getFirstMedia('blog') != null) {
            if( $this->getFirstMedia('blog')->hasGeneratedConversion('blog')){
                $image = $this->getFirstMedia('blog')->getFullUrl('blog');
            }else{
                $image = $this->getFirstMedia('blog')->getFullUrl();
            }
        } else {
            $image = '';
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'blog_category_id' => $this->blog_category_id,
            'category' => new BlogCategoryResource($this->blogCategory),
            'user_id' => $this->user_id,
            'user' => new UserResource($this->user),
            'image' => $image,
            'body' => $this->body,
            'sort' => $this->sort,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
