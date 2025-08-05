<?php

namespace App\Http\Requests\Administration\UserManagement\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules()
    {
        return [
            'name_add' => 'required',
            'email_add' => 'required',
            'password_add' => 'required',
            'status_add' => 'required',
        ];

    }

    public function messages(){
        return [
            'name_add.required' => 'Field Required',
            'email_add.required' => 'Field Required',
            'password_add.required' => 'Field Required',
            'status_add.required' => 'Field Required',
        ];
    }
}
