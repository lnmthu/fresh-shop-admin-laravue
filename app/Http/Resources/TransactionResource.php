<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'code' => $this->code,
            'order_id' => $this->order_id,
            'total_price' => $this->total_price,
            'sub_total' => $this->sub_total,
            'payment_code' => $this->payment_code,
            'payment_status' => $this->payment_status,
        ];
    }
}
