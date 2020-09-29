<?php

namespace App\Http\Requests\BlogCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogCategoryRequest extends FormRequest
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
            'title' => 'required|unique:blog_categories,title,' . $this->id,
            'description' => 'required',
            'sort' => 'min:0',
        ];
    }
}
