<?php

namespace App\Http\Requests\BlogItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogItemRequest extends FormRequest
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
            'title' => 'required|unique:blog_items,title,' . $this->id,
            'description' => 'required',
            'body' => 'required',
            'user_id' => 'required',
            'blog_category_id' => 'required',
            'sort' => 'min:0',
        ];
    }
}
