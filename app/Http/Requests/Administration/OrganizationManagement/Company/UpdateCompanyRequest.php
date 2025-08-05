<?php

namespace App\Http\Requests\Administration\OrganizationManagement\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'website_update' => 'required',
        ];

    }

    public function messages(){
        return [
            'name_update.required'=> 'Field Required',
            'email_update.required'=> 'Field Required',
            'website_update.required'=> 'Field Required',
        ];
    }
}
