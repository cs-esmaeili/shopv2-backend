<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class editPost extends FormRequest
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
            'post_id' => 'required|numeric',
            'title' => 'required|max:255',
            'title_old' => 'required|max:255',
            'body' => 'required|min:1',
            'meta_keywords' => 'required|min:1',
        ];
    }
}
