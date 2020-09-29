<?php

namespace App\Http\Resources;

use App\Laravue\Models\BlogCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'child_count' => $this->blogItems->count(),
            'sort' => $this->sort,
        ];
    }
}
