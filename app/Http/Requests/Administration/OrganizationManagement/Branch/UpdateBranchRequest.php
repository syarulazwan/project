<?php

namespace App\Http\Requests\Administration\OrganizationManagement\Branch;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
            'company_update' => 'required',
            'branch_update' => 'required',
        ];

    }

    public function messages(){
        return [
            'company_update.required'=> 'Field Required',
            'company_update.required'=> 'Field Required',
        ];
    }
}
