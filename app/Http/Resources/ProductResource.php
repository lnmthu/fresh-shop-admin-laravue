<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            $img=$this->getFirstMedia('images')->getFullUrl('thumb');
        }
        return [
            'id' => $this->id,
            'unique_id' => $this->unique_id,
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'sort' => $this->sort,
            'status' => $this->status,
            'price' => $this->price,
            'qty' => $this->qty,
            'category_unique_id' => $this->category_unique_id,
            'image_uri' => $img,
            'created_at' => $this->created_at,
            'category_detail'=> new CategoryResource($this->category),
        ];
    }
}
