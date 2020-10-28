<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'unique_id' => $this->unique_id,
            'order_code' => $this->code,
            'sub_total' => $this->sub_total,
            'total_price' => $this->total_price,
            'user' => [
                'user_id' => $this->user_id,
                'full_name' => $this->full_name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
            ],
            'shipping_fee' => $this->shipping_fee,
            'shipping_address' => $this->shipping_address,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'products' => OrderItemsResource::collection($this->products),
            'transaction' => new TransactionResource($this->transaction),
        ];
    }
}
