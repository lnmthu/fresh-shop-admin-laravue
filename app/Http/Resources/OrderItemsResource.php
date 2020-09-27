<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
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
            'product_id' => $this->id,
            'product_name' => $this->pivot->product_name,
            'product_sku' => $this->pivot->product_sku,
            'product_description' => $this->pivot->product_description,
            'qty' => $this->pivot->qty,
            'price' => $this->pivot->price,
        ];
    }
}
