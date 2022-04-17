<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createProduct extends FormRequest
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
            'sub_category_id' => 'required|numeric',
            'name' => 'required|min:5|max:255',
            'price' => 'required|numeric|min:1000|max:999999999999',
            'old_price' => 'required|numeric|min:0|max:999999999999',
            'stock' => 'required|numeric|min:1|max:999999999',
            'order_number' => 'required|numeric|min:1|max:999999999',
            'description' => 'required|min:5',
        ];
    }
}
