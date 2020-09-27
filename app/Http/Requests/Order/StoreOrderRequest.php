<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'sub_total' => 'required|numeric',
            'total_price' => 'required|numeric',
            'user_id' => 'required',
            'full_name' => 'required|max:255',
            'email' => 'required|email',
            'phone_number' => 'required',
            'shipping_fee' => 'required',
            'shipping_address' => 'required',
        ];
    }
}
