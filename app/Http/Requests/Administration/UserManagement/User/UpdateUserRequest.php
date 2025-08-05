<?php

namespace App\Http\Requests\Administration\UserManagement\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name_update' => 'required',
            'email_update' => 'required',
            'status_update' => 'required',
        ];

    }

    public function messages(){
        return [
            'name_update.required' => 'Field Required',
            'email_update.required' => 'Field Required',
            'status_update.required' => 'Field Required',
        ];
    }
}
