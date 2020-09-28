<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $img=null;
        if($this->getFirstMedia('images')){
            $img=$this->getFirstMedia('images')->getUrl('thumb');
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'description' => $this->description,
            'sort' => $this->sort,
            'status' => $this->status,
            'image_uri' => $img,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
