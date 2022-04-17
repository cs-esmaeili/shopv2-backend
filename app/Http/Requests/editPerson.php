<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class editPerson extends FormRequest
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
            'person_id' => 'required',
            'role_id' => 'required|max:255',
            'name' => 'required|max:255',
            'family' => 'required|max:255',
            'username' => 'required|min:5|max:255',
        ];
    }
}
