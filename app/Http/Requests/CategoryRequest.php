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
            'name' => 'required|min:10|max:100',
            'sort' => 'required',
            'status' => 'required',
            'description' => 'required|min:50|max:250',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Please Enter Name',
            'name.min' => 'Please Enter Name With Minimum of 10 Characters',
            'name.max' => 'Please Enter Name With Maximum of 100 Characters',
            'sort.required' => 'Please Select Sort',
            'status.required' => 'Please Select Status',
            'description.required' => 'Please Enter Description',
            'description.min' => 'Please Enter Description With Minimum of 50 Characters',
            'description.max' => 'Please Enter Description With Maximum of 250 Characters',
        ];
    }
}
