<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createPost extends FormRequest
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

    // public function messages()
    // {
    //     return [
    //         'admin_id.required' => 'test',
    //     ];
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|boolean|max:1',
            'title' => 'required|max:255',
            'body' => 'required|min:1',
            'meta_keywords' => 'required|min:1',
            'image' => 'required|image',
        ];
    }
}
