<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'sometimes|required',
            'name' => 'sometimes | required | string | max:255',
            'role' => 'sometimes | nullable | string | max:255',
            // 'email' => 'sometimes | nullable | string | email | max:255 | unique:users',
            'password' => 'sometimes | required | string | min:8 | confirmed',
            'phone' => 'sometimes|nullable|min:11|min:15|numeric',
            'image' => 'sometimes|nullable|image|mimes:jpeg,bmp,png,jpg|max:2000',
        ];
    }
}
