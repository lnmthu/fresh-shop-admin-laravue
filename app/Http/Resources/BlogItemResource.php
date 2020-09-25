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
        if ($this->getFirstMedia() != null) {
            $image = $this->getFirstMedia()->getUrl();
        } else {
            $image = '';
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => new BlogCategoryResource($this->blogCategory),
            'user' => new UserResource($this->user),
            'image' => $image,
            'body' => $this->body,
            'sort' => $this->sort,
            'status' => $this->status,
        ];
    }
}
