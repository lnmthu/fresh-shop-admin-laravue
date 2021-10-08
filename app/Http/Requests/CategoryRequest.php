<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|max:100',
            'sku' => 'required|max:50',
            'sort' => 'required',
            'status' => 'required',
            'description' => 'required|min:5|max:25000',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Please Enter Name',
            'name.max' => 'Please Enter Name With Maximum of 100 Characters',
            'sku.required' => 'Please Enter Sku',
            'sku.max' => 'Please Enter Sku With Maximum of 50 Characters',
            'sort.required' => 'Please Select Sort',
            'status.required' => 'Please Select Status',
            'description.required' => 'Please Enter Description',
            'description.min' => 'Please Enter Description With Minimum of 5 Characters',
            'description.max' => 'Please Enter Description With Maximum of 25000 Characters',
        ];
    }
}
